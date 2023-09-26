<?php
session_start();
$roleName = 'User';
$userName = '';

define('DS', DIRECTORY_SEPARATOR);

$script_name = $_SERVER['PHP_SELF'];
$page_name = substr(basename($script_name),0,strlen($script_name)-5);
define('PAGE_NAME', $page_name);

/** Define ROOT_PATH as this root directory **/
define('KDGA', 'kdga');

define('ROOT_PATH', dirname(__FILE__) . DS);

define('BASE_URL', 'https://kdga.org/');
define('KDGA_URL', BASE_URL . strtolower(KDGA) . DS);
define('SCORES_URL', KDGA_URL . 'scores' . DS);
define('MENUS_URL', KDGA_URL . 'menus' . DS);
define('ADMIN_URL', KDGA_URL . 'admin' . DS);

define('INCLUDES', ROOT_PATH . 'includes' . DS);
define('CLASSES', ROOT_PATH . 'classes' . DS);
define('HTML', ROOT_PATH . 'html' . DS);
define('MENUS', ROOT_PATH . 'menus' . DS);

include(INCLUDES . 'load.php');
?>
