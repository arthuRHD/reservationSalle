<?php
require('../tools/jsonparser.php');

class ActiveDirectory extends JsonParser {

    static $ad;
    static $base_dn;
    
    function __construct() {
        $base_dn = self::$json_ldap['base_dn'];
        $port = self::$json_ldap['port'];
        $host = self::$json_ldap['host'];
        $ad = ActiveDirectory::getLDAP($host, $port);
    }
    public static function getLDAP($ldaphost, $ldapport)
    {
        try { 
            $ad = ldap_connect($ldaphost, $ldapport);
            ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
            return $ad;
        } catch (Exception $e) {
            $error_msg = 'Erreur LDAP : ' . $e;
            require RACINE . 'public/page.phtml';
            die($error_msg);
        }
    }
    public static function searchUser($directory, $user) {
        $flag = false;
        $query = ldap_search($directory, $base_dn, "uid=".$user);
        if (ldap_count_entries($directory, $query)) {
            $flag = True;
        } else {
            $flag = false;
        }
        return $flag;
    }
    public static function authenticate($user, $pass) {
        $directory = ActiveDirectory::$ad;
        $anon_connec = ldap_bind($directory);
        if (ActiveDirectory::searchUser($directory, $user)) {
            $ldap_dn = "uid=".$user.";".ActiveDirectory::$base_dn;
            if(ldap_bind($directory, $ldap_dn, $pass)) {
                startSession();
                session_id($user);
                $_SESSION['user'] = $user;
                header("Location: ../index.php");
            } else {
                $_SESSION['error_login'] = $res;
                header("Location: ../pages/login.php");
            }
            ldap_close($directory);
            die();
        }
    }
}