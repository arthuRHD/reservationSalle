<?
require("../core/data/database.php");


class Demandeur extends Database {
    function __construct() {
        $name = func_get_arg(0);
        $service = func_get_arg(1);
        $id = $this->getDemandeurId($name, $service);
    }
    function getDemandeurId($nom, $service)
    {
        $bdd = Database::$database;
        $sqlDemandeur = "SELECT IdPoste FROM demandeur WHERE nomDemandeur = :nom AND IdService = :service;";
        $reqDemandeur = $bdd->prepare($sqlDemandeur);
        $reqDemandeur->bindParam(":nom", $nom);
        $reqDemandeur->bindParam(":service", $service);
        $reqDemandeur->execute();
        $dataDemandeur = $reqDemandeur->fetch();             // Retourne l'ID de la nouvelle disposition pour l'ajouter dans la réservation
        $reqDemandeur->closeCursor();
        $IdDemandeur = $dataDemandeur['IdPoste'];
        return $IdDemandeur;
    }
    static function InsertDemandeur($demandeur, $service)
    {
        $bdd = Database::$database;
        $sqlDisposition = "INSERT INTO `demandeur`(`nomDemandeur`, `IdService`) VALUES (:demandeur,:service)";
        $reqDisposition = $bdd->prepare($sqlDisposition);
        $reqDisposition->bindParam(":demandeur", $demandeur);
        $reqDisposition->bindParam(":service", $service);
        $reqDisposition->execute();
        $reqDisposition->closeCursor();
    }
}