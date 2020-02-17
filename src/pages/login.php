<?php
require "../includes/functions.php";
startSession();
if (isAuth()) {
    header('Location: ./reservation.php');
    die();
}
if (isset($_POST)) {
    $pseudo = $_POST['user'] ?? null;
    $password = $_POST['passwd'] ?? null;
    if (isset($pseudo) && isset($password)) {
        LoginLDAP($pseudo, $password);
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
    <title>Connexion</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<nav class="menu">
    <a class="btn btn-dark" href="../index.php">Retour au calendrier</a>
    <a class="btn btn-primary" href="./Guide.pdf" target="_blank">Doc</a>
</nav>

<body>
    <div class="container-fluid">
        <div class="inner">
            <form action="login.php" method="post">
                <div class="card col-3 offset-9" style="margin-top: 20px;">
                    <img class="card-img-top" src='../images/logo_mairie.jpg' alt="Card image cap">
                    <div class="card-body">
                        <small class="form-text text-muted">Gestion des réservations de salle</small> <br>
                        <div class="form-group">
                            <div class="btn-group">
                                <button class="btn btn-secondary" disabled><svg x="0px" y="0px" width="12px" height="13px">
                                        <path fill="#B1B7C4" d="M8.9,7.2C9,6.9,9,6.7,9,6.5v-4C9,1.1,7.9,0,6.5,0h-1C4.1,0,3,1.1,3,2.5v4c0,0.2,0,0.4,0.1,0.7 C1.3,7.8,0,9.5,0,11.5V13h12v-1.5C12,9.5,10.7,7.8,8.9,7.2z M4,2.5C4,1.7,4.7,1,5.5,1h1C7.3,1,8,1.7,8,2.5v4c0,0.2,0,0.4-0.1,0.6 l0.1,0L7.9,7.3C7.6,7.8,7.1,8.2,6.5,8.2h-1c-0.6,0-1.1-0.4-1.4-0.9L4.1,7.1l0.1,0C4,6.9,4,6.7,4,6.5V2.5z M11,12H1v-0.5 c0-1.6,1-2.9,2.4-3.4c0.5,0.7,1.2,1.1,2.1,1.1h1c0.8,0,1.6-0.4,2.1-1.1C10,8.5,11,9.9,11,11.5V12z" />
                                    </svg></button>
                                <input type="text" class="form-control" name="user" id="usr" aria-describedby="emailHelp" placeholder="Identifiant">
                            </div>


                        </div>
                        <div class="form-group">
                            <div class='btn-group'>
                                <button class="btn btn-secondary" disabled><svg x="0px" y="0px" width="15px" height="5px">
                                        <g>
                                            <path fill="#B1B7C4" d="M6,2L6,2c0-1.1-1-2-2.1-2H2.1C1,0,0,0.9,0,2.1v0.8C0,4.1,1,5,2.1,5h1.7C5,5,6,4.1,6,2.9V3h5v1h1V3h1v2h1V3h1 V2H6z M5.1,2.9c0,0.7-0.6,1.2-1.3,1.2H2.1c-0.7,0-1.3-0.6-1.3-1.2V2.1c0-0.7,0.6-1.2,1.3-1.2h1.7c0.7,0,1.3,0.6,1.3,1.2V2.9z" />
                                        </g>
                                    </svg></button>
                                <input type="password" class="form-control" id="pwd" name="passwd" placeholder="Mot de passe">
                            </div>


                        </div>
                        <button type="submit" class="btn btn-success">Se connecter</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
    </div>
</body>
<footer>
</footer>
<?php require "../includes/errors.php"; ?>

</html>