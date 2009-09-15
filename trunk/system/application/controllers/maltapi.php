<?php
/**
 * The MALT Wiki API controller.
 *
 * @author N.D.Freear, 8 September 2009.
 *
 * http://maltwiki.org/oembed?url=http%3A//youtube.com/v/VesKht_8HCo&format=json&callback=function
 * http://localhost:8888/ws/ci/oembed?url=oembed?url=http%3A%2F%2Fyoutube.com/watch%3Fv%3DVesKht_8HCo
 * http://localhost:8888/ws/ci/js/yt:VesKht_8HCo
 */

class MaltApi extends Controller {

  protected $request = null; #@todo: Finish!

  function __construct() {
    parent::__construct();
    $this->request = new StdClass;
    $this->_init_lang();
  }

  function index() {
    $this->load->view('embedtestview');
  }

  function frame($mid=NULL) {
    $res = $this->_init($mid);
    if (isset($res->media)) {
      $media = $res->media;
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
    $title = isset($media->title) ? $media->title : 'Video';

    $frame =  $this->doctype($html5=TRUE); #@todo: Meta-data, <link>...!
    $frame .= <<<EOF
<title>$title - MALT media player</title>

  <link type="text/css" href="$style_url" rel="stylesheet" />

  <script type="text/javascript" src="$js_flow"></script>
  <script type="text/javascript" src="$js_controls"></script>
  <script type="text/javascript">$script
  </script>
  </head><body class="malt-frame">

  $html

  </body></html>
EOF;
    echo $frame;
  }

  function url($path, $abs=NULL) {
    return $this->config->system_url().'application/libraries'.$path;
  }


  function oembed($mid=NULL) {  #$a, $b) {
    $res = $this->_init($mid);

    header('Content-Type: text/javascript; charset=UTF-8');

    #$tt_url = url('tt/', array('absolute'=>TRUE)). $mid;  #@todo: Flowplayer doesn't like!
    #$html_id = $res->html_id ? "html_id:'$res->html_id',": '';

    if (!isset($res->media)) {
      if ('MALT.user.js'!=$res->client) {
        
      }
      $this->_error(404);
    }
    $media = $res->media;

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

    $html =<<<EOF
<iframe title="{$media->title}" src="$frame_url" width="470" height="380" style="border:none;"><a href="{$res->url}">{$media->title}</a></frame>
EOF;

    $oembed = array(
      "version"=>"1.0",
      "type" =>"video",
      "lang" =>$res->lang,
      "title"=>$res->media->title,
      'html' =>$html,
    );
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

  function _user_js() {
    header('Content-Type: application/javascript; charset=UTF-8');
    $url = url('oembed/', array('absolute'=>TRUE)); #.'oembed/?url=';
    $style_url  = url(drupal_get_path('module','malt_api').'/malt.user.css', array('absolute'=>TRUE));

    require_once './malt.user.js';
  }

function _user_js_link($text='MALT YouTube user Javascript') {
  l($text, 'MALT.user.js');
}


function _error($code=500, $message='Woops, there\'s been a problem') {
  #global $metas;
  $metas = $this->load_data();

  $std_attrs = 'lang="en" id="malt-0" style="font-size:medium"';
  $try_link  = $metas['yt-olnet-brian']['url'];
  $about_link= $this->config->site_url(); #base_path(); #localhost('oembed/');
  $errors = array(
    404 => 'Not Found', 500 => 'Internal Server Error', );
  $http_text = $errors[$code];
  
  @header("HTTP/1.1 $code $http_text");  #Error.
  $res = new StdClass;
  $res->http_status = $code;
  $res->html = "<p $std_attrs class='ma-error'>$message - <a href='$try_link'>try me</a>. <a href='$about_link'>About</a>.</p>";

  if ('oembed' == $this->uri->segment(1)) {

    header('Content-Type: text/javascript; charset=utf-8');
    echo $this->_json_encode($res);
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

function _json_encode($data) {
  $callback = $this->_get('callback');  #@todo: Security!
  $json = json_encode((object)$data);
  $json = str_replace(',"', "\r\n,\"", $json);

  header('Content-Type: text/javascript; charset=UTF-8'); #application/json.
  @header('Content-Language: '. $data->lang);
  @header('X-Powered-By:');
  if ($callback) {
    return "$callback($json);";
  }
  return $json;
#exit;
}

function _get($name, $default=null) {
  return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default; #@todo: _GET.
}


protected function load_data() {
    #module_load_include('inc', 'malt_api', 'malt_api.data');
  #require_once drupal_get_path('module', 'malt_api')."/malt_api.data.inc";
  #require_once APPPATH.'/libraries/malt_data.php';
  $this->load->library('malt_data');
  return Malt_data::load();
}

function _init_lang() {
  # 1. Content negotiation, using 'Accept-Language' header.
  $this->load->library('user_agent');
  $_lang = str_replace('english', 'en', $this->config->item('language'));
  $available = array('fr', 'en');
  foreach ($available as $lang) {
    if ($this->agent->accept_lang($lang)) {
      $_lang = $lang; break;
    }
  }
  # 2. Then override if required.
  $lang_2 = $this->_get('lang', $_lang);
  if (in_array($lang_2, $available)) {
    $_lang = $lang_2;
  }
  @header('Content-Language: '.$_lang);
  $this->request->lang = $_lang;
  $this->config->set_item('_lang', $_lang);  #@todo: Remove?!
  $_lang = str_replace('en', 'english', $_lang);
  $this->config->set_item('language', $_lang);
}

function _init($mid) {
  header('Content-Type: text/html; charset='.$this->config->item('charset'));
  @header('X-Powered-By:');
  if(function_exists('header_remove'))header_remove('X-Powered-By');

  $res = (object) array('mid'=>$mid);
  $metas = $this->load_data();

  if ($mid && preg_match('/^yt:([\w-_]{5,15})$/', $mid, $matches)) {  #Was ':' '-'
    $res->url = 'http://youtube.com/watch?v='.$matches[1];
  } else {
    $res->url = str_replace('www.', '', $this->_get('url'));
    if ($res->url) {
      $p = parse_url($res->url);
      if (!isset($p['query'])) {
        $this->_error(500);
      }
      $res->mid = 'yt:'.urldecode(str_replace('v=','', $p['query'])); #@todo Need to loop.
    }
    else var_dump(' ERROR ');
  }

  $this->request->client = $this->_get('client');
  $this->request->theme  = $this->_get('theme', 'riz');
  $this->request->html_id= $this->_get('hid', 'malt-0');

  $res->client = $this->_get('client');
  $res->lang   = $this->_get('lang', 'en');
  $res->html_id= $this->_get('hid', 'malt-0');
#echo $res->url;

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

  if (!$res->url || !isset($res->media)) {
    ##$this->_error(404);
  }
  return $res; 
}

  public function doctype($html5=TRUE) {
    $_lang = $this->request->lang; #$this->config->item('_lang');
    if ($html5) {
      return <<<EOF
<!DOCTYPE html><html lang="$_lang"><head><meta charset=utf-8 /> 
EOF;
    }
    return <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="$_lang" lang="$_lang">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

EOF;
    
  }

} /*class*/
