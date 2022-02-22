<?php 
class Client{
    private $connexion;
    private $table ; 
    private $nom ; 
    private $prenom ; 
    private $adresse ; 

    public function __construct($db)
    {
        $this->connexion = $db;
    }

    public function lire(){
        $sql = "SELECT * FROM client";
        $requete = $this->connexion->prepare($sql);
        $requete->execute();
        return $requete ; 

    }
    public function lireUn($id){
        $sql = "SELECT * FROM `client` WHERE `client`.`id` = ". $id .";";
        $requete = $this->connexion->prepare($sql);
        $requete->execute(array($this->id));
    }



    public function ajouterClient(){
        if (!empty($_POST["nom"]) && !empty($_POST["prenomClient"]) && !empty($_POST["adresse"]) && !empty($_POST["statut"])) {
            $requete = $this->connexion->prepare("INSERT INTO `client` (`id`, `nom`, `prenom`, `adresse`, `statut`, `idTypeAbo`) VALUES (NULL, :nom, :prenom, :adresse, :statut, :idabo);");
            $requete->bindParam(':nom' , $_POST['nomClient']);
            $requete->bindParam(':prenom' , $_POST['prenomClient']);
            $requete->bindParam(':adresse' , $_POST['adresse']);
            $requete->bindParam(':statut' , $_POST['statut']);
            $requete->bindParam(':idabo' , $_POST['idTypeAbo']);
            $requete->execute();
            
        
        }else{
            echo json_encode(["message"=>"Il manque des information"]);
        }
    }   
    public function suprimer($id){
        $this->id = $id;
        $sql = "DELETE FROM `client` WHERE id = ? ";

        $requete = $this->connexion->prepare($sql);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $requete->bindParam(1 , $this->id);

        $requete->execute();
        return $requete;

    }
    public function verifieId($id){
        $this->id = $id;
        $sql = "SELECT * FROM client";
        $requete = $this->connexion->prepare($sql);
        $requete->execute();
        if ($requete) {
            # code...
        }
    }
    public function ajouterTypeAbonnement($nom, $idClient){
        $this->idClient = $idClient;
        $this->nom = $nom;
            $sql2 = "INSERT INTO `typeabo` (`nom`, `idClient`) VALUES ( ? , ?);";
            $requete2 =$this->connexion->prepare($sql2);
            $requete2->execute(array($this->nom , $this->idClient));  
        
    }
}

?>