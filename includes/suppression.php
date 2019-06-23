<?php
require '../includes/functions.php';
$succes = false;
if ($_COOKIE) {
    $Id = $_COOKIE['IdReservation'] ?? null;
    $Id = intval($Id);
    $bdd = getDatabase();
    $query = "DELETE FROM reservation WHERE Id=:id";
    $req = $bdd->prepare($query);
    $req->bindParam(':id',$Id);
    $req->execute();
    if ($req->execute()) {
        $succes = true;
    } 
}
header("Location: ../../index.php?delete=$succes");