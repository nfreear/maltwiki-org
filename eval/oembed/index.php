<?php
/**
  oEmbed Accessible Player API.
  http://oembed.com

  Copyright 2009-02-03, 05-16 N.D.Freear, Open University
*/
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);

require_once '../lib/data.php';
require_once '../lib/players.php';

function _get($name, $default=null) {
  return isset($_GET[$name]) ? $_GET[$name] : $default;
}

  #header('Content-Type: text/html; charset=UTF-8');
  header('Content-Type: text/javascript; charset=UTF-8');
  @header('Content-Language: '. $lang);
  @header('X-Powered-By:');


# http://oembed.com/
$res = (object)array(); #StdClass();
$res->version = '1.0';
$res->type = 'video';
$res->http_status = 200;

$res->lang = _get('cl','en');  # en-GB | es | de.
$url  = str_replace('www.', '', _get('url'));
$title= _get('t', 'this');
$agent= _get('a');  #Greasemonkey.
$std_attrs = 'lang="en" id="malt-0" style="font-size:medium"';

$player = new ccPlayerAS3(); #cc (jw, dot).
$localhost = 'http://localhost:8888/tt/'; #.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']).'/';

$media  = $count = $others = null;
foreach ($metas as $key => $meta) {
  if (0===strpos($url, $meta['url'])) {
    $media = $meta;
    #break;
  } elseif (false!==strpos($meta['url'], 'youtube.com')) {
    $count++;
    $others .= "<a href='{$meta['url']}' title='{$meta['title']}'>&bull; $count</a> ";
  }
}
$try_link = $metas['yt-olnet-brian']['url'];
if (! $agent) $try_link = '?url='.urlencode($try_link);

if (! $media) {
  header('HTTP/1.1 404 Not Found');  #Error.
  $res->http_status = 404;
  $res->html = "<p $std_attrs class='warn'>We don't have captions/a transcript for this - <a href='$try_link'>try me</a>.</p>";
  die(json_encode($res));
}


$do_captions = false;
if (isset($media['captions']) && isset($meta['file'])) {
  $do_captions = true;
}
elseif (!isset($media['transcript'])) {
  header('HTTP/1.1 500 Internal Server Error'); #Error.
  $res->http_status = 500;
  $res->html = "<p $str_attrs class='error'>Woops, there's been a problem - <a href='$try_link'>try me</a>.</p>";
  die(json_encode($res));
}

  $res->title= isset($media['title']) ? htmlentities($media['title']) : '';
  $res->html = <<<EOH

<div
 xmlns="http://www.w3.org/1999/xhtml" lang="{$res->lang}"
 id="malt-0" title="{$res->title}">
<style type="text/css">
#malt-0, #ma-skip { font-size:medium }
#malt-0 p { margin:.8em 0; } /*p:1.12em 0*/
#malt-0 h2{ font-size:1.1em; }
#malt-0 button { border:1px solid gray }
#malt-0 cite { color:#444; font-size:medium }
#ma-player { display: block; }
#ma-transcript{display:none; /*position:absolute;*/ font-size:1.1em; background:#fafafa; padding:5px; border:1px solid #d33; overflow-y:scroll; height:8em; }
</style>
<script type="text/javascript">function maToggle(id){
var d=document.getElementById(id).style;if('none'==d.display){d.display='block'}else{d.display='none'}
}</script>
EOH;

if ($do_captions) {
  $flash_vars  = $player->flashvars_static($media, $res->lang);
  $flash_vars = str_replace('http://localhost/', $localhost, $flash_vars);
  $size_attrs = $player->size($media);
  $data_url = $localhost . $player->player();

  $res->width = $media['width'];
  $res->height= $media['height'];
  $res->html .= <<<EOH
<object id="ma-player" data="$data_url" type="application/x-shockwave-flash" $size_attrs>
  <param value="true" name="swliveconnect" /><!--TODO ??-->
  <param value="false" name="play" />
  <param value="true" name="menu" />
  <param value="true" name="seamlesstabbing" />
  <param value="true" name="allowfullscreen" />
  <param value="always" name="allowscriptaccess" /><!--sameDomain -->
  <param value="opaque" name="wmode" /><!--wmode: opaque -->
  <param name="flashvars" value=
"$flash_vars"
/> </object>
EOH;
} else {
  $transcript = $media['transcript'];
  $trans_title= 'Transcript for '.substr($title, 0, 35).'...';

  $res->html .= <<<EOH
<div id="ma-transcript"><h2>$trans_title</h2>
$transcript
</div>
EOH;
}

  if (false!==stripos($agent, 'greasemonkey')) {
    $res->html .= "<p>Related: $others</p>";
  } else {
    $res->html .= $player->alternate($media);
  }

  $res->html .= <<<EOT
<button onclick="maToggle('ma-transcript');return false">Show information</button>
<pre id="ma-debug" style="display:none"> TEST </pre>
</div>

EOT;


  if ($do_captions) {
    @header('X-Replace-Player: 1');
    $res->replace_player = true;
  }

echo json_encode((object) $res);


