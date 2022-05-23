<?php





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
        if (!empty($_POST["name"]) &&!empty($_POST["email"]) &&!empty($_POST["prenom"]) &&!empty($_POST["phone"]) && !empty($_POST["sexe"]) && !empty($_POST["date_naissance"]) && !empty($_POST["password"])) {

            $req = $pdo->prepare("SELECT * FROM users m  WHERE phone=?");
            $req->execute(array($_POST['phone']));

            if ($req->rowCount() == 0) {

                $requete = $pdo->prepare("INSERT INTO `users` (`name`,`email`,`password` , `prenom` , `phone` , `sexe` , `date_naissance`, `lieu_naissance` , `IdCommune` , `IdTypeUtilisateur`) VALUES (?,?,?,?,?,?,?, ? , ?, ?);");
                $requete->execute(array($_POST['name'] , $_POST['email'] , $_POST['password'],$_POST['prenom'] , $_POST['phone'] , $_POST['sexe'] , $_POST['date_naissance'] , $_POST['lieu_naissance'] , $_POST['IdCommune'] , $_POST['IdTypeUtilisateur']));     
                
                $req = $pdo->prepare("SELECT * FROM users WHERE phone=?");

                $req->execute(array($_POST['phone']));

                $data = $req->fetchAll(PDO::FETCH_ASSOC);

                $results = $data;


                require 'auth.php'; 


                $clef = auth();
                require_once '../genererToken.php';
                $token = genererToken();

                $req2 = $pdo->prepare("UPDATE `communale`.`users` SET `remember_token`=? WHERE  `id`=?");

                $req2->execute(array($token,$results[0]['id']));

                
                $curl = curl_init();
                
                
                
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B2250702928786/requests',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>'{
                    "outboundSMSMessageRequest": {
                        "address": "tel:+225'.$_POST['phone'].'",
                        "senderAddress":"tel:+2250702928786",
                        "outboundSMSTextMessage": {
                            "message": "MA CITE \nVotre code de validation est '.$token.'"
                        }
                    }
                } ',
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$clef
                  ),
                ));
                
                $response = curl_exec($curl);
                
                curl_close($curl);
                
            
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


