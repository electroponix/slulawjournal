<?php
class ccParser {
	var $settings=array();

	function ccParser() {

	}

	/*
	 * $home = WP home URL
	 * $url = remote URL
	 *
	 */
	function parse($buffer,$home,$url,$slug) {
		$tmp=explode('://',$url,2);
		$tmp2=explode('/',$tmp[1],2);
		$sub=str_replace($tmp[0].'://'.$tmp2[0],'',$url).'/';

		$fullUrl=$url;

		foreach ($this->settings as $tag => $a) {
			foreach ($a as $u) {
				if ($u=='URL') $fullUrl=$url;
				else $fullUrl=$u;
				if (!empty($tag)) {
					if ($tag=='src') {
						$f[]='/'.$tag.'\=\"'.preg_quote($fullUrl,'/').'(.*?)\"/';
						$r[]=$tag.'="'.$url.'$1'.'"';
					} else {
							
						$f[]='/'.$tag.'\=\"'.preg_quote($fullUrl,'/').'([a-zA-Z\_]*?).php\"/';
						$r[]=$tag.'="'.$home.'bridge='.$slug.'&bridgepage=$1'.'"';

						$f[]='/'.$tag.'\=\"'.preg_quote($fullUrl,'/').'([a-zA-Z\_]*?).php.(.*?)\"/';
						$r[]=$tag.'="'.$home.'bridge='.$slug.'&bridgepage=$1&$2'.'"';
					}
				} else {
					$f[]='/'.preg_quote($fullUrl,'/').'([a-zA-Z\_]*?).php/';
					$r[]=$home.'bridge='.$slug.'&bridgepage=$1';

					$f[]='/'.preg_quote($fullUrl,'/').'([a-zA-Z\_]*?).php.(.*?)/';
					$r[]=$home.'bridge='.$slug.'&bridgepage=$1&$2';
				}
			}
		}
		$buffer=preg_replace($f,$r,$buffer,-1,$count);

		return $buffer;
	}

	function set($id,$value) {
		$this->settings[$id]=$value;
	}
}