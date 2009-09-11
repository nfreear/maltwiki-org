<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/


#ou-specific
  $hook['display_override'] = array(
    'class'    => 'oembed',
    'function' => 'filter',
    'filename' => 'oembed_hook.php',
    'filepath' => 'hooks',
    'params'   => ($mode = 'link')  #OR 'braces'.
  );
#ou-specific ends.

/* End of file hooks.php */
/* Location: ./system/application/config/hooks.php */