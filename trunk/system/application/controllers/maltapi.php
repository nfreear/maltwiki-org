<?php
/**
 * The MALT Wiki API controller.
 *
 * @author N.D.Freear, 8 September 2009.
 * @package MALT
 *
 * http://maltwiki.org/oembed?url=http%3A//youtube.com/v/VesKht_8HCo&debug=1&format=json&callback=function
 * http://localhost:8888/ws/ci/js/yt:VesKht_8HCo
 */

class MaltApi extends Controller {

  protected $request = null; #@todo: Finish!

  function __construct() {
    parent::__construct();
    $this->load->library('Mutil');
    $this->request = new StdClass;
    $this->_init_lang();
    # Language fles/directories are lower-case.
    $default = $this->lang->load('malt', $this->config->item('language'), $ret=FALSE); #@todo: TEST!
    $this->lang->load('malt', strtolower($this->config->item('_lang_pack')));
    
    @header('X-Powered-By:');
  }

  function index() {
    #$this->load->view('embedtestview');
  }

  function frame($mid=NULL) {
    $res = $this->_init($mid);
    $title = 'YouTube video';
    if (isset($res->media)) {
      $media = $res->media;
      $title = $media->title;
    }

    if (isset($media->file)) {
      if (false!==strpos($media->file, 'localhost')) {
        $p = parse_url($media->file);
        $media->file = $this->url($p['path']); #url(drupal_get_path('module', 'malt_api'). $p['path'], array('absolute'=>TRUE));
        $p = parse_url($media->image);
        $media->image = $this->url($p['path']);
      }
      $p = parse_url($media->captions);
      $media->captions = $tt_url = $this->url($p['path']); #@todo: /tt?url=http://youtube interface.
      #}
    }

    $this->load->library('MaltPlayer', $this->request);
    $player = $this->maltplayer; #new MaltPlayer();
    $html   = $player->player($res, $res->html_id);
    $script=$js_flow=$js_controls=$style_url=NULL;
    if (isset($media->captions)) {
      $script = $player->flow_script($media, $res->html_id);
      $js_flow    = MaltPlayer::url('js');
      $js_controls= MaltPlayer::url('js_controls');
    }
    $style_url  = MaltPlayer::url('css');

    $frame =  $this->doctype($html5=TRUE); #@todo: Meta-data, <link>...!
    $frame .= <<<EOF
<title>$title - MALT media player (Alpha)</title>

  <link type="text/css" href="$style_url" rel="stylesheet" />

  <script type="text/javascript" src="$js_flow"></script>
  <script type="text/javascript" src="$js_controls"></script>
  <script type="text/javascript">$script
  </script><!--@todo: Accessibility - cannot have overflow:visible; -->
  <!--[if IE]>
    <style type="text/css">html, body {border:0;}</style>
  <![endif]-->
  </head><body class="malt-frame">

  $html

EOF;
    echo $frame;
    $this->load->view('player/video_meta', $res);
    $this->load->view('layout/footer');
  }

  function url($path, $abs=NULL) {
    return $this->config->site_url()."assets$path";
    #return $this->config->system_url().'application/libraries'.$path;
  }


  function oembed($mid=NULL) {  #$a, $b) {
    $res = $this->_init($mid);

    #$tt_url = url('tt/', array('absolute'=>TRUE)). $mid;  #@todo: Flowplayer doesn't like!
    #$html_id = $res->html_id ? "html_id:'$res->html_id',": '';

    $width = 470;
    $height= 380;
    if (!isset($res->media)) {
      $height = 330;
      if (basename(MALT_USER_SCRIPT) == $res->client) {
        $this->_error(404, 'Sorry, I can\'t find any alternatives');  #@todo.
      }
    }
    if (isset($res->media->transcript)) {
      $height = 420;
    }

    $title = 'YouTube video';
    if (isset($res->media)) {
      $media = $res->media;
      $title = $media->title;
    }

    /*if (false!==strpos($media->file, 'localhost')) {
      $p = parse_url($media->file);
      $media->file = $this->url($p['path']); #url(drupal_get_path('module', 'malt_api'). $p['path'], array('absolute'=>TRUE));
      $p = parse_url($media->image);
      $media->image = $this->url($p['path']);
    }
    $p = parse_url($media->captions);
    $media->captions = $tt_url = $this->url($p['path']);
    #}

    $this->load->library('FlowPlayer');
    $player = new FlowPlayer();
    $html = $player->player($res, $res->html_id);*/

    $frame_url = $this->config->site_url().'frame/?url='.urlencode($res->url);
    #http://intranation.com/test-cases/object-vs-iframe/
    $this->load->library('user_agent');
    $classid = '';
    if ('Internet Explorer'==$this->agent->browser()) {
      $classid = ' classid="clsid:25336920-03F9-11CF-8FD0-00AA00686F13"';
    }

    /*$html =<<<EOF
<object $classid type="text/html" data="$frame_url" width="470" height="$height" style="border:1px solid #fff;">
  <a href="{$res->url}">$title</a> </object>
EOF;*/
    $html =<<<EOF
<iframe title="$title" src="$frame_url" width="$width" height="$height" frameborder="0"><a href="{$res->url}">$title</a></frame>
EOF;
#@todo: IE script error ??
    $oembed = array(
      "version"=>"1.0",
      "type" =>"video",
      "lang" =>$res->lang,
      "title"=>$title,
      'width'=>$width, 'height'=>$height,
      'html' =>$html,
      'replace_player'=>TRUE,
    );
    header('X-Replace-Player: 1');  #@todo!
    echo $this->_json_encode($oembed);
  }


