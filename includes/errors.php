<?php
if (isset($_SESSION['error_bypass'])) {
    ?>
    <script>
        alert("Vous devez être connecté pour accéder à cette page !");
    </script>
    <?php
    session_destroy();
}
if (isset($_SESSION['error_login'])) {
    ?>
    <script>
        alert("Mot de passe ET/OU Identifiant incorrect(s) !");
    </script>
    <?php
    session_destroy();
}
?>