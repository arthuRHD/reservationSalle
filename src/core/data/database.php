<?php 
require('../tools/jsonparser.php');

class Database extends JsonParser {

    static $database;

    function __construct() {
        $host = self::$json_db['host'];
        $port = self::$json_db['port'];
        $dbname = self::$json_db['dbname'];
        $username = self::$json_db['user'];
        $password = self::$json_db['password'];
        $database = Database::getDatabase($host, $port, $dbname, $username, $password);
    }
    static function getDatabase($host, $port, $dbname, $username, $password)
    {
        try {
            $pdo = new PDO("mysql:host=$hostname;port=$port;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (Exception $e) {
            $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
            die($msg);
        }
    }
    function reset() {
        $commande = "mysql --user=". $this->$username ." -h ". $this->$host ." -D ". $this->$dbname ." < script_bdd_reset.sql";    
        shell_exec($commande);
        die();
    }
}