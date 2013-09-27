<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Citeus Legalus - The automated Bluebook citation generator.</title>
    <meta name="description" content="Citus Legalus is an automated Bluebook citation generator for lazy law students." />
	<meta name="keywords" content="bluebook, blue book, citation, law, law review, law journal, citation generator, law school, legal, legal writing, lawschool" />
    <link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" href="/_design/style.css" type="text/css" media="screen" />
	<script type="text/javascript" src="/_design/_js/jquery.min.js" language="Javascript"></script>
	<script type="text/javascript" src="/_design/_js/jquery-ui.min.js" language="Javascript"></script>
    <script type="text/javascript" src="/_design/_js/index.js" language="Javascript"></script>
    <script type="text/javascript" src="/_design/_js/tabber.js" language="Javascript"></script>
<script type="text/javascript" src="/_design/_js/popup.js" language="Javascript"></script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28567154-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

</head>
<body>
<div class="head">
	<table><tr><td>
    <h1><a href="/" ><b>Citus Legalus - The Citation Generator for Lazy Law Students.</b></a></h1>
    </td><td>
    	<a href="/briefcase" id="scb" ><b>Saved Citations Briefcase</b></a>
    </td></tr></table>
</div>
<div class="wrap">
<noscript><blockquote id="warning"><b>Warning:</b>  Javascript is not enabled! Citeus Legalus requires Javascript for proper operation. Please enable it.</blockquote></noscript><img src="/_design/_img/logo_index.png" class="logo_index" /><blockquote class="index"><span style="font-variant:small-caps;">What</span> <sup>shall</sup> <i>we</i> <sub>cite</sub> (today)?</blockquote>
<br style="clear:both;" />
<div class="ad index">
	<script type="text/javascript"><!--
    google_ad_client = "ca-pub-0640773061099709";
    /* CiteusLegalus - Leaderboard */
    google_ad_slot = "0656061755";
    google_ad_width = 728;
    google_ad_height = 90;
    //-->
    </script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
</div>
<br style="clear:both;" />
<table><tr>
	<td>
        <div class="index_button">
        	<table><tr><td class="i">
            	<img src="/_design/_img/icons/cases.png" alt="Bluebook Cite Cases" />
            </td><td>
                <h3>Cases <span style="display:inline-block; background:#FF0000; color:#FFFF00; border-radius:3px; padding:3px;">(NEW!)</span></h3>
                <span>Federal Cases - State Cases</span>
                <li class="s"><a href="/cite/cases/allreporters">Find a Reporter</a></li>
                <li class="m"><a href="/cite/cases">Manual Entry</a></li>
            </td></tr></table>
        </div>
	</td>
	<td>
        <div class="index_button">
        	<table><tr><td class="i">
            	<img src="/_design/_img/icons/periodical.png" alt="Bluebook Cite Periodicals" />
            </td><td>
                <h3>Periodicals</h3>
                <span>Law Reviews - Law Journals - Academic Publications - Newspapers</span>
                <li class="s"><a href="/cite/periodical/allperiodicals">Find a Periodical</a></li>
                <li><a href="" class="ris_upload_link_p">From EndNote (.ris)</a></li>
                <li><a href="" class="pubmed_upload_link">From PubMed (.xml)</a></li>
                <li class="m"><a href="/cite/periodical">Manual Entry</a></li>
            </td></tr></table>
        </div>
	</td></tr>
    <tr><td>
        <div class="index_button">
        	<table><tr><td class="i">
            	<img src="/_design/_img/icons/nonperiodical.png" alt="Bluebook Cite Nonperiodicals" />
            </td><td>
                <h3>Books, Reports, &amp; Nonperiodicals</h3>
                <span>Books - Reports - Gov't Publications</span>
                <li class="s"><a href="" class="gbooks_search_link">Search and Cite</a></li>
                <li><a href="" class="ris_upload_link_n">From EndNote (.ris)</a></li>
                <li class="m"><a href="/cite/nonperiodical">Manual Entry</a></li>
            </td></tr></table>
        </div>
	</td><td>
        <div class="index_button">
        	<table><tr><td class="i">
           		<img src="/_design/_img/icons/statutes.png" alt="Bluebook Cite Statutes" />
            </td><td>
                <h3>Statutes &amp; Administrative Regulations</h3>
                <span>Federal and State Statutes - Codes - Administrative Regulations</span>
                <li class="m"><a href="/cite/statutes">Manual Entry Forms</a></li>
            </td></tr></table>
        </div>
	</td></tr>
    <tr><td>
        <div class="index_button">
        	<table><tr><td class="i">
           		<img src="/_design/_img/icons/legislativematerials.png" alt="Bluebook Cite Legislative Materials" />
            </td><td>
                <h3>Legislative Materials</h3>
                <span>Acts - Session Laws - Resolutions - Legislative Services</span>
                <li class="m"><a href="/cite/legislativematerials">Manual Entry Forms</a></li>
            </td></tr></table>
        </div>
	</td><td>
        <div class="index_button">
        	<table><tr><td class="i">
            	<img src="/_design/_img/icons/administrative.png" alt="Bluebook Cite Administrative Materials" />
            </td><td>
                <h3>Administrative Materials</h3>
                <span>Patents - Trademarks - Treasury Documents - SEC Filings</span>
                <li class="m"><a href="/cite/administrativematerials">Manual Entry Forms</a></li>
            </td></tr></table>
        </div>
	</td></tr>
    <tr><td>
        <div class="index_button">
        	<table><tr><td class="i">
            	<img src="/_design/_img/icons/constitution.png" alt="Bluebook Cite Constitutions" />
            </td><td>
                <h3>Constitutions</h3>
                <span>U.S. Constitution - State Constitutions</span>
                <li class="m"><a href="/cite/constitution">Manual Entry</a></li>
            </td></tr></table>
        </div>
	</td><td>
        <div class="index_button">
        	<table><tr><td class="i">
            	<img src="/_design/_img/icons/about.png" alt="About" />
            </td><td>
                <h3>About</h3>
                <span>About the Site - Contact Kirk - Disclaimer</span>
                <li class="m"><a href="/about">About</a></li>
                <li class="m"><a href="/disclaimer">Disclaimer</a></li>
            </td></tr></table>
        </div>
    </td></tr>
