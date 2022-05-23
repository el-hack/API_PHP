<?php 
use Twilio\Rest\Client;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type ,Access-Contol-Allow-Headers, Authorization, X-Reauested-With");

    // On verifie aue la methode utilisée est correct
    if ($_SERVER['REQUEST_METHOD']  == 'POST') {
        $results = [];
        $retour = [];

        function retour_json($succes , $msg , $results = null){
            $retour["succes"] = $succes ; 
            $retour["message"] = $msg; 
            $retour["results"] = $results;
            echo json_encode($retour);
        }
        
        $pdo = new PDO('mysql:host=localhost;dbname=communale;','root','');

        // On instancie 



        // On récupère les données
        if (!empty($_POST["otp"]) && !empty($_POST["id"])) {

            $req = $pdo->prepare("SELECT * FROM users WHERE remember_token=? AND id=? ");

            $req->execute(array($_POST['otp'] , $_POST['id']));

            $data = $req->fetchAll(PDO::FETCH_ASSOC);

            if($req->rowCount() >= 1){

                $req2 = $pdo->prepare("UPDATE `communale`.`users` SET `active`='1' WHERE  `id`=?");

                $req2->execute(array($_POST['id']));

            retour_json(true , "Compte verifier" , $results);
            }else{
                retour_json(false , "Code incorrect" , $results);
            }

            
        }else{

        }
    }else{
        // On gère l'erreur
        http_response_code(405);
        echo json_encode(["message" => "La methode n'est pas autoriser"]);
    }

?>