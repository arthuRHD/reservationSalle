<?php





function getDispositionId($lib)
{
    $bdd = getDatabase();
    $sqlDisposition = "SELECT Id FROM disposition WHERE Libelle = :autretext";
    $reqDisposition = $bdd->prepare($sqlDisposition);
    $reqDisposition->bindParam(":autretext", $lib);
    $reqDisposition->execute();
    $dataDisposition = $reqDisposition->fetch();             // Retourne l'ID de la nouvelle disposition pour l'ajouter dans la réservation
    $reqDisposition->closeCursor();
    $IdDispo = $dataDisposition['Id'];
    return $IdDispo;
}
function getDemandeurId($nom, $service)
{
    $bdd = getDatabase();
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
function InsertDemandeur($demandeur, $service)
{
    $bdd = getDatabase();
    $sqlDisposition = "INSERT INTO `demandeur`(`nomDemandeur`, `IdService`) VALUES (:demandeur,:service)";
    $reqDisposition = $bdd->prepare($sqlDisposition);
    $reqDisposition->bindParam(":demandeur", $demandeur);
    $reqDisposition->bindParam(":service", $service);
    $reqDisposition->execute();
    $reqDisposition->closeCursor();
}
function InsertDisposition($autreText)
{
    $bdd = getDatabase();
    $sqlDisposition = "INSERT INTO `disposition`(`Libelle`) VALUES (:autretext)";
    $reqDisposition = $bdd->prepare($sqlDisposition);
    $reqDisposition->bindParam(":autretext", $autreText);            // Ajoute la nouvelle disposition dans la BdD
    $reqDisposition->execute();
    $reqDisposition->closeCursor();
}
function Reservation($intervenant, $typeReservation, $HdeDebut, $HdeFin, $intitule, $typeParticipant, $nbPers, $boolEcran, $annonce, $salle, $demandeur, $IdDispo, $allDay, $repeat)
{
    $bdd = getDatabase();
    $IdDispo = 1;
    $sqlReservation = "INSERT INTO `reservation`(`nomIntervenant`, `start`, `end`, `title`, `typeReservation`, `typeParticipants`, `nbPers`,
      `estAnnonceEcran`, `annonce`, `IdDemandeur`, `IdDisposition`, `IdSalle`, `allDay`, `repeatWeek`) VALUES 
      (:intervenant,:hdedebut,:hdefin,:intitule,:typereservation,
      :typeparticipant,:nbpers,:boolecran,:annonce,:demandeur,:dispo,:salle,:allday,:rep)";
    $reqReservation = $bdd->prepare($sqlReservation);
    $reqReservation->bindParam(":intervenant", $intervenant);
    $reqReservation->bindParam(":typereservation", $typeReservation);
    $reqReservation->bindParam(":hdedebut", $HdeDebut);
    $reqReservation->bindParam(":intitule", $intitule);
    $reqReservation->bindParam(":typeparticipant", $typeParticipant);
    $reqReservation->bindParam(":nbpers", $nbPers);
    $reqReservation->bindParam(":hdefin", $HdeFin);
    $reqReservation->bindParam(":boolecran", $boolEcran);
    $reqReservation->bindParam(":annonce", $annonce);
    $reqReservation->bindParam(":salle", $salle);
    $reqReservation->bindParam(":demandeur", $demandeur);
    $reqReservation->bindParam(":dispo", $IdDispo);
    $reqReservation->bindParam(":allday", $allDay);
    $reqReservation->bindParam(":rep", $repeat);
    $reqReservation->execute();
    $reqReservation->closeCursor();
}
function modifierReservation($intervenant, $typeReservation, $HdeDebut, $HdeFin, $intitule, $typeParticipant, $nbPers, $boolEcran, $annonce, $salle, $demandeur, $IdDispo, $allDay, $repeat, $Id) {
    $bdd = getDatabase();
    $IdDispo = 1;
    $sqlReservation = "UPDATE `reservation` SET `nomIntervenant`=:intervenant, `start`=:hdedebut, `end`=:hdefin, `title`=:intitule, `typeReservation`=:typereservation, `typeParticipants`=:typeparticipant, `nbPers`=:nbpers,
    `estAnnonceEcran`=:boolecran, `annonce`=:annonce, `IdDemandeur`=:demandeur, `IdDisposition`=:dispo, `IdSalle`=:salle, `allDay`=:allday, `repeatWeek`=:rep WHERE `Id`=:id";
    $reqReservation = $bdd->prepare($sqlReservation);
    $reqReservation->bindParam(":intervenant", $intervenant);
    $reqReservation->bindParam(":typereservation", $typeReservation);
    $reqReservation->bindParam(":hdedebut", $HdeDebut);
    $reqReservation->bindParam(":intitule", $intitule);
    $reqReservation->bindParam(":typeparticipant", $typeParticipant);
    $reqReservation->bindParam(":nbpers", $nbPers);
    $reqReservation->bindParam(":hdefin", $HdeFin);
    $reqReservation->bindParam(":boolecran", $boolEcran);
    $reqReservation->bindParam(":annonce", $annonce);
    $reqReservation->bindParam(":salle", $salle);
    $reqReservation->bindParam(":demandeur", $demandeur);
    $reqReservation->bindParam(":dispo", $IdDispo);
    $reqReservation->bindParam(":allday", $allDay);
    $reqReservation->bindParam(":rep", $repeat);
    $reqReservation->bindParam(":id", $Id);
    $reqReservation->execute();
    $reqReservation->closeCursor();
}
function getReservationId($date, $intitule)
{
    $bdd = getDatabase();
    $sqlReservation = "SELECT Id FROM reservation where `start` = :date AND title = :intitule ;";
    $reqReservation = $bdd->prepare($sqlReservation);
    $reqReservation->bindParam(':date', $date);
    $reqReservation->bindParam(':intitule', $intitule);
    $reqReservation->execute();
    $dataReservation = $reqReservation->fetch();
    $reqReservation->closeCursor();
    $Id = $dataReservation['Id'];
    return $Id;
}
function createMateriel($materiel) 
{
    $bdd = getDatabase();
    $sqlMateriel = "INSERT INTO materiel (`Libelle`) VALUES (:materiel)";
    $reqMateriel = $bdd->prepare($sqlMateriel);
    $reqMateriel->bindParam(":materiel", $materiel);
    $reqMateriel->execute();
    $reqMateriel->closeCursor();
}
function getIdMateriel($lib) 
{
    $bdd = getDatabase();
    $sqlMateriel = "SELECT Id FROM materiel WHERE Libelle=:materiel";
    $reqMateriel = $bdd->prepare($sqlMateriel);
    $reqMateriel->bindParam(":materiel", $materiel);
    $reqMateriel->execute();
    $res = $reqMateriel->fetch();
    $reqMateriel->closeCursor();
    $IdMateriel = $res['Id'];      
    return $IdMateriel;
}
function InsertMateriel($idReservation, $arrayMateriel, $nbordis, $internet)
{
    $bdd = getDatabase();
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
function modifierMateriel($idReservation, $arrayMateriel, $nbordis, $internet)
{
    $bdd = getDatabase();
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
function InsertPresta($idReservation, $arrayPresta)
{
    $bdd = getDatabase();
    foreach ($arrayPresta as $presta) {
        $sqlPresta = "INSERT INTO `fournir`(`IdReservation`, `IdPresta`) VALUES (:reservation,:presta)";
        $reqPresta = $bdd->prepare($sqlPresta);
        $reqPresta->bindParam(":reservation", $idReservation);
        $reqPresta->bindParam(":presta", $presta);
        $reqPresta->execute();
        $reqPresta->closeCursor();
    }
}
function modifierPresta($idReservation, $arrayPresta)
{
    $bdd = getDatabase();
    foreach ($arrayPresta as $presta) {
        $sqlPresta = "UPDATE `fournir` SET `IdPresta`=:presta WHERE `IdReservation`=:reservation";
        $reqPresta = $bdd->prepare($sqlPresta);
        $reqPresta->bindParam(":reservation", $idReservation);
        $reqPresta->bindParam(":presta", $presta);
        $reqPresta->execute();
        $reqPresta->closeCursor();
    }
}

function refus($tab)
{
    foreach ($tab as $key => $Id) {
        $bdd = getDatabase();
        $query = "DELETE FROM reservation WHERE Id=$Id";
        $resultat = $bdd->query($query);
        $resultat->closeCursor();
        $bdd = getDatabase();
        $query = "DELETE FROM fournir WHERE IdReservation=$Id";
        $resultat = $bdd->query($query);
        $resultat->closeCursor();
        $bdd = getDatabase();
        $query = "DELETE FROM contenir WHERE IdReservation=$Id";
        $resultat = $bdd->query($query);
        $resultat->closeCursor();
    }    
}
function acceptationPresta($tab) {
    foreach ($tab as $Id) {
        $bdd = getDatabase();
        $query = "UPDATE reservation set `validationPresta`= 1 WHERE Id = $Id";
        $resultat = $bdd->query($query);
        $resultat->closeCursor();
    }  
}
function refusPresta($tab) {
    foreach ($tab as $key => $Id) {
        $bdd = getDatabase();
        $query = "DELETE FROM fournir WHERE IdReservation=$Id";
        $resultat = $bdd->query($query);
        $resultat->closeCursor();
        $bdd = getDatabase();
    }  
}
function acceptation($tab)
{
    foreach ($tab as $Id) {
        $bdd = getDatabase();
        $query = "UPDATE reservation set `validation`= 1 WHERE Id = $Id";
        $resultat = $bdd->query($query);
        $resultat->closeCursor();
    }    
}
// donne les droits à différents comptes de l'AD

function getSalle() {
    $bdd = getDatabase();
    $query = "SELECT * FROM salle ORDER BY Libelle ASC;";
    $req = $bdd->query($query);
    $res = $req->fetchAll();
    $req->closeCursor();
    return $res;
}
function getDisposition()
{
    $bdd = getDatabase();
    $query = "SELECT * FROM disposition ORDER BY Libelle ASC;";
    $resultat = $bdd->query($query);
    $res = $resultat->fetchAll();
    $resultat->closeCursor();
    return $res;
}
function getService()
{
    $bdd = getDatabase();
    $query = "SELECT Id, libelleService FROM `service` ORDER BY libelleService ASC;";
    $resultat = $bdd->query($query);
    $res = $resultat->fetchAll();
    $resultat->closeCursor();
    return $res;
}
function getPresta($Id)
{
    $bdd = getDatabase();
    $query = "SELECT libelle FROM prestation INNER JOIN fournir ON fournir.IdPresta=prestation.Id WHERE fournir.IdReservation=$Id ORDER BY Libelle ASC;";
    $resultat = $bdd->query($query);
    $res = $resultat->fetchAll();
    $resultat->closeCursor();
    return $res;
}
function getMateriel($Id)
{
    $bdd = getDatabase();
    $query = "SELECT libelle, `nbOrdis`, `internet` FROM `contenir` INNER JOIN materiel ON materiel.Id=contenir.IdMateriel WHERE IdReservation=$Id ORDER BY Libelle ASC;";
    $resultat = $bdd->query($query);
    $res = $resultat->fetchAll();
    $resultat->closeCursor();
    return $res;
}