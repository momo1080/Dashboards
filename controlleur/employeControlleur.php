<?php
$action = 'default';
require_once 'vendor/autoload.php';
require_once 'core/db.php';
require_once 'model/getUser.php';
require_once 'model/checkHasVoted.php';


$userHasVoted = checkHasVoted($_SESSION["id_employe"]);
if ($userHasVoted == "") {
    $action = 'default';
    if (strpos($uri, '/', 1) !== false) {


        $action = (strpos($uri, '/', strlen($controlleur) + 1) === false) ? substr($uri, strpos($uri, '/', strlen($controlleur)) + 1) : substr($uri, strlen($controlleur) + 1, (strpos($uri, '/', strlen($controlleur) + 1) - 1) - (strlen($controlleur) - 1) - 1);
    }
} else {
    $action = 'has voted';
}



switch ($action) {
    case 'default':
        // require_once 'views/employe.html';
        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader);
        // $template = $twig->load('admin-test.html.twig');
        echo $twig->render('employe.html.twig', ['emoticons' => "emoticons", 'subProject' => $subProject]);
        break;

    case 'humeur':
        $today = getdate();
        // $uri = $_SERVER['REQUEST_URI'];
        $expUri = explode("/", $uri);

        if(!isset($expUri[3])){
            header('Location: /employe');
            exit();
        }
        // print_r($_SESSION);
        //si le chiffre du vote est entre 1 et 3 compris :
        if ($expUri[3] < 1 || $expUri[3] > 4 || $expUri[3] == "") {

            $loader = new \Twig\Loader\FilesystemLoader('views');
            $twig = new \Twig\Environment($loader);
            echo $twig->render('employe.html.twig', ['emoticons' => "emoticons", 'subProject' => $subProject]);
        } else {

            $selectedHumeur = $expUri[3];
            $selectedService = $_SESSION['id_service'];
            $idEmploye = $_SESSION['id_employe'];
            require_once 'model/insertHumeur.php';
            require_once 'model/insertHasVoted.php';
            
            $loader = new \Twig\Loader\FilesystemLoader('views');
            $twig = new \Twig\Environment($loader);
            echo $twig->render('message.html.twig', ['hasVoted' => "Merci d'avoir voté!", 'subProject' => $subProject]);
            // echo 'employe humeur';
        }

        break;

    case 'has voted':
        
        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader);
        echo $twig->render('message.html.twig', ['hasVoted' => "Merci d'avoir voté!", 'subProject' => $subProject]);
        break;

    default:
        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader);
        echo $twig->render('404.html.php', ['message' => "404"]);
        break;
}

exit;
