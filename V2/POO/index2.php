<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type ,Access-Contol-Allow-Headers, Authorization, X-Reauested-With");

    // On verifie aue la methode utilisée est correct
    if ($_SERVER['REQUEST_METHOD']  == 'GET') {
        // On inclut les configurations
        include_once 'config/Database.php';
        include_once 'models/Client.php';


        // On instancie la base de donnée 
        $database = new Database();
        $db = $database->getConnexion();


        // On instancie 
        $client = new Client($db);



        // On récupère les données
        $stmt = $client->lire();

        // On vérifie si on a des client=s
            $clients = $stmt->fetchAll();

            $retour["nombres de clients"]= count($clients) ;

            $retour["clients"] = $clients;

            http_response_code(200);

            echo json_encode($retour);
        
    }else{
        // On gère l'erreur
        http_response_code(405);
        echo json_encode(["message" => "La methode n'est pas autoriser"]);
    }

?>