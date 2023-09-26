<?php
error_reporting(E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR);

define('CSS', ROOT_PATH . 'css' . DS);
define('IMAGES', ROOT_PATH . 'images' . DS);
define('CONTROLLER', ROOT_PATH . 'controller' . DS);
define('MODEL', ROOT_PATH . 'model' . DS);
define('VIEW', ROOT_PATH . 'view' . DS);
define('MOBILE', ROOT_PATH . 'mobile' . DS);
define('MENUS', ROOT_PATH . 'menus' . DS);
define('REGISTER', ROOT_PATH . 'registration' . DS);
define('PICTURES', ROOT_PATH . 'pictures' . DS);
define('CLASSES', ROOT_PATH . 'classes' . DS);

define('APP', 'app' . DS);
define('URL', 'https:' . DS . DS . 'kdga.org' . DS);
define('MAIN_CSS', URL . APP . 'css' . DS);

include(CLASSES . 'titles.class.php');

/** Include files **/
include(INCLUDES . 'config.php');
?>
