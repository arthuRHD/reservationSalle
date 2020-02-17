<?
require('../tools/jsonparser.php');

class Session extends JsonParser
{
    static $rights;
    function __construct()
    {
        $user = $this->getUser();
        $rights = JsonParser::$json_admin;
    }
    function getUser() {
        return $SESSION['user'] ?? null;
    }
    static function startSession() {
        if (session_status() == PHP_SESSION_NONE) { 
            session_start();
        }
    }
    static function Logout(){
        session_start();
        session_destroy();
        header("Location: ../pages/login.php");
        die();
    }
    function isAuth()
    {
        return isset($this->$user);
    }
    function needAuth()
    {
        if (!isAuth()) {
            $_SESSION['error_bypass'] = "Vous devez être connecté pour accéder à cette page !";
            header('Location: ../../pages/login.php'); 
            die();
        }
    }
    function getRights($session)
    {
        foreach (Session::$rights as $key => $value) {
            if ($value == $session) {
                return $key;
            } else {
                return 403;
            }
        }
    }
    function handleError() {
        $sessionType = array(
            'error_bypass' => "Vous devez être connecté pour accéder à cette page !",
            'error_login' => "Mot de passe ET/OU Identifiant incorrect(s) !",
        );
        foreach ($sessionType as $key => $value) {
            if (isset($_SESSION[$key])) {
                echo "<script>".alert($value)."</script>";
                session_destroy();
            }
        }
    }
}
