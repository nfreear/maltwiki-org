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

function http_error($code=500, $message='Woops, there\'s been a problem') {
  global $metas;
  
  $std_attrs = 'lang="en" id="malt-0" style="font-size:medium"';
  $try_link  = $metas['yt-olnet-brian']['url'];
  $errors = array(
    404 => 'Not Found', 500 => 'Internal Server Error', );
  $http_text = $errors[$code];
  header("HTTP/1.1 $code $http_text"); #Error.
  $res = new StdClass;
  $res->http_status = $code;
  $res->html = "<p $std_attrs class='ma-error'>$message - <a href='$try_link'>try me</a>.</p>";
  die(json_encode($res));
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
  $oembed_url = localhost('/media_accessibility.user.js').'oembed/?url=';
  $style_url  = localhost('/media_accessibility.user.js').'includes/malt.user.css';

  require_once '../includes/youtube_accessibility.user.js';
}
