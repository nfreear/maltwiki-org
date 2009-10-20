<?php
/**
 * Utility functions.
 * @author N.D.Freear, 7 October 2009.
 * @package MALT
 */
class Mutil {};


function malt_is_live() {
  return ('maltwiki.org' == $_SERVER['HTTP_HOST']);
}

/**
 * json_encode - Compatability: PHP < 5.2.0.
 * @todo: Native json_encode '<', this one '\x3c' ?
 * http://api.drupal.org/api/function/drupal_json/6
 */
if (!function_exists('json_encode')) {
  function json_encode($var) { return __json_encode($var); }
  function __json_encode($var) {
    switch (gettype($var)) {
      case 'boolean':
        return $var ? 'true' : 'false'; // Lowercase necessary!
      case 'integer':
      case 'double':
        return $var;
      case 'resource':
      case 'string':
        return '"'. str_replace(array("\r", "\n", "<", ">", "&"),
                                array('\r', '\n', '\x3c', '\x3e', '\x26'),
                                addslashes($var)) .'"';
      case 'array':
        // Arrays in JSON can't be associative. If the array is empty or if it
        // has sequential whole number keys starting with 0, it's not associative
        // so we can go ahead and convert it as an array.
        if (empty ($var) || array_keys($var) === range(0, sizeof($var) - 1)) {
          $output = array();
          foreach ($var as $v) {
            $output[] = __json_encode($v);
          }
          return '['. implode(',', $output) .']';  #@todo: Removed whitespace.
        }
        // Otherwise, fall through to convert the array as an object.
      case 'object':
        $output = array();
        foreach ($var as $k => $v) {
          $output[] = __json_encode(strval($k)) .':'. __json_encode($v);
        }
        return '{'. implode(',', $output) .'}';
      default:
        return 'null';
    }
  }
}


/**
 * Individuals, organizations and sites that contribute video, captions, tools etc.
 */
function contributors($media) {
  #@todo: Links etc. 'producer'=='video producer'...
  $out='';
  $cc = FALSE;
  if (isset($media->author_name)) {
    $out .= "Producer - ".$media->author_name."; ";
  }
  if (isset($media->contributor)) {
    $contributors = $media->contributor;
    foreach ($contributors as $role => $name) {
      if ('captions'==$role || 'transcript'==$role) $cc = TRUE;
      $out .= ucfirst($role)." - $name; ";
    }
  }
  if (isset($media->provider_name)) {
    $out .= '<abbr title="Caption editing software">Editor</abbr> - '.$media->provider_name.'; ';
  }
  if (!$cc) {
    $out .= "<em>Captions - J.Bloggs&hellip;</em>";
  }
  return trim($out, " ;");
}

/**
 * http://creativecommons.org/licenses/by/2.0/uk/
 * http://i.creativecommons.org/l/by/2.0/uk/80x15.png
 */
function license_parse($url, $xml=TRUE) {
  if (!$url) return NULL;

  $p = parse_url($url);
  if ('creativecommons.org'!=$p['host']) return NULL;

  if (preg_match('#licenses\/([\w-]+)\/([\d\.]+)#', $p['path'], $matches)) { #(\/(\w*))?
    $terms  = $matches[1];
    $version= $matches[2];
    $text = 'Creative Commons';
    #$jurisdiction = $matches[4];
    if (false!==strpos($terms, 'by')) {
      $text .=' Attribution';
    }
    if (false!==strpos($terms, 'nc')) {
      $text .=' Non commercial';
    }
    if (false!==strpos($terms, 'nd')) {
      $text .=' No derivatives';
    }
    if (false!==strpos($terms, 'sa')) {
      $text .=' Share alike';
    }
    $text.=" $version License";
    $rdf = "http://creativecommons.org/licenses/$terms/$version/rdf";
    $img = "http://i.creativecommons.org/l/$terms/$version/80x15.png"; #88x31.

    if (!$xml) {#HTML.
      $html =<<<EOF
  <a rel="license" href="$url"><img alt="$text" title="$text" src="$img" /></a>
EOF;
      return $html;
    }
    $xmlns = 'xmlns:atom="http://www.w3.org/2005/Atom"';
    $xml =<<<EOF
<atom:link rel="license" href="$url" title="$text" />
<atom:link rel="license" type="application/rdf+xml" href="$rdf" />

EOF;
    return $xml;
  }  
}
