<?php
function getDatabase()
{
    $hostname = "localhost";
    $port = 3306;
    $username = "root";           // à changer à l'avenir lors de l'installation du serveur Apache MySQL (env. de prod.)
    $password = "";
    $dbname = "BdDReserv";
    try {
        $pdo = new PDO("mysql:host=$hostname;port=$port;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (Exception $e) {
        $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
        die($msg);
    }
}
function getDatabaseAdmin()
{
    $hostname = "localhost";
    $port = 3306;
    $username = "adminApp";           // à changer à l'avenir lors de l'installation du serveur Apache MySQL (env. de prod.)
    $password = "";
    $dbname = "BdDReserv";
    try {
        $pdo = new PDO("mysql:host=$hostname;port=$port;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (Exception $e) {
        $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
        die($msg);
    }
}
function getLDAP()
{
    $ldaphost = "10.1.0.25";
    $ldapport = '389';
    try {
        $ad = @ldap_connect($ldaphost, $ldapport);
        ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
        return $ad;
    } catch (Exception $e) {
        $error_msg = 'Erreur LDAP : ' . $e;
        require RACINE . 'public/page.phtml';
        die($error_msg);
    }
}
function startSession()
{
    if (session_status() == PHP_SESSION_NONE) { // sinon ça affiche une erreur qui dit que la session est déjà démarrée (si on en recrée une)
        session_start();
    }
}
function SignIn($lib, $user, $pass)
{
    $bdd = getDatabase();
    $hash = password_hash($pass, PASSWORD_BCRYPT);
    $query = "INSERT INTO service (libelleService,userService,pwdService) VALUES (:lib,:pseudo,:mdp)";
    $req = $bdd->prepare($query);
    $req->bindParam(':lib', $lib);
    $req->bindParam(':pseudo', $user);
    $req->bindParam(':mdp', $hash);
    $req->execute();
    $req->closeCursor();
    header('Location: ../index.php');
    die();
}
function LoginMySQL($user, $pass)
{
    $bdd = getDatabase(); // Appel de la base de données
    $query = "SELECT pwdService FROM service WHERE userService = '$user';"; // selectionner le pwd avec l'identifiant rentré
    $req = $bdd->prepare($query);
    $req->bindParam(":user", $user);
    $req->execute();
    $res = $req->fetch();
    $HashedPwdInDb = $res['pwdService'];
    $hash = substr($HashedPwdInDb, 0, 60);
    if (password_verify($pass, $hash)) {    // vérifie que le pwd rentré à la même valeur que son hash
        startSession();
        session_id($user);
        $_SESSION['user'] = $user;
        header("Location: ../index.php");
    } else {
        $_SESSION['error_login'] = $res;
        header("Location: ../pages/login.php");
    }
    $req->closeCursor();
    die();
}
function LoginLDAP($user="t.cramoisan", $pass)
{
    if (!defined("LDAP_OPT_DIAGNOSTIC_MESSAGE")) {
        define("LDAP_OPT_DIAGNOSTIC_MESSAGE", 0x0032); // pour avoir une connexion plus détaillée
    }
    $login = 'info';
    $pwd = 'tpaqcere';
    $succes = true;
    //$ad = getLDAP();
    /*$connexion = @ldap_bind($ad, $login, $pwd);
    if ($connexion) {
        $filtre = "(sAMAccountName=$user)";
        $resultatLDAP = ldap_search($ad, "OU=UTILISATEURS DOMAINE,OU=UTILISATEURS SOTTEVILLE,DC=sotteville,DC=local", $filtre);
        $infos = ldap_get_entries($ad, $resultatLDAP);
        if ($infos['count'] == 1) {
            $succes = true;
        }
    }*/
    if ($succes) {
       // @ldap_close($ad);
        //unset($ad);
        startSession();
        session_id($user);
        $_SESSION['user'] = $user;
        header("Location: ../index.php");
    } else {
        @ldap_close($ad);
        unset($ad);
        $_SESSION['error_login'] = "erreur de connexion";
        header("Location: ../pages/login.php");
    }
    die();
}
function Logout()
{
    session_start();
    session_destroy();
    header("Location: ../pages/login.php");
    die();
}
function isAuth()
{
    return isset($_SESSION['user']);
}
function needAuth()
{
    if (!isAuth()) {
        $_SESSION['error_bypass'] = "Vous devez être connecté pour accéder à cette page !";
        header('Location: ../../pages/login.php'); // redirige vers une la page de connexion
        die();
    }
}
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
function event()
{
    $bdd = getDatabase();
    $query = "SELECT `repeatWeek`, allDay, libelleService, `validation`, validationPresta, nomDemandeur, reservation.Id, disposition.Libelle, typeParticipants, typeReservation, nomIntervenant, `title`, `start`, `end`, nbPers, salle.libelle FROM salle INNER JOIN reservation ON salle.Id=reservation.IdSalle INNER JOIN disposition ON disposition.Id=reservation.IdDisposition INNER JOIN demandeur ON demandeur.IdPoste=reservation.IdDemandeur INNER JOIN `service` ON service.Id=demandeur.IdService;";
    $resultat = $bdd->query($query);
    $infos = $resultat->fetchAll();
    $resultat->closeCursor();
    return $infos;
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
function giveRightsRP($session)
{
    if ($session == "t.cramoisan" || $session == "r.sabalic") {
        return true;
    } 
    return false;
}
function giveRightsAccueil($session) {
    if ($session == 'accueil.central'|| $session == 'info') {
        return true;
    } 
    return false;
}
function giveRightsDisposition($session) {
    if ($session == "f.baviere") {
        return true;
    } 
    return false;    
}
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
function resetBdD() {
    // vider les tables des réservation -> Attention car peut supprimer toutes les réservations confondues, à utiliser en cas de surcharge de base de données
    $commande = "mysql --user=root -h 127.0.0.1 -D bddreserv < C:\xampp\htdocs\script_bdd_reset.sql";    
    return shell_exec($commande);
}
function giveRightsBDD($session) {
    if ($session == "j.raharison"||$session == "info") {
        return true;
    } 
    return false;   
}