<?php
//Mise en page
include ("miseenpage.php");

//Ouverture de la variable de session evenement
$evenementchoisi=$_SESSION['evenement'];

//Connexion à la base de donnée
$db=pg_connect("host=pgsql user=anouk.delannoy dbname=site_choristes_ad_am password =".$_SESSION['bdd']);
	
//Si la connexion à la base échoue
if(!$db){
echo 'Echec de la connexion à la base <br/>';
}
	
//Sinon on sélectionne l'événement choisi
else {
$request=("SELECT nom FROM evenement WHERE id_evenement=$evenementchoisi;");
$recherche=pg_query($db,$request); 
$resultat=pg_fetch_row($recherche);
$nb_tuples=pg_num_rows($recherche);
}

docEnTete("Modification", "Modification d'une oeuvre au programme de $resultat[0]" );

//Extraction de la variable $_POST (contient num_oeuvre, modifier ou supprimer)
extract($_POST);

//Variable de session : page affichée une fois authentifié ou déconnecté
$_SESSION['page']="programmation.php";
?>

<?php
//Si l'utilisateur est bien connecté en tant que chef de choeur
if (isset($_SESSION['login']) && $_SESSION['chef']==1){
?>

<!-- Affichage du login -->

<fieldset id="oui">
<legend>Authentification</legend>
<p> Login : <?php echo $_SESSION['login'] ; ?> </p>
<a href="deconnexion.php"><button type="button">Déconnexion</button></a>
</fieldset>

<!--Affichage des oeuvres à modifier-->
<?php
//Si le numéro d'oeuvre n'est pas entré on affiche une erreur
if(!isset($_POST['num_oeuvre'])){
print "Renseignez le numéro de l'oeuvre que vous souhaitez modifier. <br/>";
}

//Sinon on affiche la page de modification
else {

//Si l'utilisateur veut modifier l'oeuvre du programme
if(isset($_POST['modifier'])){

//$t est le nombre d'oeuvres choisies
$t=sizeof($num_oeuvre);

print "<p>Remplissez les champs caractérisant l'oeuvre à modifier.<br/> </p>";

//Affichage des données modifiables sous forme d'un tableau et transmission des modifications à modification_fin.php	
print "<TABLE>"; 
print "<TR>";
print "<TH> Titre </TH>"; 
print "<TH> Compositeur </TH> ";
print "<TH> Style </TH> ";
print "<TH> Durée </TH> ";
print "<TH> Partition </TH> ";
print "<TH> Oeuvre non vue </TH> ";
print "<TH> Oeuvre en cours </TH> ";
print "<TH> Oeuvre apprise </TH> ";
print "</TR>";

for($i=0 ; $i<$t ; $i=$i+1){
//Sélection des tuples à modifier de l'oeuvre choisie
$recherche=pg_query($db,"SELECT * FROM oeuvre WHERE id_oeuvre=$num_oeuvre[$i];"); 
$resultat=pg_fetch_row($recherche);
$nb_tuples=pg_num_rows($recherche);

//Affichage de champs de modification dont le résultat mènera vers modification_fin.php : les champs sont préremplis par les valeurs de l'oeuvre sélectionnée
print "<form action=\"modification_fin.php\" method=\"post\">";
if($nb_tuples>=0){
print  "<TR>";
print " <input type=\"hidden\" name=\"num_oeuvre[$i]\" value=\"$resultat[0]\"/>";
print " <TD> <input type=\"text\" name=\"titre[$i]\" size=\"12\" value=\"$resultat[1]\"/> </TD>";
print "	<TD> <input type=\"text\" name=\"auteur[$i]\" size=\"8\" value=\"$resultat[2]\"/> </TD>";
print "	<TD> <input type=\"text\" name=\"style[$i]\" size=\"8\" value=\"$resultat[4]\"/> </TD>";
print "<TD>  <input type=\"text\" name=\"duree[$i]\" size=\"8\"value=\"$resultat[5]\"/> </TD>";
print "<TD> <input type=\"text\" name=\"partition[$i]\" size=\"8\" value=\"$resultat[3]\"/> </TD>";
print "
<TD><input type=\"radio\" name=avancement[$i] value=\"r\""; if($resultat[6]=='r') {print"checked";} print"> <div id=\"r\"> &nbsp; </div> </TD>
<TD> <input type=\"radio\" name=avancement[$i] value=\"j\"";if($resultat[6]=='j') {print "checked";} print"> <div id=\"j\"> &nbsp; </div> </TD>
<TD> <input type=\"radio\" name=avancement[$i] value=\"v\"";if($resultat[6]=='v') {print "checked";} print"> <div id=\"v\"> &nbsp; </div> </TD>";
print "</TR>";
}
}		
print "</TABLE>";
print "<p><input type=\"submit\" value=\"Valider\"/></p> </form>";
}

else {
//Si le chef de choeur veut supprimer des oeuvres de la programmation de l'événement :
if(isset($_POST['supprimer'])) {
$t=sizeof($num_oeuvre);

//On affiche un tableau décrivant les oeuvres sélectionnées	
print "<TABLE>"; 
print "<TR>";
print "<TH> Titre </TH>"; 
print "<TH> Compositeur </TH> ";
print "<TH> Style </TH> ";
print "<TH> Durée </TH> ";
print "<TH> Partition </TH> ";
print "<TH> Avancement </TH> ";
print "</TR>";

for($i=0;$i<$t;$i=$i+1){
$request=("SELECT * FROM oeuvre WHERE id_oeuvre=$num_oeuvre[$i];");
$recherche=pg_query($db,$request); 
$resultat=pg_fetch_row($recherche);
$nb_tuples=pg_num_rows($recherche);
	
if($nb_tuples>=0) {
print  "<TR>";
print " <TH> $resultat[1]</TH>";
print "	<TH> $resultat[2]</TH>";
print "	<TH> $resultat[3] </TH>";
print "<TH>  $resultat[4] </TH>";
print "<TH> $resultat[5] </TH>";
print "<TH> <div id = $resultat[6]> &nbsp; </div> </TH>" ;
print "</TR>";
}
}
print "</TABLE>";

//On supprime de la table est_au_programme le couple oeuvre choisie, événement choisi
for($i=0;$i<$t;$i=$i+1){
$request=("DELETE FROM est_au_programme WHERE oeuvre_idoeuvre=$num_oeuvre[$i] AND evenement_idevenement= $evenementchoisi;");
$recherche=pg_query($db,$request); 
$resultat=pg_fetch_row($recherche);
}

print "<p>Les oeuvres choisie(s) ont été supprimée(s) du programme avec succès </p> <br/>";
}
} 
}
}

//Si l'utilisateur n'est pas authentifié en tant que chef de choeur
else {

if(!isset($_SESSION['login'])) {
?>

<!-- Affichage du cadre d'authentification -->
<fieldset id="non">
<legend>Authentification</legend>
<form action="authentification.php" method="post">
<p> Login : <input type="text"name="log" size="8"/> </p>
<p> Mot de passe : <input type="password" name="mdp" size="8"/> </p>
<p> <input type="submit" value="Valider"/> </p>  
</form>
</fieldset>

<?php
}

if (isset($_SESSION['login']) && $_SESSION['chef']==0) {
?>

<!-- Affichage du login -->
<fieldset id="oui">
<legend>Authentification</legend>
<p> Login : <?php echo $_SESSION['login'] ; ?> </p>
<a href="deconnexion.php"><button type="button">Déconnexion</button></a>
</fieldset>

<?php
}
print "Vous devez être connecté en tant que chef de choeur pour modifier une oeuvre <br/>";
}
?>

<?php
print "<a href=\"programmation.php\"><button type=\"button\">Retour à la programmation</button></a> <br/>
<a href=\"evenement.php\"><button type=\"button\">Retour aux événements</button></a>";
pied();
?>
