<?php

include'miseenpage.php';
include'functions(1).php';

$id_client=1;
$Doc_type="Facture"; 

if ($Doc_type=="Facture")
	{
	$Doc_type2="Vos Factures";
	$pagetitle="Consultation";
	$title="Consultation";
	$subtitle=$Doc_type2;//Nature du document (devis ou facture)

	title($pagetitle,$title, $subtitle);
section_gauche();
/***************************************************AFFICHACHE LISTE DES DOCUMENTS*************************************/

	$db=pg_connect($conf);
	if($db==false)
		{echo "Echec de la connexion à la base.<br/>";}
	else
		{
		$request=("SELECT id_facture, date_emission FROM facture WHERE id_client_facture= $id_client ");
		if($request==false)
				{echo "Requête erronée.<br/>";}
		else
			{
			$recherche=pg_query($db,$request);
			if($recherche<0)
				{echo "Echec de la transmission de la requête. <br/>";}
			else
				{
				$result=pg_fetch_row($recherche);
				if($result<0)
					{echo "Aucun résultat pour la requête.<br/>";}
				else
					{
					$nb_tuples=pg_num_rows($recherche);
					if($nb_tuples<=0)
						{echo "Aucune facture n'a été générée à votre nom. <br/>";}
					else
						{
						print "<TABLE>"; 
						print "<TR>";
						print "<TH> Immatriculation </TH>"; 
						print "<TH> Date d'émission </TH> ";
						print "</TR>"; 	
						print "<TR>";
						echo  "<TH><form action=\"consultationfichier.php\" method=\"post\">
								<input type=\"HIDDEN\" name=\"num_facture\" value=\"$result[0]\">
								<input type=\"HIDDEN\" name=\"doc_type\" value=\"$Doc_type\">
								<p> <input type=\"submit\"  value=\"$Doc_type n°$result[0]\"/> </p>
								</form>
							 	</TH>";
						print "<TH> $result[1]</TH>";
						print "<TH><a href=\"séquences22.pdf\"><img src=\"icone-pdf.png\" title=\"Cliquez pour agrandir\" /></a></TH>";
						print "</TR>";
						while ($result=pg_fetch_row($recherche))	
							{
							print "<TR>";
							echo  "<TH><a href=\"consultationfichier.php\"> $Doc_type n°$result[0] </a></TH>";
							print "<TH> $result[1]</TH>";
							print "<TH><a href=\"séquences22.pdf\"><img src=\"img/bitnami.png\" title=\"Cliquez pour agrandir\" /></a></TH>";
							print "</TR>";
							}
						print "</TABLE>";
						echo "Cliquer sur le document que vous souhaitez consulter.<br/>";

						}
					}
				}		
			}
		}

	}
else
	{
		$Doc_type2="Vos Devis";
	$pagetitle="Consultation";
	$title="Consultation";
	$subtitle=$Doc_type2;//Nature du document (devis ou facture)

	title($pagetitle,$title, $subtitle);

/***************************************************AFFICHACHE LISTE DES DOCUMENTS*************************************/

	$db=pg_connect($conf);
	if($db==false)
		{echo "Echec de la connexion à la base.<br/>";}
	else
		{
		$request=("SELECT id_devis, date_devis FROM devis WHERE id_client_devis= $id_client ");
		if($request==false)
				{echo "Requête erronée.<br/>";}
		else
			{
			$recherche=pg_query($db,$request);
			if($recherche<0)
				{echo "Echec de la transmission de la requête. <br/>";}
			else
				{
				$result=pg_fetch_row($recherche);
				if($result<0)
					{echo "Aucun résultat pour la requête.<br/>";}
				else
					{
					$nb_tuples=pg_num_rows($recherche);
					if($nb_tuples<=0)
						{echo "Aucune facture n'a été générée à votre nom. <br/>";}
					else
						{
						print "<TABLE>"; 
						print "<TR>";
						print "<TH> Immatriculation </TH>"; 
						print "<TH> Date d'émission </TH> ";
						print "</TR>"; 	
						print "<TR>";
						echo  "<TH><form action=\"consultationfichier.php\" method=\"post\">
								<input type=\"HIDDEN\" name=\"num_devis\" value=\"$result[0]\">
								<input type=\"HIDDEN\" name=\"doc_type\" value=\"$Doc_type\">
								<p> <input type=\"submit\" value=\" $Doc_type n°$result[0]\"/> </p>  
								</form>
							 	</TH>";
						print "<TH> $result[1]</TH>";
						print "<TH><a href=\"séquences22.pdf\"><img src=\"icone-pdf.png\" title=\"Cliquez pour agrandir\" /></a></TH>";
						print "</TR>";
						while ($result=pg_fetch_row($recherche))	
							{
							print "<TR>";
							echo  "<TH><a href=\"consultationfichier.php\"> $Doc_type n°$result[0] </a></TH>";
							print "<TH> $result[1]</TH>";
							print "<TH><a href=\"séquences22.pdf\"><img src=\"img/bitnami.png\" title=\"Cliquez pour agrandir\" /></a></TH>";
							print "</TR>";
							}
						print "</TABLE>";
						echo "Cliquer sur le document que vous souhaitez consulter.<br/>";

						}
					}
				}		
			}
		}
	} 

section_droite();
displayFooter();


?>