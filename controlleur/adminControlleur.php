<?php
require_once 'vendor/autoload.php';
require_once 'core/db.php';
require_once 'model/getHumeurTotal.php';
// echo "ENTER ADMIN";
// print_r($_POST);
// print_r($_SESSION);


$currDate = explode("-", date("Y-m-d"));
// print_r($currDate);



$action = "default";



if (strpos($uri, '/', 1) !== false) {


    $action = (strpos($uri, '/', strlen($controlleur) + 1)  === false) ? substr($uri, strpos($uri, '/', strlen($controlleur)) + 1) : substr($uri,  strlen($controlleur) + 1, (strpos($uri, '/', strlen($controlleur) + 1) - 1) - (strlen($controlleur) - 1) - 1);
}
// echo "ACTION EST " . $action;

function getServiceIndex()
{
    $uri = $_SERVER['REQUEST_URI'];
    $expUri = explode("/", $uri);

    $exprReg = "#/[0-9]+#";

    //recupérer id style "la-chèvre-2"
    // $exprReg = "#/[a-z\-]+-[0-9]+#";
    $position = preg_match($exprReg, $uri, $matches); //$postion = 1 if found; else 0
    // var_dump($matches);

    if (count($matches) === 0) {
        require_once 'views/404.html.php';
        return 1;
    }

    if (count($expUri) === 4) {

        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader);
        // $template = $twig->load('admin-test.html.twig');
        echo $twig->render('admin.html', ['var1' => 'variables', 'var2' => 'here']);
        return $expUri[3];
    } else {
        // echo "SMALL URL; NO SERVICE INDEX OR TOO LONG";
        // require_once 'views/404.html.php';
        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader);
        // $template = $twig->load('admin-test.html.twig');
        echo $twig->render('404.html.php', ['var1' => 'variables', 'var2' => 'here']);
        return 1;
    }
}

function getServiceIndex2()
{
    global $uri;
    $expUri = explode("/", $uri);

    $exprReg = "#/[0-9]+#";

    //recupérer id style "la-chèvre-2"
    // $exprReg = "#/[a-z\-]+-[0-9]+#";
    $position = preg_match($exprReg, $uri, $matches); //$postion = 1 if found; else 0
    // var_dump($matches);

    if (count($matches) === 0) {
        require_once 'views/404.html.php';
        return 0;
    }

    if (count($expUri) === 4) {
        return $expUri[3];
    } else {

        return 0;
    }
}



