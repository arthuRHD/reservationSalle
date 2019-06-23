<?php 
require './functions.php';
$bdd = getDatabase();
if (isset($_POST)) {
    $start = $_POST['start'] ?? null;
    $end = $_POST['end'] ?? null;
    $dow = $_POST['dow'] ?? null;
    $allDay = $_POST['allDay'] ?? null;
    $Id = $_POST['Id'] ?? null;
    if ($dow==0) {
        $repeatWeek=0;
    } else {
        $repeatWeek=1;
    }
    $query = "UPDATE reservation SET `start`=:debut , `allDay`=:allday , `repeatWeek`=:rep WHERE Id=:id;";
    $requete = $bdd->prepare($query);
    $requete->bindParam(":debut",$start);
    $requete->bindParam(":allday",$allDay);
    $requete->bindParam(":rep",$repeatWeek);
    $requete->bindParam(":id",$Id);
    $requete->execute();
    $requete->closeCursor();
}