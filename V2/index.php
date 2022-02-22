<?php 
include 'header.php';
$requete = $pdo->prepare("SELECT * FROM `client` ");
$requete->execute();
$resultats = $requete->fetchAll();



$results["nombre de client"] = count($resultats) ; 
$results["clients"] = $resultats ; 
// var_dump($resultat)

echo retour_json(true , "Voici la liste des client" , $results);
?>