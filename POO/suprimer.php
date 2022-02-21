<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type ,Access-Contol-Allow-Headers, Authorization, X-Reauested-With");

function message($message){
     echo json_encode(["message"=>$message]);
}


if ($_SERVER['REQUEST_METHOD']  == 'POST') {
    // On inclut les configurations
    include_once 'config/Database.php';
    include_once 'models/Client.php';


    // On instancie la base de donnée 
    $database = new Database();
    $db = $database->getConnexion();


    // On instancie 
    $client = new Client($db);

    // On récupère l'id


    if (!empty($_POST["idClient"])) {
        if (intval($_POST["idClient"])) {
            $client->suprimer($_POST["idClient"]);
            http_response_code(201);
            echo json_encode(["message"=>"Client supprimer avec succes"]);
        }else{
            http_response_code(503);
            echo json_encode(["message"=>"Entrer invalide veuillez entrer un nombre"]);
        }
    }else{
    http_response_code(503);
    echo json_encode(["message"=>"La suppression n'a pas été effectuer  Il manque des information"]);

    }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La methode n'est pas autoriser"]);
}
?>