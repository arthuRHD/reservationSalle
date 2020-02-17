<?php
require "../includes/functions.php";
startSession();
needAuth();
$mail = "thomas.cramoisan.relations.publiques@mairie-sotteville-les-rouen.fr";
if (isset($_POST)) {
    $allDay = $_POST['allDay'] ?? null;
    if ($allDay==null) {
        $allDay=0;
    }$repeat = $_POST['repeat'] ?? null;
    if ($repeat==null) {
        $repeat=0;
    }
    $service = $_POST['service'] ?? null;
    $demandeur = $_SESSION['user'];
    $intervenant = $_POST['intervenant'] ?? null;
    $typeReservation = $_POST['typeReservation'] ?? null;
    $nbPers = $_POST['nbPers'] ?? null;
    $intitule = $_POST['intitule'] ?? null;
    $date = $_POST['date'] ?? null;
    $HdeDebut = $_POST['HdeDebut'] ?? null;
    $HdeFin = $_POST['HdeFin'] ?? null;
    $salle = $_POST['salle'] ?? null;
    $typeParticipant = $_POST['typeParticipant'] ?? null;
    $prestas = $_POST['presta'] ?? null;
    if (isset($_POST['materiel'])) {
        $materiel = $_POST['materiel'] ?? null;
        foreach ($materiel as $outil) {
            if ($outil = "pc") {
                $nbOrdis = $_POST['nbordis'] ?? null;
                $internet = $_POST['internet'] ?? null;
            } else {
                $nbOrdis = null;
                $internet = null;
            }
            if ($outil = "autreMateriels") {
                $textAutreMateriel = $_POST['textAutreMateriel'] ?? null;
                if (isset($textAutreMateriel)) {
                    createMateriel($textAutreMateriel);
                    $IdMateriel = getIdMateriel($textAutreMateriel);
                    array_push($materiel,$IdMateriel);
                }            
            } else {
                $textAutreMateriel = null;
            }
            
        }
    } else {
        $materiel = array();
    }
    
    $ecran = $_POST['ecran'] ?? null;
    if ($ecran == null || $ecran == "non") {
        $boolEcran = 0;
        $annonce = "pas de message";
    } else {
        $boolEcran = 1;
        $annonce = $_POST['annonce'] ?? null;
    }

    $disposition = $_POST['disposition'] ?? null;
    if ($disposition == "autre") {
        $autreText = $_POST['autreText'] ?? null;
        InsertDisposition($autreText);
        $IdDispo = getDispositionId($autreText);
    } else {
        $autreText = null;
        $IdDispo = getDispositionId($disposition);
    }
    if (isset($disposition)) {
        $combinedD1 = date('Y-m-d H:i:s', strtotime("$date $HdeDebut"));
        $combinedD2 = date('Y-m-d H:i:s', strtotime("$date $HdeFin"));
        InsertDemandeur($demandeur, $service);
        $IdDemandeur = getDemandeurId($demandeur, $service);
        Reservation($intervenant, $typeReservation, $combinedD1, $combinedD2, $intitule, $typeParticipant, $nbPers, $boolEcran, $annonce, $salle, $IdDemandeur, $IdDispo, $allDay, $repeat);
        if (isset($materiel)) {
            if (isset($nbOrdis)&&isset($internet)) {
                InsertMateriel(getReservationId($combinedD1, $intitule), $materiel, $nbOrdis, $internet);
            }
            else {
                InsertMateriel(getReservationId($combinedD1, $intitule), $materiel, NULL, NULL);
            }
        }
        if (isset($prestas)) {
            InsertPresta(getReservationId($combinedD1, $intitule), $prestas);
        }
        $status = "done";
    } else {
        $status = "failed";
    }
}
?>
<!DOCTYPE html>
<!-- Créateur : Arthur RICHARD -->
<!-- Site : http://richardinfo.tk -->
<!-- Email : arthur.richard2299@gmail.com -->
<!-- LinkedIn : https://www.linkedin.com/in/arthur-richard-884645176/ -->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Réservation</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/functions.js"></script>
    <?php if ($status == "done") {
        echo "<script>alert('Formulaire envoyé ! Veuillez attendre la validation des relations publiques');</script>";
    }
    ?>
</head>

