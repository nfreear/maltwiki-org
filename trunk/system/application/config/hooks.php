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

#ou-specific.
$hook['pre_system'] = array(
    #'class'    => 'MyClass',
    #@todo: Uncomment next line to close site!
    'function' => 'show_error', #'maintenance',  #'show_error',
    'filename' => 'Common.php', #'maintenance.php', #'Common.php',
    'filepath' => 'codeigniter', #'hooks', #'libraries',
    #'params'   => 'My custom message.',
);

$hook['display_override'] = array(
      'class'    => 'oembed',
      'function' => 'filter',
      'filename' => 'oembed_hook.php',
      'filepath' => 'hooks',
      'params'   => ($mode = 'link')  #OR 'braces'.
    );


/* End of file hooks.php */
/* Location: ./system/application/config/hooks.php */