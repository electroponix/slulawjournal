<?php
class ccBridge {
	var $version;
	var $name;
	var $slug;
	var $settings=array();
	var $sidebars=array();
	var $hidden=array('class'=>array(),'id'=>array());
	var $connectUrl;

	function ccBridge($version,$name,$slug,$dir) {
		$this->version=$version;
		$this->name=$name;
		$this->slug=$slug;
		$this->parser=new ccParser();
		$plugin=str_replace(realpath($dir.'/..'),"",$dir);
		$plugin=substr($plugin,1);
		$this->url=WP_CONTENT_URL . "/plugins/".$plugin."/";
	}

	function hideClass($c) {
		$this->hidden['class'][]=$c;
	}

	function hideId($i) {
		$this->hidden['id'][]=$i;
	}

	function admin_notices() {
		global $wpdb;
		$errors=array();
		$warnings=array();
		$files=array();
		$dirs=array();

		$version=get_option($this->slug."_version");
		if ($version && $version != $this->version) $warnings[]='You downloaded version '.$this->version.' and need to update your settings (currently at version '.$version.') from the <a href="options-general.php?page='.$this->slug.'">control panel</a>.';
		$upload=wp_upload_dir();
		if (!is_writable(session_save_path())) $warnigns[]='It looks like PHP sessions are not properly configured on your server, the sessions save path <'.session_save_path().'> is not writable. This may be a false warning, contact us if in doubt.';
		if ($upload['error']) $errors[]=$upload['error'];
		if (!get_option($this->slug.'_url')) $warnings[]="Please update your ".$this->name." connection settings on the plugin control panel";
		if (get_option($this->slug.'_debug')) $warnings[]="Debug is active, once you finished debugging, it's recommended to turn this off";
		if (phpversion() < '5') $warnings[]="You are running PHP version ".phpversion().". We recommend you upgrade to PHP 5.3 or higher.";
		if (ini_get("zend.ze1_compatibility_mode")) $warnings[]="You are running PHP in PHP 4 compatibility mode. We recommend you turn this option off.";
		if (!function_exists('curl_init')) $errors[]="You need to have cURL installed. Contact your hosting provider to do so.";

		if (count($warnings) > 0) {
			echo "<div id='zing-warning' style='background-color:greenyellow' class='updated fade'><p><strong>";
			foreach ($warnings as $message) echo $this->name.': '.$message.'<br />';
			echo "</strong> "."</p></div>";
		}
		if (count($errors) > 0) {
			echo "<div id='zing-warning' style='background-color:pink' class='updated fade'><p><strong>";
			foreach ($errors as $message) echo $this->name.':'.$message.'<br />';
			echo "</strong> "."</p></div>";
		}

		return array('errors'=> $errors, 'warnings' => $warnings);
	}

	function isActive() {
		if (get_option($this->slug.'_version')) return true;
		else return false;
	}
	/**
	 * Activation: creation of database tables & set up of pages
	 * @return unknown_type
	 */
	function activate() {
		//nothing much to do
	}

	function install() {
		$version=get_option($this->slug."_version");

		//create pages
		if (!$version) {
			$pages=array();
			$pages[]=array($this->name,$this->name,"*",0);

			$ids="";
			foreach ($pages as $i =>$p)
			{
				$my_post = array();
				$my_post['post_title'] = $p['0'];
				$my_post['post_content'] = '';
				$my_post['post_status'] = 'publish';
				$my_post['post_author'] = 1;
				$my_post['post_type'] = 'page';
				$my_post['menu_order'] = 100+$i;
				$my_post['comment_status'] = 'closed';
				$id=wp_insert_post( $my_post );
				if (empty($ids)) { $ids.=$id; } else { $ids.=",".$id; }
				if (!empty($p[1])) add_post_meta($id,$this->slug.'_page',$p[1]);
			}
			if (get_option($this->slug."_pages")) update_option($this->slug."_pages",$ids);
			else add_option($this->slug."_pages",$ids);
		} elseif ($version <= '1.0.0') {
			
			$my_post = array();
			$my_post['ID']=$this->mainpage();
			$my_post['post_content']='[wikiful url='.get_option($this->slug.'_url').']';
			wp_update_post($my_post);
			delete_post_meta($my_post['ID'],$this->slug.'_page');
		}

		//update version
		update_option($this->slug."_version",$this->version);

		return true;
	}

