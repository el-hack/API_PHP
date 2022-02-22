<?php 
header('Content-Type: application/json');
try {
    $pdo = new PDO('mysql:host=localhost;dbname=abonnement;','root','root');
} catch ( Exception $e) {
    retour_json(false,'Connexion a la base de donnée impossible');
}


function retour_json($succes , $msg , $results = null){
    $retour["succes"] = $succes ; 
    $retour["message"] = $msg; 
    $retour["results"] = $results;
    echo json_encode($retour);
}

?>
