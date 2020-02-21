<!-- fonction par rapport requet  -->
<?php
$sql = 'INSERT INTO Vote (id_humeur, id_service, vote_date) VALUES (:id_humeur, :id_service, DATE_FORMAT(CURRENT_TIMESTAMP, "%Y-%m-%d"))';



// $selectedDate = "".$annee."-%".$mois."-".$jour."";
$sth = $pdo->prepare($sql);
$sth->bindParam(':id_humeur', $selectedHumeur, PDO::PARAM_INT);
$sth->bindParam(':id_service', $selectedService,PDO::PARAM_INT);
$sth->execute();
// return $sth->fetchAll(pdo::FETCH_ASSOC);

?>