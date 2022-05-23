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
            $retour["data"] = $results;
            echo json_encode($retour);
        }
        
        $pdo = new PDO('mysql:host=localhost;dbname=communale;','root','');

        // On instancie 



        // On récupère les données
        if (!empty($_POST["phone"])) {
           if(!empty($_POST['password'])){
            $requete = $pdo->prepare("SELECT * FROM `users` WHERE phone=?");
            $requete->execute(array($_POST['phone']));  
            
            if ($requete->rowCount() > 0) {
                $donne = $requete->fetch(PDO::FETCH_ASSOC);

                if ($donne['password'] == $_POST['password']) {
                    if ($donne['active'] == 1) {
                        retour_json(true , "Utilisateur trouver",$donne);
                    }else{
                        retour_json(false , "Compte inactive veuillez activez votre compte",$results);
                    }
                    
                    
                    
                }else{
                    retour_json(false , "Mot de passe incorrecte",$results);
                } 
                
            }else{
                retour_json(false , "L'utilisateur n'existe pas",$results);
            }
           }else{
            retour_json(false, "Veuillez entrer le mot de password",$results);

           }
        
        }else{
            retour_json(false, "Veuillez entrer le numero",$results);
        }
                
    }else{
        // On gère l'erreur
        http_response_code(405);
        echo json_encode(["message" => "La methode n'est pas autoriser"]);
    }

?>