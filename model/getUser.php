<!-- fonction par rapport requet  -->
<?php

// function getAllUser(){
//     global $pdo;
// $sql = "INSERT INTO Humeur (nom_humeur, date) VALUES ($clickedHumeur, $getDate)";
//     $sth = $pdo->prepare($sql);
//     $sth->execute();
//     return $sth->fetchAll(pdo::FETCH_ASSOC);
// }
function getUser($id, $mdp)
{
    global $pdo;
    // $sql = "SELECT * FROM Employe WHERE utilisateur =:id";
    $sql = "SELECT * FROM `Employe` WHERE utilisateur = :id AND mdp = PASSWORD( :mdp )";
    // SELECT * FROM Vote INNER JOIN Humeur ON Vote.id_humeur = Humeur.id_humeur
    //count number of same humeurs : 
    // SELECT *, count(nom_humeur) AS vote_total FROM Vote INNER JOIN Humeur ON Vote.id_humeur = Humeur.id_humeur
    // GROUP BY nom_humeur 
    //select by month : 
    //SELECT *, MONTH(DATE_FORMAT(vote_date, "%Y/%m/%d")) AS month FROM Vote
    //select by day : 
    // SELECT *, DAY(DATE_FORMAT(vote_date, "%Y/%m/%d")) AS day FROM Vote 
    $sth = $pdo->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_STR);
    $sth->bindParam(':mdp', $mdp, PDO::PARAM_STR);
    $sth->execute();
    return $sth->fetch(pdo::FETCH_ASSOC);
}
