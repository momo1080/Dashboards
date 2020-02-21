
<?php
session_start();


$subProject = '/softrh';
$uri = $_SERVER['REQUEST_URI'];
// echo $uri;
$uri = str_replace($subProject, '', $uri);
// echo $uri;

$controlleur = $uri;

if ($uri !== "/") {
    $positionSlash = (strpos($uri, "/", 1) === false) ? strlen($uri) : strpos($uri, "/", 1);
    // var_dump(($positionSlash));
    $controlleur = substr($uri, 0, $positionSlash);
    // var_dump($controlleur);
    // echo 'chemin long';
}
switch ($controlleur) {
    case "/";
        require_once 'controlleur/defaultControlleur.php';
        // echo 'applle controlleur home';
        break;

    case "/admin";
        if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true) {
            require_once 'controlleur/adminControlleur.php';
        } else {
            // require_once 'controlleur/defaultControlleur.php';
            header('Location: '.$subProject);
            exit();
        }
        // echo 'applle de controlleur film';
        break;

    case "/employe";
        if (isset($_SESSION['employe_logged']) && $_SESSION['employe_logged'] == true) {
            require_once 'controlleur/employeControlleur.php';
        } else {
            // require_once 'controlleur/defaultControlleur.php';
            header('Location: '.$subProject);
            exit();
        }
        // require_once 'controlleur/employeControlleur.php';
        // echo 'applle de controlleur employe';
        break;

    case "/logout";
        require_once 'controlleur/logoutControlleur.php';
        // echo 'applle de controlleur logout';
        break;

    default:
        // require_once 'views/404.html.php'  ;
        require_once 'controlleur/defaultControlleur.php';
}
