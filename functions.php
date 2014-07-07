<?php

/**
 * Connecte un utilisateur
 *
 * @return boolean
 */
function connect($login ,$pwd){

/* Permet de recuperer les donnees de connexion a la base de donnee */
    include("config.php");
    $pwd = pg_escape_string($pwd);
    $hash_pwd= sha1("imosoweb") . $login . sha1($pwd);
    $login = pg_escape_string($login);
 	$db  = pg_connect("$conf"); 
    if ($db==false){
        return false;
    }
	$res = pg_query($db,"SELECT * FROM Utilisateur WHERE login='$login' AND mdp = '$hash_pwd';");
    $tab = pg_fetch_row($res);
    if ($tab==false){
        return false; 
    }
    if ($res !== false && pg_num_rows($res) === 1){
        $_SESSION['login'] = $_POST['login'];
    }
    else{
        print("Mauvais identifiants");
        return false; 
    }
    if ($tab[3]==0){
        $_SESSION['admin']=1;
    }
    return true;
}

function disconnect(){
    if(isset($_GET['logout'])){
        session_destroy();
        header ("Location: index.php");
    }
}

function is_admin() {
    return isset($_SESSION['admin']);
}

/**
 * Vérifie si l'utilisateur est connecté
 *
 * @return boolean
 */
function isConnected() {
    return isset($_SESSION['login']);
}

/**
 * Affiche l'entête
 * 
 * @param string $title titre
 */
function displayHeader($title) {
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="./css/style.css"/> 
    </head>
    <body>
    <h1><?php echo $title; ?></h1>
    <?php 
    if(isConnected()){
    ?>
    <h5>
         <a href="<?php $_SERVER['PHP_SELF'];?>?logout=1">Se déconnecter</a>
    </h5>
    <?php
    }
    if (isConnected()){
        if(isset($_GET['logout'])){
            session_destroy();
            header ("Location: index.php");
        }
    }
}

function menuAdmin(){
?>
    <ul id="navig_gestion">
    <li><a href="deviss.php"> Créer un devis </a></li>
    <li><a href="consult_devis.php"> Consulter un devis </a></li>
    <li><a href="modif_devis.php"> Modifier un devis </a></li>
    <li><a href="facture.php"> Créer une facture </a></li>
    <li><a href="consult_facture.php"> Consulter une facture </a></li>
    <li><a href="modif_facture.php"> Modifier une facture </a></li>
    <li><a href="modif_client.php"> Gestion des comptes clients </a></li>
    </ul>
<?php
}
/**
 * Affiche le pied de page
 * 
 *
 */

function chaine_aleatoire($nb_car, $chaine = 'azertyuiopqsdfghjklmwxcvbn123456789')
{
    $nb_lettres = strlen($chaine) - 1;
    $generation = '';
    for($i=0; $i < $nb_car; $i++)
    {
        $pos = mt_rand(0, $nb_lettres);
        $car = $chaine[$pos];
        $generation .= $car;
    }
    return $generation;
}

function displayFooter() {
    echo "</body></html>";
}

?>
