<?php
ini_set('display_errors', 1);
session_start();

include("functions.php");
include("form_functions.php");
include("config.php");


displayHeader("Création d'une facture");


if (isset($_SESSION['admin'])){

	if (!isset($_POST['is_submit_form1'])){
		?>
		<form action="facture.php" method="post">
			<p>Nom / Nom de Société : <input type="text" name="nom" /> </p>
			<p>Prénom (si particulier): <input type="text" name="prenom" />	</p>
			<p>Adresse du bien : <input type="text" name="adresse_bien" /> </p>
			<p>CODE POSTAL du bien : <input type="text" name="cp_bien"/></p>
			<p>Ville du bien : <input type="text" name="ville_bien"/></p>
			<input type="hidden" name="is_submit_form1" />
    	<input type="submit" value="Continuer" />
		</form>	
		<?php
	}
	else{

		$nom=$_POST['nom'];
		if (isset($_POST['prenom'])){
			$prenom=$_POST['prenom'];
		}
		$adresse_bien=$_POST['adresse_bien'];
		$cp_bien=$_POST['cp_bien'];
		$ville_bien=$_POST['ville_bien'];

		if (!is_ok_form_creation1()){

			echo 'Champs mal renseignés';
			?>
			<form action="facture.php" method="post">
			<?php
			if (!empty($_POST['nom'])){
				print("<p>Nom / Nom de Société : <input type=\"text\" name=\"nom\" value=\"$nom\"/> </p> ");
			}
			else{
				?>
				<p>Nom / Nom de Société : <input type="text" name="nom" /></p>
				<?php
				}
     		if (!empty($_POST['prenom'])){
     			print("<p>Prénom (si particulier): <input type=\"text\" name=\"prenom\" value=\"$prenom\"/>	</p>");
     			} 
     		else{
				?>
     			<p>Prénom (si particulier): <input type="text" name="prenom" />	</p>
				<?php
     			}
     		if (!empty($_POST['adresse_bien'])){
     			print("<p>Adresse du bien : <input type=\"text\" name=\"adresse_bien\" value=\"$adresse_bien\" /> </p>");
     			} 
     		else{
				?>
     			<p>Adresse du bien : <input type="text" name="adresse_bien" /> </p>
				<?php
     			} 
     		if (!empty($_POST['cp_bien'])){
     			print("<p>CODE POSTAL : <input type=\"text\" name=\"cp_bien\" value=\"$cp_bien\"/> </p>");
     			}
     		else{
				?>
				<p>CODE POSTAL du bien : <input type="text" name="cp_bien"/></p>
				<?php
     			}
     		if (!empty($_POST['ville_bien'])){
     			print("<p>Ville du bien : <input type=\"text\" name=\"ville_bien\" value=\"$ville_bien\"/></p>");
     			}
     		else{
				?>
				<p>Ville du bien : <input type="text" name="ville_bien"/></p>
				<?php
     			}
			?>	
			<input type="hidden" name="is_submit_form1" />
    		<input type="submit" value="Continuer" />
			</form>
			<?php
		}
		else{

			$db  = pg_connect("$conf");
			if (!empty($_POST['prenom'])){
				$res = pg_query($db,"SELECT * FROM Client WHERE nom = '$nom' AND prenom='$prenom';");
			}
			else{
				$res = pg_query($db,"SELECT * FROM Client WHERE nom = '$nom';");
			}
			$res2= pg_query($db,"SELECT * FROM Bien WHERE cp_bien = $cp_bien 
				                 AND ville_bien = '$ville_bien' AND adresse_bien='$adresse_bien';");



			if (!isset($_POST['is_submit_form2'])){
				?>
				<form action="facture.php" method="post">
				<?php
				print("<p>Nom / Nom de Société : <input type=\"hidden\" name=\"nom\" value=\"$nom\"/> $nom </p>");
				if (!empty($_POST['prenom'])){
					print("<p>Prénom (si particulier): <input type=\"hidden\" name=\"prenom\" value=\"$prenom\" /> $prenom </p>");
					?>
					<p>Civilité :   <select name="civilite"> 
										<option value="Monsieur">Monsieur</option>
							   			<option value="Madame">Madame</option>
									</select></p>
					<?php
				}
				if (pg_num_rows($res)==0){
					?>
					<p>Adresse du client : <input type="text" name="adresse_client"/> </p>
					<p>CODE POSTAL : <input type="text" name="cp_client"/> </p>
					<p>Ville : <input type="text" name="ville_client"/> </p>
					<p>Adresse électronique : <input type="text" name="mail"/> </p>
					<p>Statut : <select name="statut"> 
										<option value=1>Particulier</option>
							   			<option value=2>Professionel libéral</option>
							   			<option value=3>Entreprise</option>
								</select></p>
					<?php
				}
				else if (pg_num_rows($res)==1){
					$tab=pg_fetch_row($res);
					print("<p>Adresse du client : <input type=\"text\" name=\"adresse_client\" value=\"$tab[3]\" /> </p>
					   <p>CODE POSTAL : <input type=\"text\" name=\"cp_client\" value=\"$tab[4]\" /> </p>
				       <p>Ville : <input type=\"text\" name=\"ville_client\" value=\"$tab[5]\" /> </p>
				       <p>Adresse électronique : <input type=\"text\" name=\"mail\" value=\"$tab[6]\" /> </p>
				       <p>Statut : <input type=\"text\" name=\"statut\" value=\"$tab[7]\" /> </p>");
					}

				print("<p>Adresse du bien : <input type=\"hidden\" name=\"adresse_bien\" value=\"$adresse_bien\" /> $adresse_bien </p>");
				print("<p>CODE POSTAL du bien : <input type=\"hidden\" name=\"cp_bien\" value=\"$cp_bien\" /> $cp_bien </p>");
				print("<p>Ville du bien : <input type=\"hidden\" name=\"ville_bien\" value=\"$ville_bien\"/> $ville_bien</p>");


				if (pg_num_rows($res2)==0){
					?>
					<p>Surface :  <input type="text" name="surface"/></p>
					<p>Surface du terrain :  <input type="text" name="surface_terrain"/></p>
					<p>Type de bien :   <select name="type_bien">
									   		<option value=1>Villa/Maison</option>
								   			<option value=2>Appartement</option>
								   			<option value=3>Local commercial</option>
							   			</select></p>
				    <p>Nombre de pièces : <input type="text" name="nb_pieces" /> </p>
					<?php	
				}
				else if (pg_num_rows($res2)==1){
					$tab=pg_fetch_row($res2);
					print("<p>Surface : <input type=\"text\" name=\"surface\" value=\"$tab[4]\" /> </p>
				    	   <p>Surface du terrain : <input type=\"text\" name=\"surface_terrain\" value=\"$tab[5]\" /> </p>
				       	   <p>Type de bien : <select name=\"type_bien\" value=\"Choisir\">
							   			    <option value=1>Villa/Maison</option>
							   			    <option value=2>Appartement</option>
							   			    <option value=3>Local commercial</option>
							   		     </select></p>
						   <p>Nombre de pièces : <input type=\"text\" name=\"nb_pieces\" /> </p>");
				}
				?>		
				<p> Prix / mètre carré : <input type="text" name="prix_carre"/></p>
				<p> TVA : <input type="text" name="tva"/></p>
				<p> Rabais / Remise / Ristourne : <input type="text" name="rabais"/></p>
				<p> Type de facture (ELE/ELS): <select name="type_facture">
									   			<option value=1>ELE</option>
								   				<option value=2>ELS</option>
							   				 </select></p>
				<input type="hidden" name="is_submit_form1" />
				<input type="hidden" name="is_submit_form2"/>

				<?php

				if (pg_num_rows($res)==0){ 
					print("<input type=\"hidden\" name=\"client\" value=0 />");
				}
				else if (pg_num_rows($res)==1){
					print("<input type=\"hidden\" name=\"client\" value=1 />");
				}

				if (pg_num_rows($res2)==0){ 
					print("<input type=\"hidden\" name=\"bien\" value=0 />");
				}
				else if (pg_num_rows($res2)==1){
					print("<input type=\"hidden\" name=\"bien\" value=1 />");
				}
				?>
				<p><input type="submit" value="Valider" /> </p>
				</form>	
				<?php
			}
			else{

				if (isset($_POST['civilite'])){
					$civilite=$_POST['civilite'];
				}
				$adresse_client=$_POST['adresse_client'];
				$cp_client=$_POST['cp_client'];
				$ville_client=$_POST['ville_client'];
				$mail=$_POST['mail'];
				$statut=$_POST['statut'];
				$surface=$_POST['surface'];
				$surface_terrain=$_POST['surface_terrain'];
				$nb_pieces=$_POST['nb_pieces'];
				$prix_carre=$_POST['prix_carre'];
				$tva=$_POST['tva'];
				$rabais=$_POST['rabais'];
				$type_facture=$_POST['type_facture'];


				if (!is_ok_form_creation2()){
					?>
					<form action="facture.php" method="post">
					<?php
					print("<p>Nom / Nom de Société : <input type=\"hidden\" name=\"nom\" value=\"$nom\"/> $nom </p>");
					if (!empty($_POST['prenom'])){
						print("<p>Prénom (si particulier): <input type=\"hidden\" name=\"prenom\" value=\"$prenom\" /> $prenom </p>");
					}
					?>
				    <p>Civilité :   <select name="civilite"> 
										<option value="Monsieur">Monsieur</option>
							   			<option value="Madame">Madame</option>
									</select></p>
					<?php
					if (!empty($_POST['adresse_client'])){
						print("<p>Adresse du client: <input type=\"text\" name=\"adresse_client\" value=\"$adresse_client\"/> </p>");
					}
					else{
						?>
						<p>Adresse du client: <input type="text" name="adresse_client"/> </p>
						<?php
					}
					if (!empty($_POST['cp_client'])){
						print("<p>CODE POSTAL : <input type=\"text\" name=\"cp_client\"/> value=\"$cp_client\"</p>");
					}
					else{
						?>
						<p>CODE POSTAL : <input type="text" name="cp_client"/> </p>
						<?php
					}
					if (!empty($_POST['ville_client'])){
						print("<p>Ville : <input type=\"text\" name=\"ville_client\" value=\"$ville_client\"/> </p>");
					}
					else{
						?>
						<p>Ville : <input type="text" name="ville_client"/> </p>
						<?php
					}
					if (!empty($_POST['mail'])){
						print("<p>Adresse électronique : <input type=\"text\" name=\"mail\" value=\"$mail\"/> </p>");
					}
					else{
						?>
						<p>Adresse électronique : <input type="text" name="mail"/> </p>
						<?php
					}
					?>
					<p>Statut : <select name="statut"> 
									<option value=1>Particulier</option>
						   			<option value=2>Professionel libéral</option>
						   			<option value=3>Entreprise</option>
								</select></p>
					
					<?php

					print("<p>Adresse du bien : <input type=\"hidden\" name=\"adresse_bien\" value=\"$adresse_bien\" /> $adresse_bien </p>");
					print("<p>CODE POSTAL du bien : <input type=\"hidden\" name=\"cp_bien\" value=\"$cp_bien\" /> $cp_bien </p>");
					print("<p>Ville du bien : <input type=\"hidden\" name=\"ville_bien\" value=\"$ville_bien\"/> $ville_bien</p>");

					if (!empty($_POST['surface'])){
						print("<p>Surface :  <input type=\"text\" name=\"surface\" value=\"$surface\"/></p>");
					}
					else{
						?>
						<p>Surface :  <input type="text" name="surface"/></p>
						<?php
					}
					if (!empty($_POST['surface_terrain'])){
						print("<p>Surface du terrain :  <input type=\"text\" name=\"surface_terrain\" value=\"$surface_terrain\"/></p>");
					}
					else{
						?>
						<p>Surface du terrain :  <input type="text" name="surface_terrain"/></p>
						<?php
					}
					?>
					<p>Type de bien :   <select name="type_bien">
									   		<option value=1>Villa/Maison</option>
								   			<option value=2>Appartement</option>
								   			<option value=3>Local commercial</option>
							   			</select></p>
					<?php
					if (!empty($_POST['nb_pieces'])){
						print("<p> Nombre de pièces : <input type==\"text\" name=\"nb_pieces\" value=\"$nb_pieces\" />");
					}
					if (!empty($_POST['prix_carre'])){
						print("<p> Prix / mètre carré : <input type=\"text\" name=\"prix_carre\" value=\"$prix_carre\"/></p>");
					}
					else{
						?>
						<p> Prix / mètre carré : <input type="text" name="prix_carre"/></p>
						<?php
					}
					if (!empty($_POST['tva'])){
						print("<p> TVA : <input type=\"text\" name=\"tva\" value=\"$tva\"/></p>");
					}
					else{
						?>
						<p> TVA : <input type="text" name="tva"/></p>
						<?php
					}
					if (!empty($_POST['rabais'])){
						print("<p> Rabais / Remise / Ristourne : <input type=\"text\" name=\"rabais\" value=\"$rabais\"/></p>");
					}
					else{
						?>
						<p> Rabais / Remise / Ristourne : <input type="text" name="rabais"/></p>
						<?php
					}

					?>
					<p> Type de facture (ELE/ELS): <select name="type_bien">
									   				<option value=1>ELE</option>
								   					<option value=2>ELS</option>
							   					 </select></p>
					<input type="hidden" name="is_submit_form1" />
					<input type="hidden" name="is_submit_form2"/>
					</form>	
					<?php
				}
				else {
					$is_already_client=$_POST['client'];
					$is_already_bien=$_POST['bien'];
					$nom=trim($_POST['nom']);
					if (isset($_POST['prenom'])){
						$prenom=trim($_POST['prenom']);
					}
					if (isset($_POST['civilite'])){
						$civilite=$_POST['civilite'];
					}
					$adresse_client=trim($_POST['adresse_client']);
					$cp_client=trim($_POST['cp_client']);
					$ville_client=trim($_POST['ville_client']);
					$mail=trim($_POST['mail']);
					$statut=$_POST['statut'];

					$adresse_bien=trim($_POST['adresse_bien']);	
					$cp_bien=trim($_POST['cp_bien']);
					$ville_bien=trim($_POST['ville_bien']);
					$surface=trim($_POST['surface']);
					$surface_terrain=trim($_POST['surface_terrain']);
					$type_bien=$_POST['type_bien'];
					$nb_pieces=trim($_POST['nb_pieces']);

					$tva=trim($_POST['tva']);
					$prix_carre=trim($_POST['prix_carre']);
					$rabais_facture=trim($_POST['rabais']);
					$type_facture=trim($_POST['type_facture']);


					$req_client=pg_query($db,"SELECT id_client FROM Client ORDER BY id_client DESC;");
					$req_bien=pg_query($db,"SELECT id_bien FROM Bien ORDER BY id_bien DESC;");
					$req_facture=pg_query($db,"SELECT id_facture FROM Facture ORDER BY id_facture DESC;");
					$req_user=pg_query($db,"SELECT id_user FROM Utilisateur ORDER BY id_user DESC;");


					$nb_client= pg_fetch_row($req_client);
					$nb_bien= pg_fetch_row($req_bien);
					$nb_facture= pg_fetch_row($req_facture);

					$id_client=$nb_client[0] + 1;
					$id_bien=$nb_bien[0] + 1;
					$id_facture=$nb_facture[0] + 1; 

					$montant=($prix_carre*$surface)*(1+($tva/100))-$rabais_facture;
					$annee=date("Y");
					$mois=date("m");
					$jour=date("d");
					$date=$annee . "-" . $mois . "-" . $jour; 
					$password=chaine_aleatoire(8);
					echo $password;
					if (isset($_POST['prenom'])){
						$login=$nom . "." . $prenom;
					}
					else{
						$login=$nom;
					}
					$hash_pass=sha1("imosoweb") . $login . sha1($password);

					if ($is_already_client==0){

						$res_user = pg_query($db,"INSERT INTO Utilisateur VALUES($id_client, '$login','$hash_pass',1);");

						if (isset($_POST['prenom'])){
							$res_client = pg_query($db,"INSERT INTO Client VALUES ($id_client,'$nom','$prenom', '$civilite', 
								                '$adresse_client',$cp_client,'$ville_client','$mail',$statut);");
						}
						else{
							$res_client = pg_query($db,"INSERT INTO Client VALUES ($id_client, '$nom',NULL, NULL,
							                '$adresse_client',$cp_client,'$ville_client','$mail',$statut);");
						}
						if ($is_already_bien==0){
							$res_bien= pg_query($db,"INSERT INTO Bien VALUES ($id_bien,'$adresse_bien',$cp_bien,
							                   '$ville_bien',$surface,$surface_terrain,$type_bien,$nb_pieces,$id_client);");

							$res_facture= pg_query($db,"INSERT INTO Facture VALUES ($id_facture, $id_client, $id_bien, $montant, 
																$tva,0, '$date', $prix_carre, $rabais_facture,$type_facture);");
						}
						else{

							$res_bien= pg_query($db,"UPDATE Bien SET surface=$surface, surface_terrain=$surface_terrain, 
							                  type_bien=$type_bien, nb_pieces=$nb_pieces, id_proprietaire=$id_client
											 WHERE adresse_bien='$adresse_bien' AND cp_bien=$cp_bien AND ville_bien='$ville_bien';");

							$req_bien= pg_query($db,"SELECT id_bien FROM Bien WHERE adresse_bien='$adresse_bien' 
												 AND cp_bien=$cp_bien AND ville_bien='$ville_bien';");

							$tab_bien=pg_fetch_row($req_bien); 

							$res_facture= pg_query($db,"INSERT INTO Facture VALUES ($id_facture, $id_client, 
													  $tab_bien[0], $montant, $tva,0, '$date', $prix_carre, $rabais_facture,$type_facture);");
						}
					}

					if ($is_already_client==1){

						$req_client= pg_query($db,"SELECT id_client FROM Client   
											 WHERE nom='$nom' AND prenom='$prenom';");

						$tab_client=pg_fetch_row($req_client);

						if (isset($_POST['prenom'])){

							$res_client = pg_query ($db,"UPDATE Client SET adresse_client='$adresse_client', 
								civilite='$civilite', cp_client=$cp_client, ville_client='$ville_client',email='$mail' 
								WHERE nom='$nom' AND prenom='$prenom';");

						}
						else{
							$res_client = pg_query ($db,"UPDATE Client SET adresse_client='$adresse_client', 
								cp_client=$cp_client, ville_client='$ville_client',email='$mail' WHERE nom='$nom';");
						}
						if ($is_already_bien==0){

							$res_bien= pg_query($db,"INSERT INTO Bien VALUES ($id_bien, '$adresse_bien',$cp_bien,'$ville_bien',
							                                              $surface,$surface_terrain,$type_bien,$nb_pieces,$id_client);");

							$res_facture= pg_query($db,"INSERT INTO Facture VALUES ($id_facture, $tab_client[0], 
															  $id_bien, $montant, $tva,0, '$date', $prix_carre, $rabais_facture, $type_facture);");
						}
						else{

							$res_bien= pg_query($db,"UPDATE Bien SET surface=$surface, surface_terrain=$surface_terrain, type_bien=$type_bien, nb_pieces=$nb_pieces
													 WHERE adresse_bien='$adresse_bien' AND cp_bien=$cp_bien AND ville_bien='$ville_bien';");

							$req_bien= pg_query($db,"SELECT id_bien FROM Bien WHERE adresse_bien='$adresse_bien' 
												 AND cp_bien=$cp_bien AND ville_bien='$ville_bien';");

							$tab_bien= pg_fetch_row($req_bien);

							$res_facture= pg_query($db,"INSERT INTO Facture VALUES ($id_facture, $tab_client[0], 
															  $tab_bien[0], $montant, $tva,0, '$date', $prix_carre, $rabais_facture, $type_facture);");

						}
					}
				}
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