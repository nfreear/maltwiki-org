<?php
/*
 N.D.Freear, 3 February 2009.
*/
error_reporting(E_ALL);

$path = 'http://'.$_SERVER['HTTP_HOST'].($_SERVER['REQUEST_URI']); #.'/'; #dirname

#phpinfo(INFO_VARIABLES);
#<!--base href="http://zander.open.ac.uk/ndf42/tt/" /-->
#<!--base href="http://stickleback.open.ac.uk/sociallearn/tt/" /-->

/*$meta['moodle'] = array(
#height=350&width=500&searchbar=false&autostart=false
  'url'  =>'http://xtranormal.com/watch?e=20090124001058490',
  'file' =>'http://video.xtranormal.com/highres/aacd0182-e274-11dd-9b38-001b210ae39a_7.flv',
  'image'=>'http://video.xtranormal.com/highres/aacd0182-e274-11dd-9b38-001b210ae39a_7_0.jpg',
  'captions'=>null,
  'audio'   =>null,
  'lang' =>'en',
  'title'=>'Moodle',
  'description'  =>'An elevator pitch for the online learning environment',
  'duration'     =>'00:51',
  'provider_name'=>'Xtranormal',
  'provider_url' =>'http://xtranormal.com/',
  'author_name'  =>'nickfreear',
);
$meta['corrie'] = array(
  'url'   =>'http://localhost/corrie',
  'file'  =>'http://localhost/upload/corrie.flv',
  'image' =>'http://localhost/upload/corrie.jpg',
  'captions'=>'http://localhost/upload/corrie_2.xml',
  'audio' =>'http://localhost/upload/corrie.mp3',
  'lang'  =>'en',
  'title' =>'Coronation Street',
  'description'  =>'A small excerpt from ITV\'s Coronation Street',
  'duration'     =>'00:45',
  'provider_name'=>'localhost',
);
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Video test</title>

<style type="text/css">
  #__video-1, #__ply { border: 2px solid red; display: block; width: 900px; }

  .caption { position: absolute; top: 80px; left: 20px; padding: 4px; background: black; color: yellow; font-weight: bold; z-index: 10; }
</style>

	<script type="text/javascript" src="embed/swfobject.js"></script>
	<script type="text/javascript">
	/* <![CDATA[ */	

	var flashvars = {};
	flashvars.file    = "<?php echo $path ?>upload/corrie.flv";
	flashvars.image   = "<?php echo $path ?>upload/corrie.jpg";
	flashvars.captions= "<?php echo $path ?>upload/corrie_2.xml";
	flashvars.audio   = "<?php echo $path ?>upload/corrie.mp3";
	flashvars.plugins = "accessibility";
	//flashvars.accessibility.fontsize = 13;
	//flashvars.accessibility.volume   = 90;
	//flashvars.controlbar="false";

	flashvars.title   = "Coronation Street clip";
    //flashvars.tracecall = "mytrace";
//&author=The author&description=A description&duration=0:45&title=Coronation Street

		var params = {};
		params.play = "false";
		params.menu = "true";
		params.seamlesstabbing = "true";
		params.allowfullscreen = "true";
		params.allowscriptaccess = "sameDomain";

		params.wmode = "opaque";

		var attributes = {};
		//attributes.id = "video-1";

		swfobject.embedSWF("embed/player.swf", "ply", "600", "450", "9.0.0", "expressInstall.swf", flashvars, params, attributes);

		swfobject.createCSS("#ply", "border: 2px solid red");


var fn = function() {
        var att = { data:"test.swf", width:"780", height:"400" };
        var par = { flashvars:"foo=bar" };
        var id = "replaceMe";
        //var myObject = swfobject.createSWF(att, par, id);

var ply = document.getElementById('ply');

//var acc = ply.getPluginConfig('accessibility');
var cap = document.getElementById('caption-1');

cap.innerHTML = ply.getPlaylist()[0].title;

      };
setTimeout("fn()", 1000)
//swfobject.addLoadEvent(fn);


function mytrace(text) {
  var trace = document.getElementById('trace');
  trace.innerHTML = trace.innerHTML +'<br>'+ text;
}
  /* ]]> */
	</script>
</head>
<body>

<div id="caption-1" class="caption">Caption test</div>

		<p id="ply">
			  <a href="upload/corrie.mp4" title="download the MP4 excerpt">
			    <img src="upload/corrie.jpg" width="470" height="300" 
			      alt="a small excerpt from ITV's Coronation Street" />
			  </a>
		</p>

<ol __style="display: none;">
  <li><a href="javascript:document.getElementById('ply').sendEvent('PLAY');">play/pause the video</a></li>
  <li><a href="javascript:document.getElementById('ply').sendEvent('MUTE');">mute/unmute the video</a></li>
  <li><a href="javascript:document.getElementById('ply').sendEvent('STOP');">rewind and stop the video</a></li>
</ol>

<div id="trace"></div>

<pre>
http://www.w3.org/TR/2006/CR-ttaf1-dfxp-20061116/
http://www.longtailvideo.com/support/tutorials/Making-Video-Accessible
http://code.google.com/p/swfobject/wiki/api
http://www.bobbyvandersluis.com/swfobject/generator/
https://wiki.mozilla.org/Accessibility/Caption_Formats
</pre>

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