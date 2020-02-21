<?php


function checkHasVoted($id)
{
    global $pdo;
    
    $sql = 'SELECT * FROM `has_voted` WHERE id_employe LIKE :id AND vote_date = DATE_FORMAT(CURRENT_TIMESTAMP, "%Y-%m-%d")';
    
    $sth = $pdo->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    return $sth->fetch(pdo::FETCH_ASSOC);
}