/* array(3) {
 ["u"]=>  string(42) "http://www.youtube.com/watch?v=VesKht_8HCo"
 ["t"]=>  string(33) "Brian Mcallister, Roadtrip Nation
 ["style"]=>  string(7) "Graphic"
} array(30) {
 ["HTTP_HOST"]=>  string(14) "localhost:8888"
 ["HTTP_USER_AGENT"]=>  string(99) "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.4; en-GB; rv:1.9.0.10) Gecko/2009042315 Firefox/3.0.10"
 ["HTTP_ACCEPT"]=>  string(63) "text/html,application/xhtml+xml,application/xml;q=0.9,*-/*;q=0.8"
 ["HTTP_ACCEPT_LANGUAGE"]=>  string(14) "en-gb,en;q=0.5"
 ["HTTP_ACCEPT_ENCODING"]=>  string(12) "gzip,deflate"
 ["HTTP_ACCEPT_CHARSET"]=>  string(30) "ISO-8859-1,utf-8;q=0.7,*;q=0.7"
 ["HTTP_KEEP_ALIVE"]=>  string(3) "300"
 ["HTTP_CONNECTION"]=>  string(10) "keep-alive"
 ["HTTP_COOKIE"]=>  string(13) "style=Graphic"
 ["PATH"]=>  string(29) "/usr/bin:/bin:/usr/sbin:/sbin"
 ["SERVER_SIGNATURE"]=>  string(86) "
Apache/2.0.59 (Unix) PHP/5.2.5 DAV/2 Server at localhost Port 8888
"
 ["SERVER_SOFTWARE"]=> string(36) "Apache/2.0.59 (Unix) PHP/5.2.5 DAV/2"
 ["SERVER_NAME"]=> string(9) "localhost"
 ["SERVER_ADDR"]=> string(3) "::1"
 ["SERVER_PORT"]=> string(4) "8888"
 ["REMOTE_ADDR"]=> string(3) "::1"
 ["DOCUMENT_ROOT"]=> string(20) "/Users/nfreear/Sites"
 ["SERVER_ADMIN"]=> string(15) "you@example.com"
 ["SCRIPT_FILENAME"]=> string(36) "/Users/nfreear/Sites/tt/em/index.php"
 ["REMOTE_PORT"]=> string(5) "62345"
 ["GATEWAY_INTERFACE"]=> string(7) "CGI/1.1"
 ["SERVER_PROTOCOL"]=> string(8) "HTTP/1.1"
 ["REQUEST_METHOD"]=> string(3) "GET"
 ["QUERY_STRING"]=> string(100) "u=http%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3DVesKht_8HCo&t=Brian%20Mcallister%2C%20Roadtrip%20Nation"
 ["REQUEST_URI"]=> string(108) "/tt/em/?u=http%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3DVesKht_8HCo&t=Brian%20Mcallister%2C%20Roadtrip%20Nation"
 ["SCRIPT_NAME"]=> string(16) "/tt/em/index.php"
 ["PHP_SELF"]=> string(16) "/tt/em/index.php"
 ["REQUEST_TIME"]=> int(1242502929)
 ["argv"]=> array(1) { [0]=> string(100) "u=http%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3DVesKht_8HCo&t=Brian%20Mcallister%2C%20Roadtrip%20Nation" }
 ["argc"]=> int(1)
} */


/*<script type="text/javascript" src="http://localhost:8888/tt/embed/swfobject.js"></script>
<script type="text/javascript">
/* <![CDATA[ *-/
var flashvars = {
<?php echo $flash_v ?>
};
var params = {};
  params.play = "false";
  params.menu = "true";
  params.seamlesstabbing = "true";
  params.allowfullscreen = "true";
  params.allowscriptaccess = "always"; //"sameDomain";
  params.wmode = "opaque";

var attributes = {};
  attributes.id = "malt-media-0";

  swfobject.embedSWF("../<?php echo $player->player() ?>", "malt-media-0", "445", "420", "9.0.0", "expressInstall.swf", flashvars, params, attributes); //600x450.
  //swfobject.createCSS("#ply", "border: 2px solid red");
/* ]]> *-/
</script>
<div id="malt-media-0"> </div>*/ 


/*
<object type="application/x-shockwave-flash" data="http://static.slideshare.net/swf/ssplayer2.swf?id=1096564&amp;doc=oer-olnet-1-20090304-090303141910-phpapp02" height="400" width="488">
  <param name="movie" value="http://static.slideshare.net/swf/ssplayer2.swf?id=1096564&amp;doc=oer-olnet-1-20090304-090303141910-phpapp02">
  <param name="wmode" value="transparent">
</object>

<object data="/static/players/portalplayer.swf" name="mpl" id="mpl" type="application/x-shockwave-flash" height="347" width="420">
<param value="true" name="swliveconnect">
<param value="true" name="allowFullScreen">
<param value="always" name="allowScriptAccess">
<param value="mediauri=/media/86a1190e-dd05-49a1-b0a8-c5d2b92094dd/m/flv/en
&amp;screenshoturi=http://dotsub.com/media/86a1190e-dd05-49a1-b0a8-c5d2b92094dd/p
&amp;mediaDuration=100000&amp;lang=eng" name="flashvars">
</object>
*/
?>