</table>

<div id="pubmed_upload" class="ipopup">
	<div class="ihead"></div>
	<div class="ibody">
    	<form method="post" enctype="multipart/form-data" action="/cite/periodical">
        <input type="hidden" name="type" value="pubmedxml" />
            <h3>Upload a PubMed XML File</h3>
        
            <label for="pubmed">File:</label><input name="pubmed" type="file" size="45" /><br />  
            <i>Warning: This system currently requires UTF-8 .xml files with no formatting quirks.  If you don't know what that is, you should probably do <a href="/cite/periodical">manual entry.</a></i><br />      
            <input type="submit" value="Upload and Process" name="submit">
        </form>
	</div>
	<div class="ifoot"></div>
</div>

<div id="ris_upload_n" class="ipopup">
	<div class="ihead"></div>
	<div class="ibody">
    	<form method="post" enctype="multipart/form-data" action="/">
        <input type="hidden" name="type" value="risfile" />
            <h3>Upload an Endnote (.ris) File - Nonperiodical</h3>
        
            <label for="ris">File:</label><input name="ris" type="file" size="45" /><br />   
            <input type="hidden" name="rtype" value="15" /><br />
            <input type="submit" value="Upload and Process" name="submit">
        </form>
	</div>
	<div class="ifoot"></div>
</div>

<div id="ris_upload_p" class="ipopup">
	<div class="ihead"></div>
	<div class="ibody">
    	<form method="post" enctype="multipart/form-data" action="/">
        <input type="hidden" name="type" value="risfile" />
            <h3>Upload an Endnote (.ris) File - Periodical</h3>
        
            <label for="ris">File:</label><input name="ris" type="file" size="45" /><br />   
            <input type="hidden" name="rtype" value="16" /><br />
            <input type="submit" value="Upload and Process" name="submit">
        </form>
	</div>
	<div class="ifoot"></div>
</div>

<div id="gbooks_search" class="ipopup">
	<div class="ihead"></div>
	<div class="ibody">
      <form id="mainSearchForm" action="/cite/gsearch" method="post">
        <h3>Search for a Book</h3>
        <input name="searchTerm" type="text" id="atitle" value="">
        <input type="submit" value="Search for Book">
        <img src="http://books.google.com/googlebooks/images/poweredby.png" style="padding:10px;">
      </form>
	</div>
	<div class="ifoot"></div>
</div></div>
<div class="foot">
	Programmed and Maintained by Kirk Sigmon, Cornell Law '13.
</div>
</body>