<nav class="menu">
    <div class="left">

    <?php if (isset($_SESSION['user']) && giveRightsAccueil($_SESSION['user'])) {
      echo "<a class='btn btn-dark' href='./validation.php'>Valider les réservations</a>";
    } ?>
    <?php if (isset($_SESSION['user']) && giveRightsRP($_SESSION['user'])) {
      echo "<a class='btn btn-dark' href='./validationPresta.php'>Valider les prestations</a>";
    } ?>
        <a class="btn btn-dark" href="../index.php">Retour au calendrier</a>
        <a class="btn btn-primary" href="./Guide.pdf" target="_blank">Doc</a>
    </div>
    <div class="btn-group">
        <?php if (isAuth()) {
            echo "<a class='btn btn-secondary' href='#'>Bonjour $demandeur</a>";
            echo "<a class='btn btn-danger' href='../includes/logout.php'>Déconnexion</a>";
        } ?>
    </div>
</nav>

<body>
    <div class="container-fluid">
        <div class="mx-auto mt-3 col-10">
            <header class="card module">
                <div class="card-header">
                    <h1>FICHE DE RÉSERVATION - Salles de l'Hôtel de ville</h1>
                    <h3>(Réservée aux services Municipaux)</h3>
                </div>
                <div class="card-body w3-white">
                    En cas d'annulation, n'oubliez pas de prévenir l'accueil. <br>
                    <u>Merci de faire une réservation de salle par date</u><br>
                </div>
            </header>
            <div class="card reservation">
                <form action="reservation.php" method="POST">
                    <div class="card-header w3-grey 1"><b>Intervenant</b></div>
                    <div class="card-body">
                        Demandeur : <input type="text" name="intervenant" id="textIntervenant" required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Personne remplissant le formulaire : <input type="text" name="demandeur" id="textDemandeur" required><br>
                        <input type="radio" name="typeReservation" value="reunion" id="radioReunion" required> Réunion &nbsp;&nbsp;&nbsp;
                        <input type="radio" name="typeReservation" value="formation" id="radioFormation" required> Formation <br>
                        Nombre de personnes : <input class="col-2" type="number" name="nbPers" id="nbpers" required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Service :
                        <select type="text" name="service" id="textService" required>
                            <option value="" selected>Vide</option>
                            <?php foreach (getService() as $res) {
                                $value = $res['Id'];
                                $content = $res['libelleService'];
                                echo "<option value='$value'>$content</option>";
                            } ?>
                        </select><br>
                        Intitulé : <input class="col-12" type="text" name="intitule" id="intitule" required><br>
                        Date : <input type="date" name="date" id="date" required>
                        Heure de début : <input type="time" name="HdeDebut" id="heureDebut" required>
                        Heure de fin : <input type="time" name="HdeFin" id="heureFin" required> 
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="allDay" value="1" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                        Toute la journée 
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="repeat" value="1" id="defaultCheck2">
                        <label class="form-check-label" for="defaultCheck2">
                        Rêpeter l'évenement 
                        </label>
                        </div>
                    </div>
                    <div class="card-header w3-grey 2" id="CHsalle" hidden><b>Salle souhaitée</b></div>
                    <div class="card-body" id="CBsalle" hidden>
                        <?php
                        $bdd = getDatabase();
                        $query = "SELECT * FROM salle";
                        $req = $bdd->query($query);
                        $res = $req->fetchAll();
                        foreach ($res as $ligne) {
                            $value = $ligne['Id'];
                            $contenu = $ligne['libelle'];
                            echo "<input type='radio' name='salle' value='$value' id='$value' required> $contenu <br>";
                        }
                        $req->closeCursor();
                        ?>
                    </div>
                    <div class="card-header w3-grey 3" id="CHparticipant" hidden><b>Participants</b></div>
                    <div class="card-body" id="CBparticipant" hidden>
                        <input type="radio" name="typeParticipant" onclick="EnableCheckPresta()" id="elu" value="Élus" required> Élus&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="typeParticipant" onclick="EnableCheckPresta()" id="perso" value="Personnels" required> Personnel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="typeParticipant" onclick="EnableCheckPresta()" id="ext" value="Exterieurs" required> Extérieurs <br>
                        Souhaitez-vous que cette réunion soit annoncée sur l'écran d'informations d'acceuil ? <br>
                        <input class="offset-3" onclick="InputAnnonce()" type="radio" name="ecran" id="ouiEcran" value="oui" required> Oui
                        <input class="offset-3" onclick="InputAnnonce()" type="radio" name="ecran" id="nonEcran" value="non" required> Non <br> <br>
                        Si oui, merci de rédiger cette annonce de la façon la plus synthétique possible :
                        <input class='col-12' type='text' name='annonce' id='inputAnnonce' disabled>
                    </div>
                    <div class="card-header w3-grey 4" id="CHlogistique" hidden><b>Demandes logistique</b></div>
                    <div class="card-body" id="CBlogistique" hidden>
                        <h4>Disposition de la salle<span>*</span> :</h4>
                        <input type="radio" name="disposition" onclick="EnableTextAutreDisposition()" id="conference" value="Conference" required><label> Conférence</label>
                        <input type="radio" name="disposition" onclick="EnableTextAutreDisposition()" id="carre" value="Carré" required><label> Carré</label>
                        <input type="radio" name="disposition" onclick="EnableTextAutreDisposition()" id="ronde" value="Tables rondes" required><label> Tables rondes</label>
                        <input type="radio" name="disposition" onclick="EnableTextAutreDisposition()" id="buffetDispo" value="Buffet + quelques chaises" required> Buffet + quelques chaises <br>
                        <input type="radio" name="disposition" onclick="EnableTextAutreDisposition()" id="autre" value="autre" required> Autre disposition (Précisez) : <input type="text" id="autreText" name="autreText" required disabled>
                        <h4>Matériel souhaité : </h4>
                        <ul>
                            <li><input type="checkbox" name="materiel[]" value="1"> Paperboard + stylo</li>
                            <li><input type="checkbox" name="materiel[]" onclick="detailsMateriels()" id="pc" value="2"> Ordinateur</li>
                            <label>Nombre d'ordinateurs necéssaires : </label><input class="col-3" type="number" name="nbordis" id="nbordis" placeholder="(Maximum 10)" required disabled> <br>
                            <label>Usage d'internet : </label><input type="radio" name="internet" id="ouiInternet" value="oui" disabled> Oui <input type="radio" name="internet" id="nonInternet" value="non" required disabled> Non <br> <br>
                            <li><input type="checkbox" name="materiel[]" value="3"> Vidéoprojecteur + écran</li>
                            <li><input type="checkbox" name="materiel[]" value="4"> Sono</li>
                            <li><input type="checkbox" name="materiel[]" value="5"> TV</li>
                            <?php 
                            if (giveRightsDisposition($_SESSION['user'])) {
                            ?>
                            <li><input type="checkbox" name="materiel[]" onclick="nouveauMateriel()" id='autreMateriel'> <input type="text" id="textAutreMateriel" name="textAutreMateriel" placeholder="Nouveau matériel" required disabled></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="card-header w3-grey 5" id="CHpresta" hidden><b>Autres prestations (pour participants extérieurs)</b></div>
                    <div class="card-body" id="CBpresta" hidden>
                        <ul>
                            <li><input type="checkbox" name="presta[]" onclick="HideOthers()" id="rien" value="5"> Rien</li>
                            <li><input type="checkbox" name="presta[]" onclick="HideOthers()" id="cafe" value="1" disabled> Café</li>
                            <li><input type="checkbox" name="presta[]" onclick="HideOthers()" id="tea" value="2" disabled> Thé</li>
                            <li><input type="checkbox" name="presta[]" onclick="HideOthers()" id="eau" value="3" disabled> Eau</li>
                            <li><input type="checkbox" name="presta[]" onclick="HideOthers()" id="buffetPresta" value="4" disabled> Buffet (si manifestations)</li>
                        </ul>
                        <div class="inner-mail">
                            <a href="mailto:<?php echo $mail ?>">Si autre demande, le faire par mail auprès du service Relations Publiques.</a>
                        </div>
                        <div class="inner-btn">
                        </div>
                    </div>
                    <div class="inner-btn">
                        <a href="#bas"><input class="btn btn-secondary" onclick="Affiche()" id="btnForm" type="button" value='Continuer'></a>
                        <input class="btn btn-warning" onclick="Confirm()" type="reset" value="Réinitialiser">
                    </div>
            </div>
            </form>
        </div>
    </div>
</body>
<footer id="bas"></footer>
<script src="../js/functions.js"></script>
<?php
?>
<?php require "../includes/errors.php"; ?>

</html>