<?php
    // if(isset($_SESSION['admin_logged'])){
    //     session_unset();
    //     session_destroy($_SESSION['admin_logged']);
    // }
    // if(isset($_SESSION['employe_logged'])){
    //     session_unset();
    //     session_destroy($_SESSION['employe_logged']);
    // }
    // if(isset($_SESSION['logged'])){
    //     session_unset();
    //     session_destroy($_SESSION['logged']);
    // }
    session_unset();
    // echo 'LOGOUT';
    // if (isset($_SESSION)) {
    //     print_r($_SESSION);
    //     print_r($_SESSION['admin_logged']);
    // }
    header('Location: '.$subProject.'/');
    exit();
?>