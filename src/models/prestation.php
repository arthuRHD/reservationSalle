<?
require("../core/data/database.php");

class Prestation extends Database
{
    static function InsertPresta($idReservation, $arrayPresta)
    {
        $bdd = Database::$database;
        foreach ($arrayPresta as $presta) {
            $sqlPresta = "INSERT INTO `fournir`(`IdReservation`, `IdPresta`) VALUES (:reservation,:presta)";
            $reqPresta = $bdd->prepare($sqlPresta);
            $reqPresta->bindParam(":reservation", $idReservation);
            $reqPresta->bindParam(":presta", $presta);
            $reqPresta->execute();
            $reqPresta->closeCursor();
        }
    }
    static function modifierPresta($idReservation, $arrayPresta)
    {
        $bdd = Database::$database;
        foreach ($arrayPresta as $presta) {
            $sqlPresta = "UPDATE `fournir` SET `IdPresta`=:presta WHERE `IdReservation`=:reservation";
            $reqPresta = $bdd->prepare($sqlPresta);
            $reqPresta->bindParam(":reservation", $idReservation);
            $reqPresta->bindParam(":presta", $presta);
            $reqPresta->execute();
            $reqPresta->closeCursor();
        }
    }
}