  function javascript($mid=NULL) {
    $res = $this->_init($mid);

    header('Content-Type: text/javascript; charset=UTF-8');

    $media = $res->media;

    if (false!==strpos($media->file, 'localhost')) {
      $p = parse_url($media->file);
      $media->file = $this->url($p['path']); #url(drupal_get_path('module', 'malt_api'). $p['path'], array('absolute'=>TRUE));
      $p = parse_url($media->image);
      $media->image = $this->url($p['path']);
    }
    $p = parse_url($media->captions);
    $media->captions = $tt_url = $this->url($p['path']);
    #}

    $this->load->library('FlowPlayer');
    $player = new FlowPlayer();
    $script = $player->player_script($media, $res->html_id);

    echo $script;
  }

  function user_script() {
    header('Content-Type: text/javascript; charset=UTF-8');
    #@header('Content-Disposition: inline; filename=MALT.user.js.txt');
    $host = malt_is_live() ? '' : ' ['.str_replace(':8080', '', $_SERVER['HTTP_HOST']).']';

    $this->load->helper('url');
    $oembed_url = site_url('oembed').'?url=';
    #$style_url = $this->config->site_url().'assets/MALT.user.css';
/* Line-break is important!
// @resource style <?php echo $style_url ?>

// ==/UserScript==
*/
    require_once APPPATH.'assets/client/'.basename(MALT_USER_SCRIPT);
  }

