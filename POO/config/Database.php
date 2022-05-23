<?php 

class Database{



    // Connexion a la base de données

    private $host = 'localhost' ;
    private $db_name = 'essaie' ;
    private $username = 'root' ;
    private $password = '';
    public $connexion ;

    //getter pour la connexion 

    public function getConnexion(){

        $this->conexion = null ;

        try {
            $this->connexion =  new PDO('mysql:host='. $this->host .';dbname='. $this->db_name .';', $this->username , $this->password);
            $this->connexion->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Erreur de connexion :". $exception->getMessage();
        }

        return $this->connexion;
    }

}

?>