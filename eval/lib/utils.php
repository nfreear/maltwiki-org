<?php
/**
  Multimedia accessibility - utility functions.
  @copyright 2009 The Open University.
  @author N.D.Freear@open.ac.uk, 5 February 2009.
  @package Maltwiki
*/


function dotsub_init($meta, $size='l') {
  #http://blog.dotsub.com/?p=7
  $dot_sizes = array(
    's' => array('width'=>"320", 'height'=>"272"),
    'm' => array('width'=>"420", 'height'=>"347"),
    'l' => array('width'=>"480", 'height'=>"392"),
  );

  if (! isset($meta['file'])) {
    http_error(500, "Woops, there's been a problem (file)");
  }

  if (false!==strpos($meta['file'], 'dotsub.com/')) {
    #$meta['file']  = preg_replace('#\/e([sml])\/flv#', "/e$size/flv", $meta['file']);
    $meta['width'] = $dot_sizes[$size]['width'];
    $meta['height']= $dot_sizes[$size]['height'];
    $meta['flashvars'] = "&amp;embedded=true&amp;size=$size&amp;";
    #var_dump($meta);
  }
  return $meta;
}

function clean_url($url) {
  # Clean up URLs: http://www.youtube.com/watch?gl=GB&hl=en-GB&v=eIupVqDWoFM&feature=user
  $url  = str_replace('www.', '', $url);
  $p = parse_url($url);
  $q = explode('&', $p['query']);
  $url = $p['scheme'].'://'.$p['host'].$p['path'].'?';
  foreach ($q as $part) {
    if (preg_match('/^(v=.+)$/', $part, $matches)) {
      $url .= $matches[1];
      break;
    }
  }
  return $url;
}

function youtube_tt_check($url, $lang='en') {
  $p = parse_url($url);
  if (false===strpos($p['host'], 'youtube.com')) {
    return false;
  }
  #$q = parse_url($url, PHP_URL_QUERY);
  #$q = explode('&', $q);
  $tt_uri = "http://video.google.com/timedtext?lang=$lang&".$p['query'];

  $hCurl = curl_init($tt_uri);
  #curl_setopt($hCurl, CURLOPT_USERAGENT, $userAgent);
  curl_setopt($hCurl, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($hCurl, CURLOPT_VERBOSE, TRUE);
  #curl_setopt($hCurl, CURLOPT_HEADER, TRUE);
  #curl_setopt($hCurl, CURLOPT_TIMEOUT, $timeout);
  #curl_setopt($hCurl, CURLOPT_CONNECTTIMEOUT, $timeout);
  curl_setopt($hCurl, CURLOPT_PROXY, 'wwwcache.open.ac.uk:80');
  $resp = curl_exec($hCurl);
  $code = curl_getinfo($hCurl, CURLINFO_HTTP_CODE);
  return 200!=$code || strlen($resp)<2 ? false : true;
}

function http_error($code=500, $message='Woops, there\'s been a problem') {
  global $metas;
  
  $std_attrs = 'lang="en" id="malt-0" style="font-size:medium"';
  $try_link  = $metas['yt-olnet-brian']['url'];
  $about_link= localhost('oembed/');
  $errors = array(
    404 => 'Not Found', 500 => 'Internal Server Error', );
  $http_text = $errors[$code];
  header('Content-Type: text/javascript; charset=UTF-8');
  @header("HTTP/1.1 $code $http_text"); #Error.
  $res = new StdClass;
  $res->http_status = $code;
  $res->html = "<p $std_attrs class='ma-error'>$message - <a href='$try_link'>try me</a>. <a href='$about_link'>About</a>.</p>";
  _json_encode($res);
}

function _json_encode($data) {
  $json = json_encode((object)$data);
  $json = str_replace(',"', "\r\n,\"", $json);

  header('Content-Type: text/javascript; charset=UTF-8'); #application/json.
  @header('Content-Language: '. $data->lang);
  @header('X-Powered-By:');
  echo $json;
exit;
}

function _get($name, $default=null) {
  return isset($_GET[$name]) ? $_GET[$name] : $default;
}

function localhost($replace = null) {
  # Portability: should handle PORTS and Drupal routing.
  $p = parse_url('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  return 'http://'.$_SERVER['HTTP_HOST'].str_replace($replace, '', $p['path']);
}

function user_javascript() {
  header('Content-Type: text/javascript; charset=UTF-8');
  #header('Content-Disposition: attachment; filename=maltwiki.user.js');
  $host = 'maltwiki.org'==$_SERVER['HTTP_HOST'] ? '' : '['.str_replace(':8080', '', $_SERVER['HTTP_HOST']).']';
  $oembed_url = localhost('/media_accessibility.user.js').'oembed/?url=';
  $style_url  = localhost('/media_accessibility.user.js').'includes/malt.user.css';
/* Line-break is important!
// @resource style <?php echo $style_url ?>

// ==/UserScript==
*/
  require_once '../includes/youtube_accessibility.user.js';
}