  function _user_script_link($text='MALT Wiki User Script, for YouTube') {
    $js  = $this->config->site_url().MALT_USER_SCRIPT;
    $out = <<<EOF
  <a href="$js">$text</a>
  <a href="http://greasespot.net/" title="Requires Greasemonkey"><img src="http://youngpup.net/z_dropbox/greasespot_favicon.ico" alt="Requires Greasemonkey"/></a>
EOF;
    return $out;
}


function _error($code=500, $message='Woops, there\'s been a problem') {
  #global $metas;
  $metas = $this->load_data();

  $std_attrs = 'lang="en" id="malt-0" style="font-size:medium"';
  $try_url= $metas['yt-olnet-brian']['url'];
  $url    = $this->config->site_url();
  $icon    = $url.MALT_FAVICON;
  $about_link = "<a href='$url'>About MALT Wiki <img alt='' src='$icon' /></a>";
  $errors = array(
    400=>'Bad Request', 404=>'Not Found', 500=>'Internal Server Error', 503=>'Service Unavailable');
  $http_text = $errors[$code];
  
  @header("HTTP/1.1 $code $http_text");  #Error.
  $res = new StdClass;
  $res->http_status = $code;
  $res->html = "<p $std_attrs class='ma-error'>$message &ndash; <a href='$try_url'>try me</a> | $about_link";

  if ('oembed' == $this->uri->segment(1)) {

    echo $this->_json_encode($res, $debug_override=TRUE);
  } else {
    header('Content-Type: text/html; charset=utf-8');
    
    $html =<<<EOF
<!DOCTYPE html><html lang="en"><head><meta charset=utf-8 /><title>$code $http_text - MALT player</title>
  </head><body>
  <h1>$code $http_text</h1>
  {$res->html}
  </body></html>
EOF;
    echo $html;
  }
exit;
}

protected function _json_encode($data, $debug_override=FALSE) {
  $this->load->library('Mutil');
  $callback = $this->_get('callback');  #@todo: Security!
  $debug    = $this->_get('debug', $debug_override);
  $json= json_encode((object)$data);
  $ext = 'js';
  $disposition = 'attachment';
  if ($debug) { #|| $demo.
    $ext = 'txt';
    $disposition = 'inline';
    # Pretty print.
    $json = str_replace(array(',"', ', "'), "\r\n,\"", $json);
    header('Content-Type: text/javascript; charset=UTF-8');
  } else {
    header('Content-Type: application/json+oembed; charset=UTF-8');
  }
  @header('Content-Language: '. $data->lang);
  if ($callback) {
    $json = "$callback($json);";
  }
  $octets = strlen($json);
  @header("Content-Disposition: $disposition; filename=maltwiki-oembed-json.$ext size=$octets"); #MSIE (& Firefox).
  return $json;
#exit;
}

public static function _get($name, $default=null) {
  return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default; #@todo: _GET.
}


public function load_data() {
    #module_load_include('inc', 'malt_api', 'malt_api.data');
  #require_once drupal_get_path('module', 'malt_api')."/malt_api.data.inc";
  #require_once APPPATH.'/libraries/malt_data.php';
  $this->load->library('malt_data');
  return Malt_data::load();
}

public function localize() { #@todo: Check, valid language?
  echo $this->lang->text_file();
}

protected function _init_lang() {
  # 1. Content negotiation, using 'Accept-Language' header.
  $this->load->library('user_agent');
  $_lang = str_replace('english', 'en', $this->config->item('language'));

  #@todo: Order matters :(
  $available = $this->lang->available();
  foreach ($available as $lang => $parent) {
    if ($this->agent->accept_lang($lang)) {
      $_lang = $lang;
      $_lang_pack = $parent ? $parent : $lang; #Redundant?
      break;
    }
  }
  # 2. Then override if required.
  $lang_2 = strtolower($this->_get('lang', $_lang));
  if (array_key_exists($lang_2, $available)) { #(in_array(strtolower($lang_2), $available)) {
    $_lang = $lang_2;
    $_lang_pack = $available[$lang_2] ? $available[$lang_2] : $lang_2;
  }
  @header('Content-Language: '.$_lang);
  $this->request->lang = $_lang;
  $this->config->set_item('_lang', $_lang);  #@todo: Remove?!
  $this->config->set_item('_lang_pack', str_replace('en', 'english', $_lang_pack));
  #$_lang = str_replace('en', 'english', $_lang);
  #$this->config->set_item('language', $_lang);
}

protected function _init($mid) {
  header('Content-Type: text/html; charset='.$this->config->item('charset'));
  @header('X-Powered-By:');
  if(function_exists('header_remove'))header_remove('X-Powered-By');

  $res = (object) array('mid'=>$mid);
  $metas = $this->load_data();

  if ($mid && preg_match('/^yt:([\w-_]{5,15})$/', $mid, $matches)) {  #Was ':' '-'
    $res->url = 'http://youtube.com/watch?v='.$matches[1];
  } else {
    $res->url = str_replace('www.', '', $this->_get('url'));
    if ($res->url && preg_match('#youtube.com\/watch\?.*v=.+#', $res->url)) {
      $p = parse_url($res->url);
      if (!isset($p['query'])) {
        $this->_error(500);
      }
      $res->mid = 'yt:'.str_replace('v=','', urldecode($p['query'])); #@todo Need to loop.
      if ('yt:'==$res->mid) {
        $this->_error(500);
      }
    }
    #else $this->_error(404);
  }

  $res->client = $this->_get('client');
  $res->lang   = $this->_get('lang', 'en');
  $res->theme  = $this->_get('theme', 'riz');
  $res->html_id= $this->_get('hid', 'malt-0');

  $this->request = $res;
  $this->config->set_item('malt_client', $this->request->client);

  $media  = $count = $others = null;
  foreach ($metas as $key => $meta) {
    if (0===strpos($res->url, $meta['url'])) {
      $res->media = (object)$meta;
      #break;
    } elseif (false!==strpos($meta['url'], 'youtube.com')) {
      $count++;
      $others .= "<a href='{$meta['url']}' title='{$meta['title']}'>&bull; $count</a> ";
    }
  }

  if (!$res->url) {  #|| !isset($res->media)) {
    $this->_error(400, 'Woops, I think there was a mistake in the request!'); #400.
  }
  return $res; 
}

  protected function doctype($html5=TRUE) { #@todo: View!
    $_lang = $this->request->lang; #$this->config->item('_lang');
    $head = '';
    if ($html5) {
      $head = <<<EOF
<!DOCTYPE html><html lang="$_lang"><head><meta charset=utf-8 />
EOF;
    } else {
      $head = <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="$_lang" lang="$_lang">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
EOF;
    }
    $mail = MALT_EMAIL;
    $head .= <<<EOF
  <meta name="robots" content="noindex,follow" />
  <link rev="made" href="mailto:$mail?subject=MALT Wiki" />
EOF;
    return $head;
  }

} /*class*/
