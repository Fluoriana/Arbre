<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<?php

include'functions(1).php';


//Extraction de la variable $_POST
extract($_POST); 	
if ($_POST != NULL) 
	{
	if($_POST['doc_type']=="Facture")
		{
		$facture=$_POST['num_facture'];
		$db=pg_connect($conf);
		if($db==false)
			{echo "Echec de la connexion à la base.<br/>";}
		else
			{
			$request=("SELECT DISTINCT id_facture, date_emission, id_client,tva, prixht, prix_carre_facture, nom, prenom, adresse_client, cp_client, ville_client, id_bien, surface, rabais_facture FROM facture NATURAL JOIN (bien NATURAL JOIN client) WHERE id_facture=$facture");
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
							$tva=$result[3];
							$prixht=$result[4];
							$acompte=30;	
							$prixmaoinsacompte=3;
							$prixttc=($tva*$prixht)/100+$prixht;
							print "Imosoweb</br>06.59.42.92.18</br>imosoweb@me.com</br>10 boulevard Louise Michelle</br>91000 EVRY CEDEX</br>";
							print "Objet: $EDLS </br>";
							print "Date d'émission: $result[1] </br>";
							print "Facture n° $result[0] </br>";
							print "$result[6] </br> $result[7] </br> $result[8] </br> $result[9] $result[10] </br>";
							print "$result[2]</br>";

							print "<TABLE>"; 
							print "<TR>";
							print "<TH> Identifiant bien  </TH>"; 
							print "<TH> Superficie </TH> ";
							print "<TH> Tarif au m² </TH> ";
							print "<TH> Total HT </TH> ";
							print "<TH> Remise </TH> ";
							print "<TH> TVA </TH> ";
							print "<TH> Total TTC</TH> ";
							print "</TR>"; 	
							print "<TR>";
							print "<TH> $result[11]</TH>";
							print "<TH> $result[12]</TH>";
							print "<TH>$result[5]</TH>";
							print "<TH> $result[4] </TH> ";
							print "<TH> $result[13]</TH> ";
							print "<TH> $result[3] </TH> ";
							print "<TH> $prixttc </TH> ";
							print "</TR>";
							print "</TABLE>";

							$frais=2;
							$net_a_payer=$prixttc+$frais;
							print "<TABLE>"; 
							print "<TR>";
							print "<TH> Montant HT </TH> ";
							print "<TH> $result[4] </TH> ";
							print "</TR>";
							print "<TR>";
							print "<TH> Remise </TH> ";
							print "<TH> $result[13]</TH> ";
							print "</TR>";
							print "<TR>";
							print "<TH> TVA </TH> ";
							print "<TH> $result[3] </TH> ";
							print "</TR>";
							print "<TR>";
							print "<TH> Montant TTC</TH> ";
							print "<TH> $prixttc </TH> ";
							print "</TR>";
							print "<TR>";
							print "<TH> Frais </TH> ";
							print "<TH> $frais </TH> ";
							print "</TR>";
							print "<TR>";
							print "<TH> net à payer</TH> ";
							print "<TH> $net_a_payer</TH> ";
							print "</TR>"; 	
							print "</TABLE>";
						 	}	
						}
					}	
				}	
			}
		}
	else /*si c'est un devis*/
		{
			print "pipi";
		$devis=$_POST['num_devis'];

		$db=pg_connect($conf);
		if($db==false)
			{echo "Echec de la connexion à la base.<br/>";}
		else
			{
			$request=("SELECT DISTINCT id_devis, date_devis, id_client_devis,tva, montantht, adresse_client, cp_client, ville_client 	FROM devis NATURAL JOIN (bien NATURAL JOIN client) WHERE id_devis=$devis");
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
							$tva=$result[3];
							$montantht=$result[4];
							$prixttc=($tva*$montantht)/100+$montantht;
							$acompte=(30*$prixttc)/100;
							$prixmaoinsacompte=$prixttc-$acompte;
							print"Ref: $result[0]";
							print"Objet: Proposition $EDLS";
							print "$civilité,</br>";
							print"Vous nous avez contacté afin de réaliser des états des lieux d’entrée et de sortie se situant : $result[5] $result[6] $result[7] et nous vous remercions de la marque de confiance que vous nous accordée.<br/>";
							print"Veuillez trouver ci dessous  le détail de la proposition de mission concernant votre demande :</br>
							missionA Un état des lieux de sortie </br>
							missionB Rédaction des actes </br>
							missionC Prise de photo </br>
							missionD Envoi par mail et courrier des états des lieux </br>
							missionE </br>
							missionF </br>
							missionG </br>
							missionH </br>";
							print"Le tarif de nos prestations est estimé à $result[4] euros hors taxe.<br/>";
							print "Le règlement de nos honoraires s’effectuera par le versement d’un acompte de  30% TTC soit $acompte euros lors de l’acceptation de notre proposition et le solde de $prixmaoinsacompte euros à la facturation.<br/>";

							print "Si notre proposition de mission vous convient, nous vous remercions de bien vouloir nous retourner l’exemplaire avec la mention «  bon pour accord » daté et signé.<br/>";

							print "Nous restons à votre disposition et nous vous prions d’agréer, $civilite, l’expression de nos salutations distinguées.<br/>";
                                                                                       

    	       				print "<div id=\"signaturepres\">Jérôme CREDALI<br/>";
        	                print "Président de la SAS Imosoweb<br/></div>";
						 	}	
						}
					}	
				}	
			}
		}	
	}


?>