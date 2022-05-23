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
            $retour["status"] = $succes ; 
            $retour["message"] = $msg; 
            $retour["data"] = $results;
            echo json_encode($retour);
        }
        
        $pdo = new PDO('mysql:host=localhost;dbname=communale;','root','');

        // On instancie 



        // On récupère les données
        if (!empty($_POST["name"]) &&!empty($_POST["email"]) &&!empty($_POST["prenom"]) &&!empty($_POST["phone"]) && !empty($_POST["sexe"]) && !empty($_POST["date_naissance"]) && !empty($_POST["password"])) {

            $req = $pdo->prepare("SELECT * FROM users WHERE numero=?");
            $req->execute(array($_POST['numero']));

            if ($req->rowCount() == 0) {

                $requete = $pdo->prepare("INSERT INTO `users` (`name`,`email`,`password` , `prenom` , `numero` , `sexe` , `date_naissance`, `lieu_naissance` , `IdCommune` , `IdTypeUtilisateur`) VALUES (?,?,?,?,?,?,?, ? , ?, ?);");
                $requete->execute(array($_POST['name'] , $_POST['email'] , $_POST['password'],$_POST['prenom'] , $_POST['numero'] , $_POST['sexe'] , $_POST['date_naissance'] , $_POST['lieu_naissance'] , $_POST['IdCommune'] , $_POST['IdTypeUtilisateur']));     
                
                $req = $pdo->prepare("SELECT * FROM users WHERE numero=?");

                $req->execute(array($_POST['numero']));

                $data = $req->fetchAll(PDO::FETCH_ASSOC);

                $results = $data;

                require './genererToken.php';

                $token = genererToken(4);


                $req2 = $pdo->prepare("UPDATE `communale`.`users` SET `remember_token`=? WHERE  `id`=?");

                $req2->execute(array($token,$results[0]['id']));
                var_dump($token);
                var_dump($results[0]['id']);





                require __DIR__ . '/vendor/autoload.php';

                // Your Account SID and Auth Token from twilio.com/console
                $account_sid = 'AC5a10022557669a6db03133ffc9419d27';
                $auth_token = '8dc94735875376d7900b57d11a3f3644';
                // In production, these should be environment variables. E.g.:
                // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

                // A Twilio number you own with SMS capabilities
                $twilio_number = "+19705858972";

                $client = new Client($account_sid, $auth_token);
                $client->messages->create(
                    // Where to send a text message (your cell phone?)
                    $_POST['numero'],
                    array(
                        'from' => $twilio_number,
                        'body' => $token
                    )
                );

                
            
                retour_json(true , "l'tilisateur a été ajouté avec succes" , $results);
                $results= array() ; 
                
            }else{
                retour_json(false , "Compte deja existant",$results);
            } 
            
        
        }else{
            retour_json(false, "Il manque des infos");
        }        
    }else{
        // On gère l'erreur
        http_response_code(405);
        echo json_encode(["message" => "La methode n'est pas autoriser"]);
    }
