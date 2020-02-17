<?php
require "../includes/functions.php";
startSession();
needAuth();
if ($_POST) {
    $tableauOui = array();
    $tableauNon = array();
    foreach (event() as $value) {
        if ($value['validation']==0) {
            $Id = $value['Id'];
            if ($_POST[$Id] == "oui") {
                array_push($tableauOui,$Id);
            } elseif ($_POST[$Id] == "non") {
                array_push($tableauNon,$Id);
            }
        }            
    }  
    refus($tableauNon);
    acceptation($tableauOui);
    unset($tableauNon);
    unset($tableauOui);
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
    <meta http-equiv="refresh" content="600;./validation.php">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Validation</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<nav class="menu">
    <div class="left">
        <a class="btn btn-dark" href="../index.php">Retour au calendrier</a>
        <a class="btn btn-dark" href="./reservation.php">Réserver une salle</a>
    </div>
    <div class="btn-group">
        <?php
        if (isAuth()) {
            $pseudo = $_SESSION['user'];
            echo "<a class='btn btn-secondary' href='#'>Bonjour $pseudo !</a>";
            echo "<a class='btn btn-danger' href='../includes/logout.php'>Déconnexion</a>";
        }
        ?>
    </div>
</nav>

<body>
    <div class="container-fluid">
        <div class="col-8 offset-2">
            <header class="card module">
                <h1>Validation des réservations</h1>
            </header>
            <div class="card">
                <div class="card-header w3-grey">Liste des réservations à modérer</div>
                <div class="card-body w3-white">
                    <form action="./validation.php" method="POST">
                        <table>
                            <tr>
                                <th class="col-2">Réservations</th>
                                <th class="col-2">Demandeur</th>
                                <th class="col-2">Salle</th>
                                <th class="col-2">Je valide</th>
                                <th class="col-2">Je refuse</th>
                            </tr>
                            <?php
                            $j = false;
                            foreach (event() as $infos) {
                                $IdReservation = $infos['Id'];
                                $title = $infos['title'];
                                $salle = $infos['libelle'];
                                $demandeur = $infos['nomDemandeur'];
                                
                                if ($infos['validation'] == 0) { $j = true;
                                    ?>
                                    <tr>
                                        <td class="col-2">
                                            <ul>
                                                <li>[<?php echo $infos['typeReservation']; ?>] <?php echo $title; ?></li>
                                                <li><?php echo $infos['start']; ?> à <?php echo $infos['end']; ?></li>
                                                <li>Participants : <?php echo $infos['typeParticipants']; ?></li>
                                                <li><?php echo $infos['nbPers']; ?> personnes</li>
                                                <li>Intervenant : <?php echo $infos['nomIntervenant']; ?></li>
                                            </ul>
                                        </td>
                                        <td class="col-2"><?php echo $demandeur; ?></td>
                                        <td class="col-2"><?php echo $salle; ?></td>
                                        <td class="col-2"><input type="radio" name="<?php echo $IdReservation ?>" value="oui" required></td>
                                        <td class="col-2"><input type="radio" name="<?php echo $IdReservation ?>" value="non" required></td>
                                    </tr>
                                <?php }
                        } ?>

                        </table>
                        <?php if ($j==false) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Pas de réservations !</strong> Vous avez déjà tout vérifié</div>
                        <?php } ?>
                        <div class="inner-btn">
                            <input class="btn btn-success" type="submit" value="Valider les reservations">
                            <input class="btn btn-warning" type="reset" value="Recommencer">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>