<?php
/**
* A multimedia embed filter for CodeIgniter, using oEmbed web services.
*
* @author N.D.Freear [AT] open.ac.uk, 2009-09-05.
* @see http://oembed.com/
* @see http://jquery-oembed.googlecode.com/
* @see http://drupal.org/project/video_filter (Inpiration, thanks!)
*
*   2010-02-24: Use jquery-oembed #r19, rework for simple class="embed" solution.
*
* http://cvs.drupal.org/viewvc.py/drupal/contributions/modules/video_filter/video_filter.module?view=markup
*/
/**
  Use:
    <a rel="embed" href="http://youtube.com/watch?v=grqt3HoLOIA">Learn about Moodle</a>

  Alternative (set hook 'params'=>'braces' - see below):
    [embed: http://youtube.com/watch?v=grqt3HoLOIA | Learn about Moodle]

  Setup:

  1. Copy this hook script to: ./system/application/hooks/oembed_hook.php

  2. Enable hooks:  ./system/application/config/config.php

    $config['enable_hooks'] = TRUE;

  3. Configure the filter:  ./system/application/config/hooks.php

    $hook['display_override'] = array(
      'class'   => 'Oembed_Hook',
      'function'=> 'filter',
      'filename'=> 'oembed_hook.php',
      'filepath'=> 'hooks',
      'params'  => array('localPath'=>'scripts', 'loadJquery'=>FALSE,
                'maxWidth'=>200, 'maxHeight'=>200), #Optional ('mode'=>'link' OR 'braces'.)
    );
*/
#error_reporting(E_ALL | E_STRICT);


class Oembed_Hook {  #extends CI_Base {

  function filter($params = NULL) {
    $mode = 'link';  # Maybe remove?
    $loadJquery = TRUE;
    $localPath = NULL;
    $maxHeight = $maxWidth = NULL;
    if (is_array($params) && sizeof($params) > 0) {
      $n_extracted = extract($params, EXTR_IF_EXISTS);
    }

    foreach (headers_list() as $hdr) {
      if (false!==stripos($hdr, 'Content-Type:') && false===stripos($hdr, 'text/html')) {
        return; # Not HTML.
      }
    }

    $CI =& get_instance();
    if (!isset($CI->output)) return;

    $out = $CI->output->get_output();

    $pattern = '#\[embed(\:(.+))?( .+)?\]#isU';
    if ('braces' !== $mode) {
      $pattern = '#<a class="embed" href="((.+))">(.+)<\/a>#isU';
    }

    #if (preg_match_all($pattern, $out, $matches)) {
/*      foreach ($matches[0] as $ci => $code) {

        $id  = 'oembed-'.$ci;
        $url = trim($matches[2][$ci]);
        $text= isset($matches[3][$ci]) ? trim($matches[3][$ci],' |') : 'Alternative to embedded content '.($ci+1);
        $embed ='';
        if ($ci < 1) {
*/

        $oembed_options = NULL;
        if (is_numeric($maxWidth) && is_numeric($maxHeight)) {
          $oembed_options = "null, { maxWidth:$maxWidth, maxHeight:$maxHeight }";
        }

        $element = 'body';
        $scripts = '';
        if ($loadJquery) {
          # JQ 1.3.2 is fairly recent, and smaller than the most recent.
          $js_jquery= 'http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js';
          $scripts .= "  <script type=\"text/javascript\" src=\"$js_jquery\"></script>".PHP_EOL;
        }
        $js_oembed = 'http://maltwiki.org/scripts/jquery.oembed.js';
        if (is_string($localPath)) {
          $js_oembed = base_url().$localPath.'/jquery.oembed.js';
        }
        $scripts .= <<<EOF
  <script type="text/javascript" src="$js_oembed"></script>
  <script type="text/javascript">
    \$(document).ready(function() {
       \$("a.embed"      ).oembed($oembed_options);
       \$("[rel='embed']").oembed();  //Legacy.
    });
  </script>
</$element>
EOF;

    $out = str_replace("</$element>", $scripts, $out);

    echo $out;
  }

};

/* Location: ./system/application/hooks/oembed_hook.php */
