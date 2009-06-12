<?php
/**
  Multimedia accessibility - oEmbed API.
  @copyright 2009 The Open University.
  @author N.D.Freear@open.ac.uk, 16 May 2009.
  @package Maltwiki

  @uses http://oembed.com
*/
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);

require_once '../lib/utils.php';
require_once '../lib/data.php';
require_once '../lib/players.php';


$res = new StdClass();
$res->version= '1.0';
$res->type   = 'video';
$res->http_status = 200;

$res->lang = _get('cl','en');  # en-GB | es | de.
$url  = str_replace('www.', '', _get('url'));
$title= _get('t', 'this');
$agent= _get('a');  #Greasemonkey.
$std_attrs = 'lang="en" id="malt-0" style="font-size:medium"';

$player = new ccPlayerAS3(); #cc (jw, dot).
$localhost = localhost('/oembed');

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
  http_error(404, 'We don\'t have captions/a transcript for this');
}


$do_captions = false;
if (isset($media['captions']) && isset($meta['file'])) {
  $do_captions = true;
}
elseif (!isset($media['transcript'])) {
  http_error();
}

  $res->title= isset($media['title']) ? htmlentities($media['title']) : '';
  #$res->style= URL;  @todo.
  $res->html = <<<EOH

<div
 xmlns="http://www.w3.org/1999/xhtml" lang="{$res->lang}"
 id="malt-0" title="{$res->title}">
<!--style type="text/css">
#malt-0, #ma-skip { font-size:medium }
#malt-0 p { margin:.8em 0; } /*p:1.12em 0*/
#malt-0 h2{ font-size:1.1em; }
#malt-0 button { border:1px solid gray }
#malt-0 cite { color:#444; font-size:medium }
#ma-player { display: block; }
#ma-transcript{display:none; /*position:absolute;*/ font-size:1.1em; background:#fafafa; padding:5px; border:1px solid #d33; overflow-y:scroll; height:8em; }
</style-->
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

  header('Content-Type: text/javascript; charset=UTF-8');
  @header('Content-Language: '. $res->lang);
  @header('X-Powered-By:');

  if ($do_captions) {
    @header('X-Replace-Player: 1');
    $res->replace_player = true;
  }

echo json_encode((object) $res);
exit;


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