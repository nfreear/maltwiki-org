<?php
/**
 * MALT player library, incorporating Flow player and YouTube functionality.
 *
 * @author N.D.Freear, 9 September 2009.
 *
 * ( flowplayer.js 3.1.4. The Flowplayer API
 * 
 * @copyright Copyright 2009 Flowplayer Oy
 * 
 * Date: 2009-09-04 11:42:25 +0000 (Fri, 04 Sep 2009)
 * Revision: 316 ) 
 *
 * @link http://flowplayer.org
 * @package MALT
 */

class Maltplayer extends Controller { #CI_Base { #WAS: Flowplayer.

  protected $js_controls=FALSE;
  protected $_lang;  #='en';
  protected $prefix='malt'; #'eytp'
  protected $theme ='riz';  #'easy'...?
  protected $size  ='small';

  public function __construct($js_controls=TRUE) {
    parent::__construct();
    $this->js_controls = $js_controls;
    $this->lang =& load_class('Language');
    $this->lang->load('malt', $this->config->item('language'));
    $this->_lang = $this->config->item('_lang');
  }

  public function player($data, $html_id='malt-0') {
    $CI =& get_instance();
    $media_id = $data->mid;

    $embed = '';
    if (!isset($data->media->file)) {
      $this->js_controls = false;
      $embed = $this->youtube($data);
    }

    $prefix = $this->prefix;
    $theme  = $this->theme;
    $size   = $this->size;
    $_lang   = $this->_lang;
    $controls  = $this->js_controls ? $this->controls() : '';
    #$style_url = self::url('css');
    #$script_url= $CI->config->site_url()."js/$media_id?hid=$html_id&lang=".$this->lang;

    $player = <<<EOF

<div id="$html_id-controls" class="$prefix-c $theme" lang="$_lang">
  <div id="$html_id" class="$prefix-player">$embed</div>
$controls
</div>

EOF;
/* <link href="$style_url" rel="stylesheet" type="text/css" />
<script >
document.write(unescape("%3Cscript src='$script_url' type="text/javascript'>%3C/script>"));
</script>
 */
    return $player;
  }

  protected function youtube($data) {
    $media = str_replace('yt:', '', $data->mid);
    if (!$media) {
      die (' ERROR ');
    }
    $swf = "http://www.youtube.com/v/$media.swf";
    $player =<<<EOF
    <embed type="application/x-shockwave-flash"
     src="$swf" 
     bgcolor="#000000" quality="high" allowfullscreen="true" allowscriptaccess="always"
     flashvars="enablejsapi=1" style="width:100%; height:100%" />
EOF;
    if ($data->media->transcript) {
      $transcript = $data->media->transcript; #@todo: Translate heading...
      $player .=<<<EOF
    <div class="transcript"><h2>Transcript</h2>
    $transcript</div>
EOF;
    }
    return $player;
  }

  protected function controls() {
    $prefix= $this->prefix;
    $image = self::url('0.gif');

    #$CI->lang->load('malt', 'english');
    $tx_buttons = $this->lang->line('malt_buttons');
    $tx_controls= $this->lang->line('malt_controls');
    $tx_volume  = $this->lang->line('malt_volume');

    $button = "<li><input type='image' src='$image' width='60' height='60' border='1' "; #@todo: No border, width ? Disappears.
    $controls=NULL;
    foreach ($tx_buttons as $class => $text) {
      $controls .="$button class='$class' alt='$text' title='$text' /></li>".PHP_EOL;
    }
    $controls =<<<EOF
    <h2 class="$prefix-controlheading">{$tx_controls}</h2><ul>
  $controls<li class="track">
    <div class="buffer"></div>
    <div class="progress"></div>
    <div class="playhead"></div>
  </li>
  <li class="time"></li></ul>
  <p class="$prefix-volumecontrol">
  <label for="$prefix-volume">{$tx_volume} </label><input id="$prefix-volume" readonly="readonly" />
  </p>
EOF;
    return $controls;
  }

