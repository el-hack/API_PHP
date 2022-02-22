<?php 


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type ,Access-Contol-Allow-Headers, Authorization, X-Reauested-With");

if ($_SERVER['REQUEST_METHOD']  == 'POST') {
    // On inclut les configurations
    include_once 'config/Database.php';
    include_once 'models/Client.php';


    // On instancie la base de donnée 
    $database = new Database();
    $db = $database->getConnexion();


    // On instancie 
        if (!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["adresse"]) && !empty($_POST["statut"]) && !empty($_POST["nomType"])) {
            $client = new Client($db);

            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $adresse = htmlspecialchars($_POST['adresse']);
            $statut = htmlspecialchars($_POST['statut']);

            $sql1 = "INSERT INTO `client` (`id`, `nom`, `prenom`, `adresse`, `statut`) VALUES (NULL, :nom, :prenom, :adresse, :statut);";
            $requete = $db->prepare($sql1);
            $requete->bindParam(':nom' , $nom);
            $requete->bindParam(':prenom' , $prenom);
            $requete->bindParam(':adresse' , $adresse);
            $requete->bindParam(':statut' , $statut);

           
            $requete->execute();
            http_response_code(201);
            echo json_encode(["message"=>"Client ajouté avec succes"]);

        }else{
            http_response_code(503);
            echo json_encode(["message"=>"L'ajout n'a pas été effectuer  Il manque des information"]);
        }
}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La methode n'est pas autoriser"]);
}

?>