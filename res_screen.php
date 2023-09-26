<?php
session_start();
if(isset($_SESSION['screen_width']) AND isset($_SESSION['screen_height'])){
    $screenType = '';
    if ($_SESSION['screen_width'] >= 800 && $_SESSION['screen_height'] >= 600) {
        $screenType = "Desktop";
    } else if ($_SESSION['screen_width'] >= 600 && $_SESSION['screen_height'] >= 960) {
        $screenType = "Tablet";
    } else if ($_SESSION['screen_width'] >= 300 && $_SESSION['screen_height'] >= 560) {
        $screenType = "Mobile";
    }
} else if(isset($_REQUEST['width']) AND isset($_REQUEST['height'])) {
    $_SESSION['screen_width'] = $_REQUEST['width'];
    $_SESSION['screen_height'] = $_REQUEST['height'];
    header('Location: ' . $_SERVER['PHP_SELF']);
} else {
    echo '<script type="text/javascript">window.location = "' . $_SERVER['PHP_SELF'] . '?width="+screen.width+"&height="+screen.height;</script>';
}

$width = '100%';
if ($screenType == 'Desktop') {
    $height = '800px';
} else if ($screenType == 'Tablet') {
    $height = '700px';
} else if ($screenType == 'Mobile') {
    $height = '550px';
}
?>