  public function flow_script($media, $html_id='malt-0') {
    $seconds= 25;
    $config = $this->flow_config($media);
    $swf_player = self::url('player');

    $js_libs = '';  #self::url('js', FALSE, $return=TRUE);
    #$js_libs .=PHP_EOL.PHP_EOL;
    #$js_libs .=self::url('js_controls', FALSE, $return);

    $controls = $this->js_controls ? ".controls(\"$html_id-controls\", {duration:$seconds});" : '';
    $js =<<<EOF
$js_libs

window.onload = function() {
  \$f("$html_id", "$swf_player", $config)$controls
};
EOF;
/* try {
  colours[2] = "red";
} catch (e) {
  alert("An exception occurred in the script. Error name: "+e.name+". Error message: "+e.message);
}
 */
    return $js;
  }

  protected function flow_config($media) {

    $swf_player  = self::url('player');
    $swf_captions= self::url('captions');
    $swf_content = self::url('content');

    $controls = ($this->js_controls) ? 'controls:null,' : '';
    $co_bottom= $this->js_controls ? 0 : 25;
    $debug = isset($debug) ? 'debug:true, log:"debug",'.PHP_EOL.'  ':'';
    $file = $media->file;
    $image= $media->image;
    $captions = $media->captions;

  /*//onLoad: function() { alert( 'HI' ); },
    //onError:function(code, message) { alert( 'Error '+code+': '+message ); },
    debug:function() { return window.console },
    log:  function() { return (window.console ? "debug" : false) }, */
    $config = <<<EOF
{
  {$debug}clip:{ url:"$file", captionUrl:"$captions", autoPlay:false },
  //playlist:[ url:"$image" ],
  plugins: {
    $controls
    captions:{ url:'$swf_captions', captionTarget:'content' }, 
    content: {
      url:'$swf_content',
      bottom: $co_bottom,
      width: '87%', height:55, //40,
      backgroundColor: '#000', //'transparent'
      backgroundGradient: 'low',
      border: 0, borderRadius: 8, //4,
      textDecoration: 'outline',
      style:{ 'body':{
        fontFamily: 'Arial', fontWeight: 'bold', fontSize: '16', //'14'  
        textAlign: 'center', color: '#ffffff' //'#000000' 
      }
      }
    }
  }
}
EOF;
# , html: '<p><a style="font-size:small" href="$stub_url/">About MALT Wiki.</a></p>'
    return $config;
  }

  public static function url($component='player', $include=FALSE, $return=FALSE) {
    $files = array(
      'player' => 'swf/flowplayer-3.1.3.swf',
      'controls'=>'swf/flowplayer.controls-3.1.3.swf',
  #@todo cap 3.1.3: [ERROR] time 00:57:43.539 :: org.flowplayer.captions::Caption : Error #1009
      'captions'=>'swf/flowplayer.captions-3.1.2.swf', #See http://flowplayer.org/forum/5/26498
      'content'=> 'swf/flowplayer.content-3.1.0.swf',
      'js'     => 'swf/flowplayer-3.1.4.min.js',
      #'js_debug'=>'swf/flowplayer-3.1.4.js',

      'js_controls'=>'player/flowplayer.controls-MA.js',
      'css'   => 'player/maltplayer.css',
      '0.gif' => 'player/0.gif',
      #'btn-riz'=> 'player/buttons-riz.jpg',
      #controls, hulu.js ...
    );

    if (!array_key_exists($component, $files)) {
      return FALSE;
    }

    if ($return) {
      return file_get_contents(APPPATH.'assets/'.$files[$component]);
      #return file_get_contents(APPPATH.'libraries/swf/'.$files[$component]);
    }
    if ($include) {
      return APPPATH.'assets/'.$files[$component];
      #return APPPATH.'libraries/swf/'.$files[$component];
    }
    $CI =& get_instance();
    return $CI->config->site_url().'assets/'.$files[$component];
    #return $CI->config->system_url().'application/assets/'.$files[$component];
  }

};

