<?php
class Db{
    private $host;
    private $database;
    private $user;
    private $password;
    private $charset;
    public $db;

    public function __construct(){
        $this->host     = 'localhost';
        $this->database = 'db_museo';
        $this->user     = 'root';
        $this->password = "";
        $this->charset  = 'utf8mb4';
        $this->db = self::connect();
    }

    function connect(){
        try{
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->database . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($connection, $this->user, $this->password, $options);
            $pdo->exec("SET NAMES utf8");
            return $pdo;

        }catch(PDOException $e){
            print_r('Error connection: ' . $e->getMessage());
        }   
    }

    function debug($error,$tipo){
        try{
            $sql = "INSERT INTO DEBUG VALUES(:id,:error,:tipo,:fecha)";
            $query = $this->db->prepare($sql);
            $query->execute(['id' => Null, 'error' => $error, 'tipo' => $tipo, 'fecha' => date("Y-m-d H:i:s")]);
            return False;
        }catch(PDOException $e){
            return False;
        }
    }
}

?>