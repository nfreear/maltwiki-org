<?php
/**
 Copyright 2009-02-03 N.D.Freear, Open University.
 
*/
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);

require_once 'lib/data.php';
require_once 'lib/players.php';


function _get($name, $default) {
  return isset($_GET[$name]) ? $_GET[$name] : $default;
}

$mid  = _get('m', 'xmoodle');# car | corrie | podcast-t206 (oupod) | yt-susan | xmoodle...
$lang = _get('cl','en-GB');  # en | es | de.
$pn   = _get('p', 'cc');      # cc | jw.

$player= null;
switch ($pn) {
  case 'cc': $player = new ccPlayer(); break;
  case 'jw': $player = new jwPlayer(); break;
  default: die('404 Not Found, player!'); break;
}

$localhost = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']).'/'; #$_SERVER['REQUEST_URI'];

#phpinfo(INFO_VARIABLES);
#<!--base href="http://zander.open.ac.uk/ndf42/tt/" /-->
#<!--base href="http://stickleback.open.ac.uk/sociallearn/tt/" /-->

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
#echo $flash;

  header('Content-Type: text/html; charset=UTF-8');
  @header('Content-Language: en');
  @header('X-Powered-By:');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $title ?> - Media accessibility</title>

<style type="text/css">
  body { font-family: Verdana,Tahoma,Arial,sans-serif; }
  h1 { font-size: 1.4em; margin: .3em 0; }
  .plink { font-size: smaller; }
  #__video-1, #__ply { border: 2px solid red; display: block; width: 900px; }
  .caption { position: absolute; top: 60px; left: 20px; padding: 4px; background: black; color: yellow; font-weight: bold; z-index: 10; }
</style>

<script type="text/javascript" src="embed/swfobject.js"></script>
<script type="text/javascript">
/* <![CDATA[ */ 

var flashvars = {
<?php echo $flash ?>
};

var params = {};
  params.play = "false";
  params.menu = "true";
  params.seamlesstabbing = "true";
  params.allowfullscreen = "true";
  params.allowscriptaccess = "sameDomain";

  params.wmode = "opaque";

var attributes = {};
  //attributes.id = "video-1";

  swfobject.embedSWF("<?php echo $player->player() ?>", "ply", "600", "450", "9.0.0", "expressInstall.swf", flashvars, params, attributes);
  //swfobject.createCSS("#ply", "border: 2px solid red");

var fn = function() {
    var ply = document.getElementById('ply');
    //var acc = ply.getPluginConfig('accessibility');
    var cap = document.getElementById('caption-1');

    //cap.innerHTML = ply.getPlaylist()[0].title;
};
setTimeout("fn()", 1000);
//swfobject.addLoadEvent(fn);

function mytrace(text) {
  var trace = document.getElementById('trace');
  trace.innerHTML = trace.innerHTML +'<br>'+ text;
}
/* ]]> */
</script>
</head>
<body>

<h1><?php echo $title ?></h1>

<div id="player-container">
  <div id="caption-1" class="caption">Caption test</div>

  <div id="ply">
    <a href="upload/corrie.mp4" title="download the MP4 excerpt">
      <img src="upload/corrie.jpg" width="470" height="300" 
        alt="a small excerpt from ITV's Coronation Street" />
    </a>
  </div>

  <div class="plink"><?php echo $player->alternate($meta) ?> | <?php echo $player->link() ?></div>

<?php echo $player->jsControls() ?>

  <div id="trace"></div>

</div>


<form action="">
<p>
<label for="m">Video </label><select id="m" name="m">
<?php foreach ($metas as $id=>$meta) { ?>
  <option value="<?php echo $id ?>"><?php echo $meta['title'] ?></option>
<?php } ?>
</select>
<label for="p">Player </label><select id="p" name="p">
  <option value="cc">NCAM ccPlayer</option><option value="jw">jwPlayer</option></select>
<input type="submit" value="Load" />
<!--input type="hidden" name="mode" value="<?php echo $mode ?>" /-->
</p>
</form>

<!--pre>
http://www.w3.org/TR/2006/CR-ttaf1-dfxp-20061116/
http://www.longtailvideo.com/support/tutorials/Making-Video-Accessible
http://code.google.com/p/swfobject/wiki/api
http://www.bobbyvandersluis.com/swfobject/generator/
https://wiki.mozilla.org/Accessibility/Caption_Formats
</pre-->

</body>
</html>

<?php /*
{   "version": "1.0",
    "type": "video",
    "provider_name": "YouTube",
    "width": 425,
    "height": 355,
    "html": "<embed src='http://www.youtube.com/v/vk1HvP7NO5w' type='application/x-shockwave-flash' wmode='transparent' width='425' height='355'></embed>"
}
*/ ?>