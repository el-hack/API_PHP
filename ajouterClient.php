<?php 

include 'header.php';
$results = [];
$retour = [];
if (!empty($_POST["nomClient"]) && !empty($_POST["prenomClient"]) && !empty($_POST["adresse"]) && !empty($_POST["statut"])) {
    $requete = $pdo->prepare("INSERT INTO `client` (`idClient`, `nomClient`, `prenomClien`, `adresse`, `statut`) VALUES (NULL, :nom, :prenom, :adresse, :statut);");
    $requete->bindParam(':nom' , $_POST['nomClient']);
    $requete->bindParam(':prenom' , $_POST['prenomClient']);
    $requete->bindParam(':adresse' , $_POST['adresse']);
    $requete->bindParam(':statut' , $_POST['statut']);
    $requete->execute();


    retour_json(true , 'Le client a été ajouté avec succes' , $results);
    $results= array() ; 

}else{
    retour_json(false, "Il manque des infos");
}

echo json_encode($retour);
?>