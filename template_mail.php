<?php
require './includes/functions.php';
setlocale(LC_TIME, "fr_FR");
$date = strftime("%A %d %B", time());
$dateStartWeek = strftime('%A %d', time() + 86400 + 84000 + 84000);
$dateEndWeek = strftime("%A %d %B %Y", time() + 604800);
$strWeek = "$dateStartWeek au $dateEndWeek";
$bdd = getDatabase();
?>

<!DOCTYPE html>
<!-- Créateur : Arthur RICHARD -->
<!-- Site : http://richardinfo.tk -->
<!-- Email : arthur.richard2299@gmail.com -->
<!-- LinkedIn : https://www.linkedin.com/in/arthur-richard-884645176/ -->
<html lang="fr" style="background: rgb(235, 235, 235);">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="text/html">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Modèle email</title>
</head>

<body style="background: rgb(235, 235, 235);">
    <div class="col-6 offset-3">
        <div class="card">
            <div class="card-header" style="text-align: center;background: rgb(60, 65, 136);color: white;font-family: 'Times New Roman', Times, serif;">
                <h4>Planning du <?php echo $strWeek; ?></h4>
            </div>
            <div class="card-body">
                <table>
                    <ul style="list-style:none;">
                        <li><?php echo strftime("%A %d %B", time() + 86400 + 84000 + 84000); ?>
                            <ul style="list-style:block;list-style:url(https://upload.wikimedia.org/wikipedia/commons/d/d3/VisualEditor_-_Icon_-_Move-ltr.svg);">
                                <?php
                                $bdd = getDatabase();
                                $queryLundi = "SELECT salle.libelle, nbPers, start, end, title, typeReservation, typeParticipants, nomDemandeur, libelleService, materiel.Libelle, contenir.nbOrdis, contenir.internet, prestation.Libelle FROM reservation INNER JOIN salle ON salle.Id=reservation.IdSalle INNER JOIN contenir ON contenir.IdReservation=reservation.Id INNER JOIN materiel ON materiel.Id=contenir.IdMateriel INNER JOIN fournir ON reservation.Id=fournir.IdReservation INNER JOIN prestation ON fournir.IdPresta=prestation.Id INNER JOIN demandeur ON demandeur.IdPoste=reservation.IdDemandeur INNER JOIN service ON service.Id=demandeur.IdService WHERE start = NOW()+INTERVAL 3 DAY";
                                $reqLundi = $bdd->query($queryLundi);
                                $resLundi = $reqLundi->fetchAll();
                                $reqLundi->closeCursor();
                                foreach ($resLundi as $valeurLundi) {
                                    $titre = $valeurLundi['title'];
                                    $desc = $valeurLundi['libelle'] + ' / ' + $valeurLundi['nbPers'] + ' personnes' + ' / ' + $valeurLundi[''] + ' / ' + $valeurLundi[''];
                                    echo "<li><b>$titre : </b>$desc</li>";
                                } ?>
                            </ul>
                        </li>
                        <li><?php echo strftime("%A %d %B", time() + 86400 + 84000 + 84000 + 84000); ?>
                            <ul>
                                <?php
                                $bdd = getDatabase();
                                $queryMardi = "SELECT salle.libelle, nbPers, start, end, title, typeReservation, typeParticipants, nomDemandeur, libelleService, materiel.Libelle, contenir.nbOrdis, contenir.internet, prestation.Libelle FROM reservation INNER JOIN salle ON salle.Id=reservation.IdSalle INNER JOIN contenir ON contenir.IdReservation=reservation.Id INNER JOIN materiel ON materiel.Id=contenir.IdMateriel INNER JOIN fournir ON reservation.Id=fournir.IdReservation INNER JOIN prestation ON fournir.IdPresta=prestation.Id INNER JOIN demandeur ON demandeur.IdPoste=reservation.IdDemandeur INNER JOIN service ON service.Id=demandeur.IdService WHERE start = NOW()+INTERVAL 4 DAY";
                                $reqMardi = $bdd->query($queryMardi);
                                $resMardi = $reqMardi->fetchAll();
                                $reqMardi->closeCursor();
                                foreach ($resMardi as $valeurMardi) {
                                    $titre = $valeurMardi['title'];
                                    $desc = $valeurMardi['libelle'] + ' / ' + $valeurMardi['nbPers'] + ' personnes' + ' / ' + $valeurMardi[''] + ' / ' + $valeurMardi[''];
                                    echo "<li><b>$titre : </b>$desc</li>";
                                }
                                ?>
                            </ul>
                        </li>
                        <li><?php echo strftime("%A %d %B", time() + 86400 + 84000 + 84000 + 84000 + 84000); ?>
                            <ul>
                                <?php
                                $bdd = getDatabase();
                                $queryMercredi = "SELECT salle.libelle, nbPers, start, end, title, typeReservation, typeParticipants, nomDemandeur, libelleService, materiel.Libelle, contenir.nbOrdis, contenir.internet, prestation.Libelle FROM reservation INNER JOIN salle ON salle.Id=reservation.IdSalle INNER JOIN contenir ON contenir.IdReservation=reservation.Id INNER JOIN materiel ON materiel.Id=contenir.IdMateriel INNER JOIN fournir ON reservation.Id=fournir.IdReservation INNER JOIN prestation ON fournir.IdPresta=prestation.Id INNER JOIN demandeur ON demandeur.IdPoste=reservation.IdDemandeur INNER JOIN service ON service.Id=demandeur.IdService WHERE start = NOW()+INTERVAL 5 DAY";
                                $reqMercredi = $bdd->query($queryMercredi);
                                $resMercredi = $reqMercredi->fetchAll();
                                $reqMercredi->closeCursor();
                                foreach ($resMercredi as $valeurMercredi) {
                                    $titre = $valeurMercredi['title'];
                                    $desc = $valeurMercredi['libelle'] + ' / ' + $valeurMercredi['nbPers'] + ' personnes' + ' / ' + $valeurMercredi[''] + ' / ' + $valeurMercredi[''];
                                    echo "<li><b>$titre : </b>$desc</li>";
                                }
                                ?>
                            </ul>
                        </li>
                        <li><?php echo strftime("%A %d %B", time() + 86400 + 84000 + 84000 + 84000 + 84000 + 84000); ?>
                            <ul>
                                <?php
                                $bdd = getDatabase();
                                $queryJeudi = "SELECT salle.libelle, nbPers, start, end, title, typeReservation, typeParticipants, nomDemandeur, libelleService, materiel.Libelle, contenir.nbOrdis, contenir.internet, prestation.Libelle FROM reservation INNER JOIN salle ON salle.Id=reservation.IdSalle INNER JOIN contenir ON contenir.IdReservation=reservation.Id INNER JOIN materiel ON materiel.Id=contenir.IdMateriel INNER JOIN fournir ON reservation.Id=fournir.IdReservation INNER JOIN prestation ON fournir.IdPresta=prestation.Id INNER JOIN demandeur ON demandeur.IdPoste=reservation.IdDemandeur INNER JOIN service ON service.Id=demandeur.IdService WHERE start = NOW()+INTERVAL 4 DAY";
                                $reqJeudi = $bdd->query($queryJeudi);
                                $resJeudi = $reqJeudi->fetchAll();
                                $reqJeudi->closeCursor();
                                foreach ($resJeudi as $valeurJeudi) {
                                    $titre = $valeurJeudi['title'];
                                    $desc = $valeurJeudi['libelle'] + ' / ' + $valeurJeudi['nbPers'] + ' personnes' + ' / ' + $valeurJeudi[''] + ' / ' + $valeurJeudi[''];
                                    echo "<li><b>$titre : </b>$desc</li>";
                                }
                                ?>
                            </ul>
                        </li>
                        <li><?php echo $dateEndWeek; ?>
                            <ul>
                                <?php
                                $bdd = getDatabase();
                                $queryVendredi = "SELECT salle.libelle, nbPers, start, end, title, typeReservation, typeParticipants, nomDemandeur, libelleService, materiel.Libelle, contenir.nbOrdis, contenir.internet, prestation.Libelle FROM reservation INNER JOIN salle ON salle.Id=reservation.IdSalle INNER JOIN contenir ON contenir.IdReservation=reservation.Id INNER JOIN materiel ON materiel.Id=contenir.IdMateriel INNER JOIN fournir ON reservation.Id=fournir.IdReservation INNER JOIN prestation ON fournir.IdPresta=prestation.Id INNER JOIN demandeur ON demandeur.IdPoste=reservation.IdDemandeur INNER JOIN service ON service.Id=demandeur.IdService WHERE start = NOW()+INTERVAL 4 DAY";
                                $reqVendredi = $bdd->query($queryVendredi);
                                $resVendredi = $reqVendredi->fetchAll();
                                $reqVendredi->closeCursor();
                                foreach ($resVendredi as $valeurVendredi) {
                                    $titre = $valeurVendredi['title'];
                                    $desc = $valeurVendredi['libelle'] + ' / ' + $valeurVendredi['nbPers'] + ' personnes' + ' / ' + $valeurVendredi[''] + ' / ' + $valeurVendredi[''];
                                    echo "<li><b>$titre : </b>$desc</li>";
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                </table>
            </div>
        </div>
    </div>
</body>

</html>