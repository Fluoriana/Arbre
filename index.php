<?php

session_start();
include("functions.php");

displayHeader("IMOSOWEB");

if(!isConnected()){
?>
<form action="index.php" method="post">
	<p>Login : <input type="text" name="login" />
	<p>Mot de passe : <input type="password" name="pwd" />	
    <input type="submit" value="Valider" />
</form>	
<?php
}
else{
	if(is_admin()===true){
            header('Location: admin.php'); 
        }
    else{
            header('Location: client.php'); 
        }
} 

if(isset($_POST['login'])){
    $log=$_POST['login'];
    $pwd=$_POST['pwd']; 

    if (connect($log, $pwd) === true){ 
    	if(is_admin()===true){
			header('Location: admin.php'); 
    	}
    	else{
            header('Location: client.php'); 
        }
    }
    else{
    	print("Identifiants invalides");
    }
}

displayFooter();
?>