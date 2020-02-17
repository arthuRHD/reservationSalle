<?php
require '../includes/functions.php';
startSession();
needAuth();
if ($_POST) {
    $tableauOui = array();
    $tableauNon = array();
    foreach (event() as $value) {
        if ($value['validationPresta']==0) {
            $Id = $value['Id'];
            if ($_POST[$Id] == "oui") {
                array_push($tableauOui,$Id);
            } elseif ($_POST[$Id] == "non") {
                array_push($tableauNon,$Id);
            }
        }            
    } 
    refusPresta($tableauNon);
    acceptationPresta($tableauOui);
    unset($tableauNon);
    unset($tableauOui); 
}
?>
<!DOCTYPE html>
<!-- Créateur : Arthur RICHARD -->
<!-- Site : http://richardinfo.tk -->
<!-- Email : arthur.richard2299@gmail.com -->
<!-- LinkedIn : https://www.linkedin.com/in/arthur-richard-884645176/ -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Validation des prestations</title>
    <link rel="stylesheet" href="../css/main.css">
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
    <form action="./validationPresta.php" method="post">
        <div class="card col-8 offset-2" style="padding-left: 0px;padding-right: 0px;margin-top: 75px;">
            <div class="card-header"><h4>Validation des prestations</h4></div>
            <div class="card-body">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col-8">Réservations</th>
                        <th scope="col-3">Prestations</th>
                        <th scope="col">Validation</th>
                        <th scope="col">Refus</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $j = false;
                    foreach (event() as $infos) {
                        $resPresta = getPresta($infos['Id']);
                        $IdReservation = $infos['Id'];
                        $title = $infos['title'];
                        $salle = $infos['libelle'];
                        $start = $infos['start'];
                        $end = $infos['end'];
                        $nbpers = $infos['nbPers'];
                        $demandeur = $infos['nomDemandeur'];                        
                        if ($infos['validationPresta'] == 0) { $j = true;
                            ?>
                            <tr>
                                <td class="col-2"><label id='<?php echo $title; ?>'><?php echo $title; echo " / "; echo $salle; echo " / "; echo $nbpers;echo " personnes / ";echo $start;echo " / "; echo $end;?></label></td>
                                <td class="col-2"><?php foreach ($resPresta as $infos) {
                                    $value= $infos['libelle'];
                                    echo "<li>$value</li>";
                                }?></td>
                                <td class="col-2"><input type="radio" name="<?php echo $IdReservation ?>" value="oui" required></td>
                                <td class="col-2"><input type="radio" name="<?php echo $IdReservation ?>" value="non" required></td>
                            </tr>
                        <?php } } ?>

                </table>
                <?php if ($j==false) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Pas de réservations !</strong> Vous avez déjà tout vérifié</div>
                <?php } ?>
                    </tbody>
                    </table>
            </div>
            <input class="btn btn-success col-4 offset-4" type="submit" value="Valider">
        </div>
        
    </form>
</body>
<footer>
</footer>
</html>