<!-- fonction par rapport requet  -->
<?php

try {
    $sql = 'INSERT INTO has_voted (id_employe, vote_date) VALUES (:id_employe, DATE_FORMAT(CURRENT_TIMESTAMP, "%Y-%m-%d"))';



    // $selectedDate = "".$annee."-%".$mois."-".$jour."";
    $sth = $pdo->prepare($sql);
    $sth->bindParam(':id_employe', $idEmploye, PDO::PARAM_INT);
    $sth->execute();
    // return $sth->fetchAll(pdo::FETCH_ASSOC);

} catch (\Throwable $th) {
    //throw $th;
}
?>