<?php
/**
 A simple maintenance page.
 @author N.D.Freear, 14 September 2009.
 @example
  $hook['pre_system'] = array(
    #'class'    => 'MyClass',
    #@todo: Uncomment next line to close site!
    ##'function' => 'maintenance',
    'filename' => 'maintenance.php',
    'filepath' => 'hooks',
    #'params'   => ($message = 'My custom message')
  );
*/
define('X_MAINTENANCE', TRUE);

function maintenance($message=NULL) {
  if (!$message) {
    $message = 'This web site is currently closed. Please try again later.';
  }
  #codeigniter/Common.php, libraries/Exceptions.php
  $error =& load_class('Exceptions');
  echo $error->show_error('Site closed for maintenance', $message);
  exit;
}
