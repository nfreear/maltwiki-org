<?php
/**
 Copyright 2009-02-05 N.D.Freear, Open University.
*/

class basePlayer {

  public function alternate($meta) {
    #URL, hierarchy: alt_media, alt_transcript, url.
    $url = $label = $image = null;
    if (isset($meta['alt_media'])) {
      $url  = $meta['alt_media'];
      $label= 'Download the alternative video (MP4)'; #MP4?
    }
    elseif (isset($meta['alt_transcript'])) {
      $url  = $meta['alt_transcript'];
      $label= 'View the transcript (PDF)'; #?
    }
    else {
       $url = $meta['url'];
    }
    $label .=' '. $meta['title']; #', '.
    if (isset($meta['image'])) {
    
    }
    return "<a href='$url'>$label</a>";
    /*<a href="upload/corrie.mp4" title="download the MP4 excerpt">
      <img src="upload/corrie.jpg" width="470" height="300" 
        alt="a small excerpt from ITV's Coronation Street" />
    </a>*/
  }

  public function link()   { return ''; }
  public function player() { return ''; }
  public function flashvars($meta, $lang='en') { return ''; }
  public function jsControls($id='ply') { return ''; }

  public function size($meta) { #Added, 16 May.
    $attrs = '';
    $width = 600; #$meta['width'] + 20;
    $height= $meta['height']+ 1;
    if ($meta['width']) {
      $attrs = " width='$width' height='$height'";
    }
    return $attrs;
  }
}


class jwPlayer extends basePlayer {  #v4.3.
  public function link() {
    return "<a href='http://longtailvideo.com/players/jw-flv-player/'>JW player</a>";
  }

  public function player() { return "includes/jwPlayer.swf"; }

  public function flashvars_static($meta, $lang='en') { #Added, 16 May 2009.
    return htmlspecialchars( urldecode( http_build_query( array(
      'file'    => $meta['file'],
      'image'   => isset($meta['image']) ? $meta['image'] :'',
      'captions'=> $meta['captions'],
      'plugins' => 'accessibility',
    ))));
  }

  public function flashvars($meta, $lang='en') {
	$flash = '';
	$flash.= isset($meta['file'])  ? 'file :"'.$meta['file'] .'",'.PHP_EOL :'';
	$flash.= isset($meta['image']) ? 'image:"'.$meta['image'].'",'.PHP_EOL :'';
	$flash.= isset($meta['audio']) ? 'audio:"'.$meta['audio'].'",'.PHP_EOL :'';
	$flash.= isset($meta['captions']) ? 'captions:"'.$meta['captions'].'",'.PHP_EOL :'';
	$flash.= isset($meta['title']) ? 'title:"'.$meta['title'].'",'.PHP_EOL :'';
    $flash.= 'plugins : "accessibility"'.PHP_EOL;
	//accessibility.fontsize: 14,
	//accessibility.volume	: 90,
	//controlbar : "false";
	//tracecall  : "mytrace";
//&author=The author&description=A description&duration=0:45&title=Coronation Street

    return $flash;
  }

  public function jsControls($id='ply') {
    $events = array(
      'PLAY'=>'Play/pause', 'MUTE'=>'Mute/unmute', 'STOP'=>'Rewind &amp; stop',
    );
    $controls = '<ol id="controls">'.PHP_EOL;
    foreach ($events as $ev => $text) {
      $controls .= "<li><input type='button' onclick='document.getElementById(\"$id\").sendEvent(\"$ev\");' value='$text' /></li>".PHP_EOL;
    }
    $controls .= '</ol>'.PHP_EOL;
    return $controls;
  }
}


class ccPlayer extends basePlayer { #v3.0.1.
  public function link() {
    return "<a href='http://ncam.wgbh.org/webaccess/ccforflash/ccPlayerHelp.html'>NCAM ccPlayer help</a>";
  }

  public function player() { return "includes/ccPlayer.swf"; }

  public function flashvars_static($meta, $lang='en') { #Added, 16 May 2009.
    return htmlspecialchars( urldecode( http_build_query( array(
      'ccVideoName'     => $meta['file'],
      'ccPosterImage'   => isset($meta['image']) ? $meta['image'] :'',
      'ccCaptionSource' => $meta['captions'],
      'ccCaptionLanguage'=>$lang,
      'ccOverrideFileStyle'=> true, #false.
      'ccVideoAutoStart' =>false,
      'ccVideoBufferTime'=>2, #5,
    ))));
  }

  public function flashvars($meta, $lang='en') {
    $flash = '';
    $flash.= isset($meta['file']) ? 'ccVideoName :   "'.$meta['file'] .'",'.PHP_EOL :'';
    $flash.= isset($meta['captions']) ? 'ccCaptionSource:"'.$meta['captions'].'",'.PHP_EOL :'';
    $flash.= isset($meta['image']) ? 'ccPosterImage:"'.$meta['image'].'",'.PHP_EOL :'';
    $flash.= <<<EOT
ccVideoAutoStart : false,
ccVideoBufferTime: 2,
ccCaptSourceType : "external",
ccCaptionLanguage: "$lang",
ccCaptionAutoHide: false,
ccOverrideFileStyle:true, //false.
ccDisplayRollup  : false

EOT;
#ccVideoAutoStart=false&ccVideoBufferTime=.5
    return $flash;
  }

  public function jsControls($id='ply') { return ''; }
}

class ccPlayerAS3 extends ccPlayer { #v3.0.1. ccPlayerAS3, 3 May 2009.
  public function link() {
    return "<a href='http://ncam.wgbh.org/webaccess/ccforflash/ccPlayerAS3Help.html'>NCAM ccPlayer AS3 help</a>"; #@todo.
  }

  public function player() { return "includes/ccPlayerAS3.swf"; }
}
