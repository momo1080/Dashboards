<?php
require_once 'vendor/autoload.php';
require_once 'core/db.php';
require_once 'model/getUser.php';
// echo "default login";

// $_POST['identifiant'] = "admintest";
// $_POST['mdp'] = "1234";
// $_POST['identifiant'] = "person1";
// $_POST['mdp'] = "123456789";

// session_start();
// $_SESSION['logged'] = true;
// echo '$_POST : ';
// print_r($_POST);
// echo '$_SESSION : ';
// print_r($_SESSION);



function defaultAction()
{
    $action = 'default';

    if (isset($_POST['identifiant'])) {
        $user = getUser($_POST['identifiant'], $_POST['mdp']);
        // print_r($user);
        $action = checkUser($user);
    }


    // require_once 'views/login-test.html.twig';
    return $action;
}

function checkUser($user)
{
    // print_r($user);
    //si getUser() ne trouve aucun utilisateur avec cette identifiant :
    if ($user == "") {
        // echo 'aucun utilisateur trouvé';
        return "erreur";
    } else if ($user['admin'] == "true") {
        // echo 'Bon mot de passe admin!';
        session_start();
        $_SESSION['admin_logged'] = true;
        $_SESSION['id_service'] = $user['id_service'];
        return "admin";
    } else if ($user['admin'] == "false") {
        // echo 'Bon mot de passe employe!';
        session_start();
        $_SESSION['employe_logged'] = true;
        $_SESSION['id_service'] = $user['id_service'];
        $_SESSION['id_employe'] = $user['id_Employe'];
        return "employe";
    } else {
        // echo 'aucun utilisateur trouvé';
        return "default";
    }
}



$action = defaultAction();
// echo "ACTION = " . $action . " ";

if (strpos($uri, '/', 1) !== false) {
    $action = (strpos($uri, '/', strlen($controlleur) + 1)  === false) ? substr($uri, strpos($uri, '/', strlen($controlleur))) : substr($uri,  strlen($controlleur) + 1, (strpos($uri, '/', strlen($controlleur) + 1) - 1) - (strlen($controlleur) - 1) - 1);
    // var_dump($action);
}
switch ($action) {
    case 'default':
    case '/':
    case "";
        // echo "default action of defaultController.php";
        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader);
        // $template = $twig->load('admin-test.html.twig');
        echo $twig->render('index.html.twig', ['var1' => 'variables', 'subProject' => $subProject]);
        break;
    case 'admin';
        // defaultAction();
        // echo "admin start";
        header('Location: '.$subProject.'/admin');
        exit();

        // $loader = new \Twig\Loader\FilesystemLoader('views');
        // $twig = new \Twig\Environment($loader);
        // // $template = $twig->load('admin-test.html.twig');
        // echo $twig->render('admin-test.html.twig', ['var1' => 'variables', 'var2' => 'here']);
        // require_once 'views/admin-test.html.twig';
        break;
    case 'employe';
        // defaultAction();
        // require_once 'views/utilisateur.html.twig';
        header('Location: '.$subProject.'/employe');
        exit();
        break;
    case "erreur";
        
        // echo "erreur action of defaultController.php";
        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader);
        // $template = $twig->load('admin-test.html.twig');
        echo $twig->render('index.html.twig', ['erreurMsg' => 'Votre username et/ou votre mot de passe ne correspondent pas.',
        'subProject' => $subProject]);
        break;
    default:
        // echo 'ceci est action : '.$action;
        require_once 'views/404.html.php';
}
