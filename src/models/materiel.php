<?
require("../core/data/database.php");

class Materiel extends Database
{
    function __contruct(){
        $name = func_get_arg(0);
        assert($name==string);
        Materiel::create($name);
        $id = Materiel::getId($name);
    }
    public static function create($name) {
        $bdd = Database::$database;
        $sqlMateriel = "INSERT INTO materiel (`Libelle`) VALUES (:materiel)";
        $reqMateriel = $bdd->prepare($sqlMateriel);
        $reqMateriel->bindParam(":materiel", $name);
        $reqMateriel->execute();
        $reqMateriel->closeCursor();
    }
    public static function getId($name) {
        $bdd = Database::$database;
        $sqlMateriel = "SELECT Id FROM materiel WHERE Libelle=:materiel";
        $reqMateriel = $bdd->prepare($sqlMateriel);
        $reqMateriel->bindParam(":materiel", $name);
        $reqMateriel->execute();
        $res = $reqMateriel->fetch();
        $reqMateriel->closeCursor();
        $IdMateriel = $res['Id'];      
        return $IdMateriel;
    }
    static function insert($idReservation, $arrayMateriel, $nbordis, $internet) {
        $bdd = Database::$database;
        foreach ($arrayMateriel as $idMateriel) {
            if ($idMateriel == 2) {
                $sqlMateriel = "INSERT INTO `contenir`(`IdReservation`, `IdMateriel`, `nbOrdis`, `internet`) VALUES (:reservation,:materiel,:nbordis,:internet)";
                $reqMateriel = $bdd->prepare($sqlMateriel);
                $reqMateriel->bindParam(":reservation", $idReservation);
                $reqMateriel->bindParam(":materiel", $idMateriel);
                $reqMateriel->bindParam(":nbordis", $nbordis);
                $reqMateriel->bindParam(":internet", $internet);
                $reqMateriel->execute();
                $reqMateriel->closeCursor();
            } else {
                $sqlMateriel = "INSERT INTO `contenir`(`IdReservation`, `IdMateriel`) VALUES (:reservation,:materiel)";
                $reqMateriel = $bdd->prepare($sqlMateriel);
                $reqMateriel->bindParam(":reservation", $idReservation);
                $reqMateriel->bindParam(":materiel", $idMateriel);
                $reqMateriel->execute();
                $reqMateriel->closeCursor();
            }
        }
    }
    static function update($idReservation, $arrayMateriel, $nbordis, $internet) {
        $bdd = Database::$database;
        foreach ($arrayMateriel as $idMateriel) {
            if ($idMateriel == 2) {
                $sqlMateriel = "UPDATE `contenir` SET `IdMateriel`=:materiel, `nbOrdis`=:nbordis, `internet`=:internet WHERE IdReservation=:reservation";
                $reqMateriel = $bdd->prepare($sqlMateriel);
                $reqMateriel->bindParam(":reservation", $idReservation);
                $reqMateriel->bindParam(":materiel", $idMateriel);
                $reqMateriel->bindParam(":nbordis", $nbordis);
                $reqMateriel->bindParam(":internet", $internet);
                $reqMateriel->execute();
                $reqMateriel->closeCursor();
            } else {
                $sqlMateriel = "UPDATE `contenir` SET `IdMateriel`=:materiel WHERE IdReservation=:reservation";
                $reqMateriel = $bdd->prepare($sqlMateriel);
                $reqMateriel->bindParam(":reservation", $idReservation);
                $reqMateriel->bindParam(":materiel", $idMateriel);
                $reqMateriel->execute();
                $reqMateriel->closeCursor();
            }
        }
    }
}
