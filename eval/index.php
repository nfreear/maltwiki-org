<?php
/**
  Multimedia accessibility - evaluation homepage.
  @copyright 2009 The Open University.
  @author N.D.Freear@open.ac.uk, 5 Feb-16 May 2009.
  @package Maltwiki
*/
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);

require_once 'lib/utils.php';
require_once 'lib/data.php';
require_once 'lib/players.php';


$mid  = _get('m', 'xmoodle');# car | corrie | podcast-t206 (oupod) | yt-susan | xmoodle...
$lang = _get('cl','en-GB');  # en | es | de.
$pn   = _get('p', 'cc');      # cc | jw.
$swfo = _get('s', '2.1');

$swf_script = 'http://ajax.googleapis.com/ajax/libs/swfobject/2.1/swfobject.js';  #$swf_script='includes/swfobject.js';
/*if ('2.2b1'==$swfo) {
  $swf_script = 'includes/swfobject-2.2b1.js';
}*/

$player= null;
switch ($pn) {
  case 'cc': $player = new ccPlayerAS3(); break;
  case 'jw': $player = new jwPlayer(); break;
  default: die('404 Not Found, player!'); break;
}
$localhost = localhost();

if (! isset($metas[$mid])) {
  die('404 Not Found, Woops!');
}
$meta = $metas[$mid];
if (! isset($meta['file'])) {
  die('404 Not Found 2, Woops!');
}

$flash  = $player->flashvars($meta, $lang);
$flash = str_replace('http://localhost/', $localhost, $flash);


$title = isset($meta['title']) ? $meta['title'] : '';

  header('Content-Type: text/html; charset=UTF-8');
  @header('Content-Language: en');
  @header('X-Powered-By:');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $title ?> - Media accessibility - experimental</title>

<style type="text/css">
  body { font-family: Verdana,Tahoma,Arial,sans-serif; }
  #page { margin: 0 auto; width: 446px; }
  h1 { font-size: 1.25em; margin: .3em 0; }
  a img { border: 0; }
  .other { border: 1px solid silver; padding: .6em 1em; }
  .plink { font-size: smaller; }
  #__video-1, #__ply { border: 2px solid red; display: block; width: 900px; }
  #controls { margin: 0; padding: 0; }
  #controls li { list-style: none; display: inline; margin: 0; }
  .caption { position: absolute; top: 60px; left: 20px; padding: 4px; background: black; color: yellow; font-weight: bold; z-index: 10; }
</style>

<script type="text/javascript" src="<?php echo $swf_script ?>"></script>
<script type="text/javascript">
/* <![CDATA[ */ 

var flashvars = {
<?php echo $flash ?>
};

var params = {};
  params.play = "false";
  //params.loop = "false";
  params.menu = "true";
  params.seamlesstabbing = "true";
  params.allowfullscreen = "true";
  params.allowscriptaccess = "sameDomain";

  params.wmode = "window"; //"opaque", "transparent";
  params.scale = "exactfit";
  //params.swliveconnect = "false";

var attributes = {};
  //attributes.id = "video-1";

  swfobject.embedSWF("<?php echo $player->player() ?>", "ply", "445", "420", "9.0.0", "expressInstall.swf", flashvars, params, attributes); //600x450.

var fn = function() {
    var ply = document.getElementById('ply');
    ply.title = 'Media paused, to start press play *'; //'Media player';
    /*ply.tabindex = -1;
    ply.setAttribute('role', 'application');
    ply.focus();*/

    //var acc = ply.getPluginConfig('accessibility');
    var cap = document.getElementById('caption-1');

    //cap.innerHTML = ply.getPlaylist()[0].title;
};
//setTimeout("fn()", 1000);
swfobject.addLoadEvent(fn);

function mytrace(text) {
  var trace = document.getElementById('trace');
  trace.innerHTML = trace.innerHTML +'<br>'+ text;
}
/* ]]> */
</script>
</head>
<body>

<div id="page">

<h1><?php echo $title ?></h1>

<div id="player-container">
<?php /*title="Player"
  role="application"
  aria-channel="notify" aria-relevant="all" aria-atomic="false" aria-live="assertive"-->
  <!--aria-relevant="aditions removals" aria-atomic="true" aria-live="polite"-->
  <!--div id="caption-1" class="caption">Caption test</div-->
*/ ?>

  <div id="ply">
    <?php /*<a href="upload/corrie.mp4" title="download the MP4 excerpt">
      <img src="upload/corrie.jpg" width="470" height="300" 
        alt="a small excerpt from ITV's Coronation Street" />
    </a>*/ ?> Alternative content.
  </div>

  <div class="plink"><?php echo $player->alternate($meta) ?> | <?php echo $player->link() ?></div>

<?php echo $player->jsControls() ?>

  <div id="trace"></div>

</div>

<p style="display:none">SWFObject version: <?php echo "$swf_script / $swfo" ?>.</p>


<form action="">
<p>
<label for="m">Video </label><select id="m" name="m">
<?php foreach ($metas as $id=>$meta) { ?>
  <option value="<?php echo $id ?>"><?php echo $meta['title'] ?></option>
<?php } ?>
</select>
  <br />
<label for="p">Player </label><select id="p" name="p">
  <option value="cc">NCAM ccPlayer</option><option value="jw">jwPlayer</option></select>
<input type="submit" value="Load" />

</p>
</form>


<ul class="other">
<li><a href="./media_accessibility.user.js">YouTube accessibility User Script</a>
 <a href="http://greasespot.net/" title="Greasemonkey required"><img src="http://youngpup.net/z_dropbox/greasespot_favicon.ico" alt="Greasemonkey" /></a></li>
<li><a href="./oembed/?url=http://youtube.com/watch?v=VesKht_8HCo" title="JSON">oEmbed-accessible API</a>
 - <a href="http://oembed.com/">oEmbed</a>.</li>
<!--li><a href=""></a></li-->
</ul>
<p><small>N.D.Freear, February 2009.</small></p>

</div>

</body>
</html>