switch ($action) {
    case 'default':
    case '':
        // echo json_encode($humeurMoisParJourTotal);
        // require_once 'views/admin.html';
        $loader = new \Twig\Loader\FilesystemLoader('views');
        $twig = new \Twig\Environment($loader);
        // $template = $twig->load('admin-test.html.twig');
        echo $twig->render('admin.html.twig', ['subProject' => $subProject]);
        break;


    case 'service':
        getServiceIndex();
        break;

    case 'ajax':

        $service_id = getServiceIndex2();


        $today = getdate();
        $annee = $today['year'];
        if ($today['mon'] < 10) {
            $mois = "0" . $today['mon'];
        } else {
            $mois = $today['mon'];
        }

        if ($today['mday'] < 10) {
            $jour = "0" . $today['mday'];
        } else {
            $jour = $today['mday'];
        }







        // $mois = "01";
        //!!!alternative recherche humeurs MOIS par service!!!

        $voteHeureuxMois = [];
        $voteStresseMois = array();
        $voteFatigueMois = array();









        //!!!alternative ALTERNATIVE recherche humeurs MOIS par service C EST LA BONNE ?!!!
        $allMonthData = goodHumeursMoisService($mois, $annee);
        // array_push($voteHeureuxMois, $allMonthData);
        for ($j = 0; $j < count($allMonthData); $j++) {

            array_push($voteHeureuxMois, $allMonthData[$j]['vote_tot_heureux']);
            array_push($voteStresseMois, $allMonthData[$j]['vote_tot_stresse']);
            array_push($voteFatigueMois, $allMonthData[$j]['vote_tot_fatigue']);
        }

        $humeurMoisParJourTotal = [];

        //si page $service_id == 0 c'est la page admin, donc :
        if ($service_id == 0) {
            $humeurMoisParJourTotal = humeurMoisParJourTotalAllService($mois, $annee);
        } else {
            //sinon c'est une page service, donc :
            $humeurMoisParJourTotal = humeurMoisParJourTotal($service_id, $mois, $annee);
        }


        //!!!alternative ALTERNATIVE recherche humeurs JOUR par service C EST LA BONNE ?!!!
        $humeurJourService = goodHumeursJourService($service_id, $jour, $mois, $annee);
        $voteHeureuxJour = array();
        $voteStresseJour = array();
        $voteFatigueJour = array();

        // array_push($voteHeureuxMois, $allMonthData);
        // array_push($voteHeureuxJour, $humeurJourService);
        if ($humeurJourService == false) {

            array_push($voteHeureuxJour, 0);
            array_push($voteHeureuxJour, 0);
            array_push($voteHeureuxJour, 0);
        } else {

            array_push($voteHeureuxJour, $humeurJourService['vote_tot_heureux']);
            array_push($voteHeureuxJour, $humeurJourService['vote_tot_fatigue']);
            array_push($voteHeureuxJour, $humeurJourService['vote_tot_stresse']);
        }

        //continue de chercher des infos sur le premier service qu'il trouve (limité à 5)(au cas ou qu'il y ai le service 1 en moins par ex)
        // while (count($humeurMoisParJourTotal) === 0 || $service_id > 5) {
        //     // $today = getdate();
        //     $humeurMoisParJourTotal = humeurMoisParJourTotal($service_id);
        //     $service_id++;
        // }

        //recup jour du mois (aide aussi pour savoir si c'est un jour avec 31/30/28 jours)
        //recup aussi votes pour chaques humeurs
        $joursArray = array();
        $voteHeureux = array();
        $voteStresse = array();
        $voteFatigue = array();
        $addedHumeur = [];
        $currJour = "01";
        // "nom_humeur":"stresse","vote_total":"2","vote_date":"2020-01-01"
        foreach ($humeurMoisParJourTotal as $value) {
            $oldJour = $currJour;
            $currJour = substr($value['vote_date'], -2);
            if ($oldJour != $currJour) {
                if (!in_array("heureux", $addedHumeur)) {
                    array_push($voteHeureux, 0);
                }
                if (!in_array("stresse", $addedHumeur)) {
                    array_push($voteStresse, 0);
                }
                if (!in_array("fatigue", $addedHumeur)) {
                    array_push($voteFatigue, 0);
                }
                $addedHumeur = [];
            }
            if ($value['nom_humeur'] == "heureux") {
                array_push($voteHeureux, $value['vote_total']);
                array_push($addedHumeur, "heureux");
            } elseif ($value['nom_humeur'] == "stresse") {
                array_push($voteStresse, $value['vote_total']);
                array_push($addedHumeur, "stresse");
            } elseif ($value['nom_humeur'] == "fatigue") {
                array_push($voteFatigue, $value['vote_total']);
                array_push($addedHumeur, "fatigue");
            }
            $jour = substr($value['vote_date'], -2);
            array_push($joursArray, $jour);
            // echo $value['vote_date'];

        }
        $joursArray = array_unique($joursArray);
        // print_r($joursArray);


        //créer json pour etre recup pour l'ajax de admin avec valeur tableau jour
        $jsonify = array(
            "data1" => [
                "labels" => $joursArray,
                "datasets" => [
                    0 => [
                        "label" => "Stressé",
                        "backgroundColor" => 'rgb(255, 99, 132)',
                        "borderColor" => 'rgb(255, 79, 116)',
                        "borderWidth" => 2,
                        "pointBorderColor" => false,
                        "data" => $voteStresse,
                        "fill" => false,
                        "lineTension" => .4,
                    ],
                    1 => [
                        "label" => "Heureux",
                        "fill" => false,
                        "lineTension" => .4,
                        "startAngle" => 2,
                        "data" => $voteHeureux,
                        "backgroundColor" => "transparent",
                        "pointBorderColor" => "#4bc0c0",
                        "borderColor" => '#4bc0c0',
                        "borderWidth" => 2,
                        "showLine" => true,
                    ],
                    2 => [
                        "label" => "Fatigué",
                        "fill" => false,
                        "lineTension" => .4,
                        "startAngle" => 2,
                        "data" => $voteFatigue,
                        "backgroundColor" => "transparent",
                        "pointBorderColor" => "#ffcd56",
                        "borderColor" => '#ffcd56',
                        "borderWidth" => 2,
                        "showLine" => true,
                    ]
                ]
            ],
            "dataMois" => [
                "type" => 'bar',
                "data" => [
                    "labels" => ["Comptabilité", "Juridique", "Logistique", "Secretariat"],
                    "datasets" => [
                        0 => [
                            "label" => "Heureux",
                            "fill" => false,
                            "lineTension" => 0,
                            "data" => $voteHeureuxMois,
                            "pointBorderColor" => "#4bc0c0",
                            "borderColor" => '#4bc0c0',
                            "borderWidth" => 2,
                            "showLine" => true,
                        ],
                        1 => [
                            "label" => "Fatigué",
                            "fill" => false,
                            "lineTension" => 0,
                            "startAngle" => 2,
                            "data" => $voteFatigueMois,
                            "backgroundColor" => "transparent",
                            "pointBorderColor" => "#ff6384",
                            "borderColor" => '#ff6384',
                            "borderWidth" => 2,
                            "showLine" => true,
                        ],
                        2 => [
                            "label" => "Stressé",
                            "fill" => false,
                            "lineTension" => 0,
                            "startAngle" => 2,
                            "data" => $voteStresseMois,
                            "backgroundColor" => "transparent",
                            "pointBorderColor" => "#ff6384",
                            "borderColor" => '#ff6384',
                            "borderWidth" => 2,
                            "showLine" => true,
                        ]
                    ]
                ],

            ],
            "id_service" => $service_id,
            "goodDataJour" => [
                "type" => 'bar',
                "data" => [
                    "labels" => ["Heureux", "Fatigué", "Stressé"],
                    "datasets" => [
                        0 => [
                            "label" => "Votes",
                            "fill" => false,
                            "lineTension" => 0,
                            "data" => $voteHeureuxJour,
                            "pointBorderColor" => ["#4bc0c0", "#ffcd56", "#ff6384"],
                            "borderColor" => ['#4bc0c0', "#ffcd56", '#ff6384'],
                            "borderWidth" => 2,
                            "showLine" => true,
                        ],
                    ]
                ],

            ],
        );
        // echo json_encode($humeurMoisParJourTotal);
        echo json_encode($jsonify);
        break;
    default:
        // echo "action est : " . $action;
        require_once 'views/404.html.php';
        break;
}
