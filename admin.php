<?php

session_start();
include("functions.php");
include("config.php");

displayHeader("Menu Administrateur");

if ((isset($_SESSION['login']))&&(isset($_SESSION['admin']))){
 	menuAdmin();
 	$db=pg_connect("$conf");
 	$req=pg_query($db,"SELECT nom, id_client, id_facture
 					   FROM Facture JOIN Client ON (id_client_facture=id_client) 
 					   WHERE etat=0;");
	?>
 	<p> ADMINISTRATEUR </p>
	<?php
	if (isset($_POST['regulariser'])){
		$reg=$_POST['regulariser'];
		$req=pg_query($db,"UPDATE Facture 
						   SET etat=1
						   WHERE id_facture=$reg;");
	}
	else{
	print("<h1> ALERTES : </h1>");
	while($tab=pg_fetch_row($req)){
 		print("<p> <b> $tab[0] </b> </p>"); 
 		$req2=pg_query($db,"SELECT id_facture 
 						FROM Facture 
 						WHERE etat=0 AND id_client_facture=$tab[1];");
 		while($tab2=pg_fetch_row($req2)){
 			?>
 			<p>
 			<form action="admin.php" method="post"> 
        	<?php
 			print("<b> Facture n° $tab[1] </b>"); 
 			print("<input type=\"hidden\" name=\"aperçu\" value=\"$tab[1]\" />");
 			?>
 		    <input type="submit" value="Aperçu" />
 			<?php 
 			print("<input type=\"hidden\" name=\"regulariser\" value=\"$tab[2]\" />");
 			?>
 			<input type="submit" value="Régulariser"/>
 			</form>
 			<?php
 		}
 	}
 }
}
else if (!isset($_SESSION['login'])){
	header('Location: index.php');
}
else{
	header('Location: client.php');
}
displayFooter();
?>
