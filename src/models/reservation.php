<?php
require("../core/data/database.php");

class Reservation extends Database {
    function __contruct() {
        $args = func_get_arg(0);
        $this->create();
        $id = $this->getId($args);
    }
    function __destruct() {
        $succes = false;
        if ($this->refus()) {
            $succes = true;
        }         
        $req->closeCursor();
        header("Location: ../../index.php?delete=$succes");
    }
    function getId($args) {
        $sqlReservation = "SELECT Id FROM reservation where `start` = :date AND title = :intitule ;";
        $reqReservation = Database::$database->prepare($sqlReservation);
        $reqReservation->bindParam(':date', $args['start']);
        $reqReservation->bindParam(':intitule', $args['intitule']);
        $reqReservation->execute();
        $dataReservation = $reqReservation->fetch();
        $reqReservation->closeCursor();
        $Id = $dataReservation['Id'];
        return $Id;
    }
    function create() {
        $sqlReservation = "INSERT INTO `reservation`(`nomIntervenant`,
         `start`, `end`, `title`, `typeReservation`,
         `typeParticipants`, `nbPers`, `estAnnonceEcran`,
          `annonce`, `IdDemandeur`, `IdDisposition`, `IdSalle`,
          `allDay`, `repeatWeek`) VALUES (";
        $i = 0;
        $len = count($this->$args);
        foreach ($this->$args as $value) {            
            if ($i == $len - 1) {
                $sqlReservation += "$value";
            } else {
                $sqlReservation += "$value, ";
            }
        }
        $sqlReservation += ");";
        $req = Database::$database->query($sqlReservation);
        $req->closeCursor();
    }
    static function update($id, $args) {

        /*
        $args = array();
        if (isset($_POST)) {
            foreach ($_POST as $key => $value) {
                array_push($args, $value ?? null);
            }
        }
        */
        sort($args);
        $sqlReservation = "UPDATE `reservation` SET `nomIntervenant`=".$args[6].",
        `start`=".$args[8].", `end`=".$args[2].", `title`=".$args[9].",
        `typeReservation`=".$args[11].", `typeParticipants`=".$args[10].",
        `nbPers`=".$args[5].", `estAnnonceEcran`=".$args[3].", `annonce`=".$args[1].",
        `IdDemandeur`=".$args[3].", `IdDisposition`=".$args[4].", `IdSalle`=".$args[5].",
        `allDay`=".$args[0].", `repeatWeek`=".$args[7]." WHERE `Id`=".$id;
        $res = Database::$database->query($sqlReservation);    
        $req->closeCursor();    
    }
    static function updateTime($id, $args) {
        sort($args);
        if ($args[1]==0) {
            $repeatWeek=0;
        } else {
            $repeatWeek=1;
        }
        $query = "UPDATE reservation SET `start`=".$args[2].", ";
        $query += "`allDay`=".$args[0].", `repeatWeek`=$repeatWeek WHERE Id=$id;";
        $req = Database::$database->query($sqlReservation);
        $req->closeCursor();
    }
    function refus()
    {
        $bdd = Database::$database;
        $query = "DELETE FROM reservation WHERE Id=".$this->$id;
        $resultat = $bdd->query($query);
        $query = "DELETE FROM fournir WHERE IdReservation=".$this->$id;
        $resultat = $bdd->query($query);
        $query = "DELETE FROM contenir WHERE IdReservation=".$this->$id;
        $resultat = $bdd->query($query);
        $resultat->closeCursor();
            
    }
    function acceptation()
    {
        $bdd = Database::$database;
        $query = "UPDATE reservation set `validation`= 1 WHERE Id =".$this->$id;
        $resultat = $bdd->query($query);
        $resultat->closeCursor();          
    }
    function acceptationPresta() 
    {
        $bdd = Database::$database;
        $query = "UPDATE reservation set `validationPresta`= 1 WHERE Id =".$this->$id;
        $resultat = $bdd->query($query);
        $resultat->closeCursor();
    }
}