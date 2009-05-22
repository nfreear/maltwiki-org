<?php
/**
  Multimedia accessibility - utility functions.
  @copyright 2009 The Open University.
  @author N.D.Freear@open.ac.uk, 5 February 2009.
  @package Maltwiki
*/


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

  require_once '../includes/youtube_accessibility.user.js';
}