	/**
	 * Deactivation: nothing to do
	 * @return void
	 */
	function deactivate() {
		$ids=get_option($this->slug."_pages");
		$ida=explode(",",$ids);
		foreach ($ida as $id) {
			wp_delete_post($id);
		}
		$f=$this->slug.'_options';
		$options=$f();

		delete_option($this->slug.'_log');
		foreach ($options as $value) {
			delete_option( $value['id'] );
		}

		delete_option($this->slug."_log");
		delete_option($this->slug."_version");
		delete_option($this->slug."_pages");
		delete_option($this->slug."_url");
		delete_option($this->slug.'-support-us');
	}

	function output() {
		global $post;
		global $wpdb;
		global $wordpressPageName;
		global $toInclude;

		$ajax=false;

		if (isset($post)) $cf=get_post_custom($post->ID); else $cf=array();
		if (isset($_REQUEST['bridgepage']) && (isset($_REQUEST['ajax']) && $_REQUEST['ajax'])) {
			$toInclude=$_REQUEST['bridgepage'];
			$ajax=intval($_REQUEST['ajax']);
		} elseif (isset($_REQUEST['bridgepage'])) {
			$toInclude=$_REQUEST['bridgepage'];
		} elseif (isset($cf[$this->slug.'_page'])) {
			$toInclude="index";
		} else {
			$toInclude="index";
		}

		$http=$this->http($toInclude);
		$this->log('Notification','Call: '.$http);
		//echo '<br />'.$http.'<br />';
		$news = new zHttpRequest($http,$this->slug);
		if (isset($news->post[$this->slug.'_name'])) {
			$news->post['name']=$news->post[$this->slug.'_name'];
			unset($news->post[$this->slug.'_name']);
		}

		if (!$news->curlInstalled()) {
			$this->log('Error','CURL not installed');
			return "cURL not installed";
		} elseif (!$news->live()) {
			$this->log('Error','A HTTP Error occured');
			return "A HTTP Error occured";
		} else {
			$output=$news->DownloadToString();
			$this->httpCode=$news->httpCode;
			return $output;
		}
	}

	function shortcodeHandler($atts) {
		if (isset($atts[0]) && $atts[0]) $this->connectUrl=$atts[0];
		elseif (isset($atts['url']) && $atts['url']) $this->connectUrl=$atts['url'];
		$this->connect();
		return $this->html['main'];
	}
	
	/**
	 * Page content filter
	 * @param $content
	 * @return unknown_type
	 */
	function content($content) {
		global $post;

		return $content;
		$cf=get_post_custom($post->ID);
		
		if (isset($_REQUEST['bridgepage']) || (isset($cf[$this->slug.'_page']))) {
			if ($this->html) {
				$content='';
				$content.=$this->html['main'];
				if (get_option($this->slug.'_footer')) $content.=$this->footer();
			}
		}

		return $content;
	}

	function header() {
		if (isset($this->html['head'])) echo $this->html['head'];

		//echo '<link rel="stylesheet" type="text/css" href="' . $this->url . 'cc.css" media="screen" />';
		//echo '<script type="text/javascript" src="'. $this->url . 'cc.js"></script>';
		if (get_option($this->slug.'_css')) {
			echo '<style type="text/css">'.get_option($this->slug.'_css').'</style>';
		}
		if ((count($this->hidden['class']) > 0) || (count($this->hidden['id']) > 0)) {
			echo '<style type="text/css">';
		}
		if (count($this->hidden['class']) > 0) {
			foreach ($this->hidden['class'] as $c) {
				echo '.'.$c.'{display:none}';
			}
		}
		if (count($this->hidden['class']) > 0) {
			foreach ($this->hidden['id'] as $c) {
				echo '#'.$c.'{display:none}';
			}
		}
		if ((count($this->hidden['class']) > 0) || (count($this->hidden['id']) > 0)) {
			echo '</style>';
		}
	}

	function admin_header() {
		echo '<link rel="stylesheet" type="text/css" href="' . $this->url . 'admin.css" media="screen" />';
	}

	function http($page="index") {
		global $wpdb;

		$vars="";
		$http=$this->url(); //.'/'.$page.'.php';
		$and="";
		if (count($_GET) > 0) {
			foreach ($_GET as $n => $v) {
				if ($n!="page_id" && $n!="bridgepage")
				{
					$vars.= $and.$n.'='.$v;
					//$vars.= $and.$n.'='.urlencode($v);
					$and="&";
				}
			}
		}

		if ($vars) $http.='?'.$vars;

		//echo '<br />'.$http.'<br />';
		
		return $http;
	}

	function title($title,$id=0) {
		global $post;
		if (isset($post) && ($post->ID==$this->mainpage()) && isset($this->html['title'])) return $title.$this->html['title'].' | ';
		else return $title;
	}

