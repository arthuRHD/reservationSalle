<?php
require '../includes/functions.php';
startSession();
needAuth();
if ($_COOKIE) {
    $Id = $_COOKIE['IdReservation'] ?? null;
    $Id = intval($Id);
    $prestas = getPresta($Id);
    $materiels = getMateriel($Id);
    $bdd = getDatabase();
    $query="SELECT disposition.Id, salle.Id, nomIntervenant, TypeReservation, title, salle.libelle, nbPers FROM reservation INNER JOIN salle on salle.Id=reservation.IdSalle INNER JOIN disposition ON disposition.Id=reservation.IdDisposition WHERE reservation.Id=$Id ;";   
    $req = $bdd->query($query);
    $infos = $req->fetchAll();
    $req->closeCursor();
}
if ($_POST) {
    $succes = false;    
    $allDay = $_POST['allDay'] ?? null;
    if ($allDay==null) {
        $allDay=0;
    }$repeat = $_POST['repeat'] ?? null;
    if ($repeat==null) {
        $repeat=0;
    }    
    $date = $_POST['date'] ?? null;
    $HdeDebut = $_POST['HdeDebut'] ?? null;
    $HdeFin = $_POST['HdeFin'] ?? null;
    if ($HdeFin != null && $date != null && $HdeDebut !=null) {
        $combinedD1 = date('Y-m-d H:i:s', strtotime("$date $HdeDebut"));
        $combinedD2 = date('Y-m-d H:i:s', strtotime("$date $HdeFin"));
    }    
    $service = $_POST['service'] ?? null;
    $Intervenant = $_POST['nomIntervenant'] ?? null;
    $disposition = $_POST['disposition'] ?? null;
    if ($disposition == "autre") {
        $autreText = $_POST['autreText'] ?? null;
        InsertDisposition($autreText);
        $IdDispo = getDispositionId($autreText);
    } else {
        $autreText = null;
        $IdDispo = getDispositionId($disposition);
    }
    $prestas = $_POST['presta'] ?? null;
    if (isset($_POST['materiel'])) {
        $materiel = $_POST['materiel'] ?? null;
    } else {
        $materiel = array();
    }
    foreach ($materiel as $outil) {
        if ($outil = "pc") {
            $nbOrdis = $_POST['nbordis'] ?? null;
            $internet = $_POST['internet'] ?? null;
        }
        if ($outil = "autreMateriels") {
            $textAutreMateriel = $_POST['textAutreMateriel'] ?? null;
        }
    }    
    $ecran = $_POST['ecran'] ?? null;
    if ($ecran == null || $ecran == "non") {
        $boolEcran = 0;
        $annonce = "pas de message";
    } else {
        $boolEcran = 1;
        $annonce = $_POST['annonce'] ?? null;
    }
    $Salle = $_POST['salle'] ?? null;
    $title = $_POST['title'] ?? null;
    $nbPers = $_POST['nbpers'] ?? null;
    if (isset($Intervenant)&&isset($Salle)&&isset($title)&&isset($nbPers)&&isset($disposition)) {
        modifierSalle($Id,$IdSalle);
        modifierDispo($Id,$IdDispo);
        modifierPresta();
        modifierReservation($Id,$title,$Intervenant,$nbPers);
        if ($req->execute()) {
            $succes = true;
        } 
    }
    header("Location: ../../index.php?modif=$succes");
}
?>
<!DOCTYPE html>
<!-- Créateur : Arthur RICHARD -->
<!-- Site : http://richardinfo.tk -->
<!-- Email : arthur.richard2299@gmail.com -->
<!-- LinkedIn : https://www.linkedin.com/in/arthur-richard-884645176/ -->
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/form.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Modification</title>
</head>
<body>
    <form action="./modification.php" method="post">
        <div class="card col-8 offset-2" style="padding-left: 0px;padding-right: 0px;margin-top: 75px;">
            <div class="card-header" style="text-align:center;">
                <h3>Modification de la réservation</h3>
            </div>
            <div class="card-body">
                <h5 class="card-title">Informations générales</h5>
                <div class="form-group">
                    <label for="intervenant">Nom de l'intervenant</label>
                    <input type="text" name="intervenant" class="form-control" value="<?php foreach ($infos as $value) { echo $value['nomIntervenant'];} ?>">
                </div> 
                <div class="form-group">
                    <label for="title">Intitulé de la réservation</label>
                    <input type="text" name="title" class="form-control" value="<?php foreach ($infos as $value) { echo $value['title'];} ?>">
                </div>
                <div class="form-group">
                    <label for="nbpers">Nombre de personnes présentes</label>
                    <input type="number" name="nbpers" class="form-control" value="<?php foreach ($infos as $value) { echo $value['nbPers'];} ?>">
                </div>
                <label for="disposition">Disposition de la salle</label>
                <select name="disposition" class="form-control">
                    <?php foreach (getDisposition() as $value) {
                        $lib = $value['Libelle'];
                        $IdDispo = $value['Id'];
                        foreach ($infos as $truc) {
                        if ($IdDispo==$truc['Id']) {
                            echo "<option Id='$IdSalle' selected>$lib</option>";
                        } else {
                        echo "<option Id='$IdSalle'>$lib</option>";
                        } }
                    }?>
                </select> <br>
                <label for="salle">Salle de réception</label>
                <select name="salle" class="form-control">
                    <?php foreach (getSalle() as $value) {
                        $lib = $value['libelle'];
                        $IdSalle = $value['Id'];
                        foreach ($infos as $truc) {
                        if ($IdSalle==$truc['Id']) {
                            echo "<option Id='$IdSalle' selected>$lib</option>";
                        } else {
                        echo "<option Id='$IdSalle'>$lib</option>";
                        } }
                    }?>
                </select> <br>
                <h5 class="card-title">Prestations</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="presta" id="rien" value="5" <?php foreach ($prestas as $value) { if($value['libelle']=='Rien'){ echo "checked";}}?>>
                    <label class="form-check-label" for="rien">Rien</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="presta" id="café" value="1" <?php foreach ($prestas as $value) { if($value['libelle']=='Café'){ echo "checked";}}?>>
                    <label class="form-check-label" for="café">Café</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="presta" id="eau" value="2" <?php foreach ($prestas as $value) { if($value['libelle']=='Thé'){ echo "checked";}}?>>
                    <label class="form-check-label" for="thé">Thé</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="presta" id="eau" value="3" <?php foreach ($prestas as $value) { if($value['libelle']=='Eau'){ echo "checked";}}?>>
                    <label class="form-check-label" for="eau">Eau</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="presta" id="eau" value="4" <?php foreach ($prestas as $value) { if($value['libelle']=='Buffet'){ echo "checked";}}?>>
                    <label class="form-check-label" for="Buffet">Buffet</label>
                </div>
                <button type="submit" style="float:right;" class="btn btn-success">Modifer</button>
            </div>
        </div>
    </form>
</body>
</html>