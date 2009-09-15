<?php
/**
* A multimedia embed filter for CodeIgniter, using oEmbed web services.
*
* @author N.D.Freear [AT] open.ac.uk, 2009-09-05.
* @uses http://oembed.com/
* @uses http://jquery-oembed.googlecode.com/
* @see http://drupal.org/project/video_filter (Inpiration, thanks!)
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
      'class'    => 'oembed',
      'function' => 'filter',
      'filename' => 'oembed_hook.php',
      'filepath' => 'hooks',
      'params'   => ($mode = 'link')  #OR 'braces'.
    );
*/


class oembed { #extends CI_Base {

  function filter($mode = 'link') {

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
      $pattern = '#<a rel="embed" href="((.+))">(.+)<\/a>#isU';
    }

    if (preg_match_all($pattern, $out, $matches)) {
      foreach ($matches[0] as $ci => $code) {

        $id  = 'oembed-'.$ci;
        $url = trim($matches[2][$ci]);
        $text= isset($matches[3][$ci]) ? trim($matches[3][$ci],' |') : 'Alternative to embedded content '.($ci+1);
        $embed ='';
        if ($ci < 1) {
          #$js_oembed = 'http://jquery-oembed.googlecode.com/files/jquery.oembed.min.js';
          $js_oembed = $CI->config->system_url().'application/hooks/jquery.oembed.js';
          #$js_malt = $CI->config->site_url()."js?url=".urlencode($url);

          $embed = <<<EOF

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>  
  <script type="text/javascript" src="$js_oembed"></script>
EOF;
        }
        $embed .= <<<EOF
  <script type="text/javascript">
    \$(document).ready(function() {
       \$("#$id").oembed("$url");
    });
  </script>
  <div id="$id" class="oembed"><a href="$url">$text</a></div>

EOF;
  /*<!-- MALT API hack. -->
  <script type="text/javascript" src="$js_malt"></script>
  */
        $out = str_replace($code, $embed, $out);
      }
    }
    echo $out;
  }

};
/* Location: ./system/application/hooks/oembed_hook.php */
