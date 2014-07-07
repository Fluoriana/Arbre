<?php
ini_set('display_errors', 1);
session_start();

include("functions.php");
include("form_functions.php");
include("config.php");

displayHeader("Modification d'un devis");

if (isset($_SESSION['admin'])){

	$db = pg_connect("$conf");



	if (!isset($_POST['soumission1'])){
		$res = pg_query($db,"SELECT id_devis, nom, adresse_bien
                     FROM Devis JOIN Client ON (id_client=id_client_devis) 
                     JOIN Bien ON (id_bien=id_bien_devis)
                     ORDER BY nom;");
		?>
		<form action="modif_devis.php" method="post">
    		<p>Sélectionnez un devis à modifier</p>
            <select name="choix">
            	<?php
            	while($tab=pg_fetch_row($res)){
            	print("<option value=\"$tab[0]\">
                	Client $tab[1] Bien à l'adresse $tab[2] Devis n° $tab[0]
            		</option>");
            	}
            ?>
        	</select>
        	<input type="hidden" name="soumission1" />
        	<input type="submit" value="Valider" />
    	</form>
    	<?php
	}
	else{
		$id_devis=$_POST['choix'];
		$req=pg_query($db, "SELECT id_bien_devis, id_client_devis FROM Devis WHERE id_devis=$id_devis;");
		$tab=pg_fetch_row($req);
		$id_bien=$tab[0];
		$id_client=$tab[1];

		$res1=pg_query($db,"SELECT * FROM Client WHERE id_client=$id_client;");
		$res2=pg_query($db,"SELECT * FROM Bien WHERE id_bien=$id_bien;");
		$res3=pg_query($db,"SELECT * FROM Devis WHERE id_devis=$id_devis;");

		$tab1=pg_fetch_row($res1);
		$tab2=pg_fetch_row($res2);
		$tab3=pg_fetch_row($res3);

		if (!isset($_POST['soumission2'])){
			print("<form action=\"modif_devis.php\" method=\"post\">");
			print("<p>Nom / Nom de Société : <input type=\"hidden\" name=\"nom\" value=\"$tab1[1]\"/> $tab1[1]</p>");
			if ($tab1[2]!=NULL){
					   print("<p>Prénom : <input type=\"hidden\" name=\"prenom\" value=\"$tab1[2]\" /> $tab1[2] </p>
					  		  <p>Civilite : <input type=\"hidden\" name=\"civilite\" value=\"$tab1[3]\" /> $tab1[3] </p>");
				}
		   	print("<p>Adresse du client : <input type=\"hidden\" name=\"adresse_client\" value=\"$tab1[4]\"/> $tab1[4]</p>
	       		<p>CODE POSTAL : <input type=\"hidden\" name=\"cp_client\" value=\"$tab1[5]\"/> $tab1[5]</p>
		   		<p>Ville : <input type=\"hidden\" name=\"ville_client\" value=\"$tab1[6]\"/> $tab1[6]</p>
	 	   		<p>Adresse électronique : <input type=\"hidden\" name=\"mail\" value=\"$tab1[7]\"/> $tab1[7]</p>
	   	   		<p>Statut : <input type=\"hidden\" name=\"statut\" value=\"$tab1[8]\"/> $tab1[8]</p>
	       		<p>Adresse du bien : <input type=\"text\" name=\"adresse_bien\" value=\"$tab2[1]\" /> </p>
	       		<p>CODE POSTAL du bien : <input type=\"text\" name=\"cp_bien\" value=\"$tab2[2]\"/></p>
	       		<p>Ville du bien : <input type=\"text\" name=\"ville_bien\" value=\"$tab2[3]\"/></p>
	       		<p>Surface : <input type=\"text\" name=\"surface\" value=\"$tab2[4]\"/></p>
	       		<p>Surface du terrain : <input type=\"text\" name=\"surface_terrain\" value=\"$tab2[5]\"/></p>
	       		<p>Type de bien : <input type=\"text\" name=\"type_bien\" value=\"$tab2[6]\"/></p>
	       		<p>Nombre de pièces : <input type=\"text\" name=\"nb_pieces\" value=\"$tab2[7]\"/></p>
	       		<p>Prix / mètre carré : <input type=\"text\" name=\"prix_carre\" value=\"$tab3[6]\"/></p>
	       		<p>TVA : <input type=\"text\" name=\"tva\" value=\"$tab3[4]\"/></p>
	       		<p>Rabais / Remise / Ristourne : <input type=\"text\" name=\"rabais\" value=\"$tab3[7]\"/></p>");
				?>
				<p>Type de devis (ELE/ELS): <select name="type_devis">
									   			<option value=1>ELE</option>
								   				<option value=2>ELS</option>
							   				</select></p>
				<?php
				print("<input type=\"hidden\" name=\"soumission1\" />");
				print("<input type=\"hidden\" name=\"soumission2\" />");
				print("<input type=\"hidden\" name=\"choix\" value=\"$id_devis\" />");
				print("<p> <input type=\"submit\" value=\"Modifier le Devis\" /> </p>");
				print("</form>");
			}
		else{
			if (is_ok_form_modif()){
	
				$adresse_bien=$_POST['adresse_bien'];
				$cp_bien=$_POST['cp_bien'];
				$ville_bien=$_POST['ville_bien'];
				$surface=$_POST['surface'];
				$surface_terrain=$_POST['surface_terrain'];
				$type_bien=$_POST['type_bien'];
				$nb_pieces=$_POST['nb_pieces'];
				$prix_carre=$_POST['prix_carre'];
				$tva=$_POST['tva'];
				$rabais=$_POST['rabais'];
				$type_devis=$_POST['type_devis'];

				pg_query($db,"UPDATE Bien SET adresse_bien='$adresse_bien', cp_bien=$cp_bien, ville_bien='$ville_bien',
			                         surface=$surface, surface_terrain=$surface_terrain, type_bien=$type_bien, nb_pieces=$nb_pieces
			    	                 WHERE id_bien=$id_bien;");

				pg_query($db,"UPDATE Devis SET prix_carre_devis=$prix_carre, tva=$tva, rabais_devis=$rabais, type_devis=$type_devis
				 					 WHERE id_devis=$id_devis;");
			}
			else{
				print("<form action=\"modif_devis.php\" method=\"post\">");
				print("<p>Nom / Nom de Société : <input type=\"hidden\" name=\"nom\" value=\"$tab1[1]\"/> $tab1[1]</p>");
					if ($tab1[2]!=NULL){
					   print("<p>Prénom : <input type=\"hidden\" name=\"prenom\" value=\"$tab1[2]\" /> $tab1[2] </p>
					  		  <p>Civilite : <input type\"hidden\" name=\"civilite\" value=\"$tab1[3]\" /> $tab1[3] </p>");
					}
	   			print("<p>Adresse du client : <input type=\"hidden\" name=\"adresse_client\" value=\"$tab1[4]\"/> $tab1[4]</p>
       			   <p>CODE POSTAL : <input type=\"hidden\" name=\"cp_client\" value=\"$tab1[5]\"/> $tab1[5]</p>
	   			   <p>Ville : <input type=\"hidden\" name=\"ville_client\" value=\"$tab1[6]\"/> $tab1[6]</p>
	   			   <p>Adresse électronique : <input type=\"hidden\" name=\"mail\" value=\"$tab1[7]\"/> $tab1[7]</p>
	   			   <p>Statut : <input type=\"hidden\" name=\"statut\" value=\"$tab1[8]\"/> $tab1[8]</p>
	   			   <p>Adresse du bien : <input type=\"text\" name=\"adresse_bien\" value=\"$tab2[1]\" /> </p>
	   			   <p>CODE POSTAL du bien : <input type=\"text\" name=\"cp_bien\" value=\"$tab2[2]\"/></p>
	   			   <p>Ville du bien : <input type=\"text\" name=\"ville_bien\" value=\"$tab2[3]\"/></p>
	   			   <p>Surface : <input type=\"text\" name=\"surface\" value=\"$tab2[4]\"/></p>
	   			   <p>Surface du terrain : <input type=\"text\" name=\"surface_terrain\" value=\"$tab2[5]\"/></p>
	   			   <p>Type de bien : <input type=\"text\" name=\"type_bien\" value=\"$tab2[6]\"/></p>
	   			   <p>Prix / mètre carré : <input type=\"text\" name=\"prix_carre\" value=\"$tab3[6]\"/></p>
	   			   <p>TVA : <input type=\"text\" name=\"tva\" value=\"$tab3[4]\"/></p>
	   			   <p>Rabais / Remise / Ristourne : <input type=\"text\" name=\"rabais\" value=\"$tab3[7]\"/></p>");
				   ?>
				   <p> Type de devis (ELE/ELS): <select name="type_bien">
									   				<option value=1>ELE</option>
								   					<option value=2>ELS</option>
							   					</select></p>
				<?php
				print("<input type=\"hidden\" name=\"soumission2\" />");
				print("<input type=\"hidden\" name=\"choix\" value=\"$id_devis\" />");
				print("<p> <input type=\"submit\" value=\"Modifier le Devis\" /> </p>");
				print("</form>");
			}
		}
	}
}
else{
	if (isset($_SESSION['client'])){
		header('Location: client.php');
	}
	else{
		header('Location: index.php');
	}
}

displayFooter();
?>