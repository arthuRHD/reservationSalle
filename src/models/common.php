<?
require("../core/data/database.php");


class Common extends Database
{
    static function getService()
    {
        $bdd = Database::$database;
        $query = "SELECT Id, libelleService FROM `service` ORDER BY libelleService ASC;";
        $resultat = $bdd->query($query);
        $res = $resultat->fetchAll();
        $resultat->closeCursor();
        return $res;
    }   
    static function event()
    {
        $bdd = Database::$database;
        $query = "SELECT `repeatWeek`, allDay, libelleService, `validation`, validationPresta, nomDemandeur, reservation.Id, disposition.Libelle, typeParticipants, typeReservation, nomIntervenant, `title`, `start`, `end`, nbPers, salle.libelle FROM salle INNER JOIN reservation ON salle.Id=reservation.IdSalle INNER JOIN disposition ON disposition.Id=reservation.IdDisposition INNER JOIN demandeur ON demandeur.IdPoste=reservation.IdDemandeur INNER JOIN `service` ON service.Id=demandeur.IdService;";
        $resultat = $bdd->query($query);
        $infos = $resultat->fetchAll();
        $resultat->closeCursor();
        return $infos;
    }
}

