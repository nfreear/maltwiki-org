<?php
/**
 * Utility functions.
 * @author N.D.Freear, 7 October 2009.
 * @package MALT
 */
class Mutil {};

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