	function default_page($pid) {
		$isPage=false;
		$ids=get_option($this->slug."_pages");
		$ida=explode(",",$ids);
		foreach ($ida as $id) {
			if (!empty($id) && $pid==$id) $isPage=true;
		}
		return $isPage;
	}

	function mainpage() {
		$ids=get_option($this->slug."_pages");
		$ida=explode(",",$ids);
		return $ida[0];
	}

	/**
	 * Initialization of page, action & page_id arrays
	 * @return unknown_type
	 */
	function init()
	{
		global $wp_query;
		ob_start();
		if (!session_id()) session_start();
	}
	
	function connect() {
		$buffer=$this->output();

		if ($buffer) {
			$html = new simple_html_dom();
			$html->load($buffer);
			$main=trim($html->find($this->settings['main'], 0)->innertext);

			$this->html['head']='';
			$this->html['main']=$this->parser->parse($main,$this->home(),$this->url(),$this->slug);

			$this->html['sidebars']=array();
			if (count($this->sidebars) > 0) {
				$i=0;
				foreach ($this->sidebars as $sidebar) {
					$i++;
					$s=trim($html->find($sidebar['id'], 0)->innertext);
					$this->html['sidebars'][$this->slug.'-widget-'.$i]=$this->parser->parse($s,$this->home(),$this->url(),$this->slug);
				}
			}

			$t=trim($html->find('title', 0)->innertext);
			$this->html['title']=$this->parser->parse($t,$this->home(),$this->url(),$this->slug);
		} elseif ($this->httpCode=='404') {
			$this->html['head']='';
			$this->html['main']=_('Error 404 - Page not found').'<br />'.'<a href="'.$this->home().'">'._('Return to previous page').'</a>';
			$this->html['sidebars']=array();
		} else {
			$this->html['head']='';
			$this->html['main']='';
			$this->html['sidebars']=array();
		}
	}

	function registerWidgets() {
		if (count($this->sidebars) > 0) {
			$i=0;
			foreach ($this->sidebars as $sidebar) {
				$i++;
				wp_register_sidebar_widget($this->slug.'-widget-'.$i,$this->name.' '.$sidebar['name'], array($this,'widget'.$i),array('description' => $this->name.' '.$sidebar['name']));
			}
		}
	}

	function widget($args, $params=array()) {
		extract( $args );
		if (!isset($this->html['sidebars'][$widget_id])) {
			$this->connect();
		}
		if (!isset($this->html['sidebars'][$widget_id])) return;
		$title = apply_filters('widget_title', $widget_name);
		echo $before_widget;
		echo $before_title . $title . $after_title;
		if (isset($this->html['sidebars'][$widget_id])) echo $this->html['sidebars'][$widget_id];
		echo $after_widget;
	}

	function widget1($args, $params=array()) {
		$this->widget($args,$params);
	}

	function widget2($args, $params=array()) {
		$this->widget($args,$params);
	}

	function set($id,$value) {
		$this->settings[$id]=$value;
	}

	function setSidebar($name,$id) {
		$this->sidebars[]=array('id' => $id,'name' => $name);
	}

	function log($type=0,$msg='',$filename="",$linenum=0) {
		if (get_option($this->slug.'_debug')) {
			if (is_array($msg)) $msg=print_r($msg,true);
			$v=get_option($this->slug.'_log');
			if (!is_array($v)) $v=array();
			array_unshift($v,array(time(),$type,$msg));
			update_option($this->slug.'_log',$v);
		}
	}

	function url() {
		$url=$this->connectUrl ? $this->connectUrl : get_option($this->slug.'_url');
		if (substr($url,-1)=='/') $url=substr($url,0,-1);
		return $url.'/';
	}

	function footer($nodisplay=true) {
		$msg='<div style="position:relative;clear:both"></div>';
		$msg.='<center style="margin-top:15px;font-size:small">';
		$msg.='Wordpress and '.$this->name.' integration by <a href="http://www.zingiri.com" target="_blank">Zingiri</a>';
		$msg.='</center>';
		if ($nodisplay===true) return $msg;
		else echo $msg;

	}

	function home() {
		global $post;
		
		//$pageID = $this->mainpage();
		$pageID = $post->ID;

		if (get_option('permalink_structure')){
			$homePage = get_option('home');
			$wordpressPageName = get_permalink($pageID);
			$wordpressPageName = str_replace($homePage,"",$wordpressPageName);
			$home=$homePage.$wordpressPageName;
			if (substr($home,-1) != '/') $home.='/';
			$home.='?';
		}else{
			$home=get_option('home').'/?page_id='.$pageID.'&';
		}

		return $home;
	}
}