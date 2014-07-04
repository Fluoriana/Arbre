                                                        <!-- ENTETE -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <!-- Insertion des fichiers css -->
        <link href="bootstrap-3.2.0-dist/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap.css" rel="stylesheet">
        <link rel=\"stylesheet\" href=\"imosoweb_devis_factures.css\"/>
    </head>
    <!-- AFFICHAGE DES ERREURS -->
<?php ini_set("display_errors",1); ?>
 
    <body>
    <!--<div class="container"> -->
   

        <header class="row">
            <div class="col-lg-12">
            Entete et autre        
            </div>
        </header>    



    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="Accueil.php">Espace Client</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#about">About</a>
                    </li>
                    <li><a href="#services">Services</a>
                    </li>
                    <li><a href="#contact">Contactez-nous</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

<!--
<?php
               /* function title($pagetitle,$title,$subtitle)
                    {
                    ?>
                    <title> <?php echo $pagetitle; ?></title>              
                    <h1> <?php echo $title; ?> </h1>
                    <h2> <?php  echo $subtitle; ?> </h2>
                    <?php  
                    }*/
                    ?>
-->

<?php
                function title($pagetitle,$title,$subtitle)
                    {
                    ?>

                    <title> <?php echo $pagetitle; ?></title>        
                     <header class="page-header">
                    <div class="titre"> 
                    </div><h1><?php echo $title; ?></h1>
                    <h2> <?php  echo $subtitle; ?> </h2>
                    </div>
                       </header>      
                    <?php                   
                    }
                    ?>

      

<?php
function section_gauche()
{?>

      <div class="row">

            <section class="col-lg-10">
                      Section
<?php
}


function section_droite()
{?>            </section>

            <div class="col-lg-2">
                <div class="row">
                    <aside class="col-lg-12">
                        Aside
                        <div id="authentification">
                        <a href="deconnexion.php">Se dÃ©connecter</a> 
                        </div>
                    </aside>
                    <aside class="col-lg-12">
                      Aside
                      <ul class="navigation">
                        <li class="toggleSubMenu"><span>Vos Devis</span>
                            <ul class="subMenu">
                            <li><a href="#" title="Aller à la page 2.1">Tous vos devis</a></li>
                            <li><a href="#" title="Aller à la page 2.2">Devis en attente</a></li>
                            <li><a href="#" title="Aller à la page 2.3">Anciens devis</a></li>
                            </ul>
                        </li>
                        <li class="toggleSubMenu"><span>Vos factures</span>
                            <ul class="subMenu">
                            <li><a href="#" title="Aller à la page 3.1">Toutes vos factures</a></li>
                            <li><a href="#" title="Aller à la page 3.2">Factures en attente</a></li>
                           <li><a href="#" title="Aller à la page 3.2">Factures réglées</a></li>

                            </ul>
                        </li>
                        <li><a href="#" title="Aller à la page 4">Nous contacter</a></li>
                      </ul>
                    </aside>
                </div>
            </div>

        </div>
<?php
}
?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready( function () {
    // On cache les sous-menus :
    $(".navigation ul.subMenu").hide();
    // On sélectionne tous les items de liste portant la classe "toggleSubMenu"

    // et on remplace l'élément span qu'ils contiennent par un lien :
    $(".navigation li.toggleSubMenu span").each( function () {
        // On stocke le contenu du span :
        var TexteSpan = $(this).text();
        $(this).replaceWith('<a href="" title="Afficher le sous-menu">' + TexteSpan + '<\/a>') ;
    } ) ;

    // On modifie l'évènement "click" sur les liens dans les items de liste
    // qui portent la classe "toggleSubMenu" :
    $(".navigation li.toggleSubMenu > a").click( function () {
        // Si le sous-menu était déjà ouvert, on le referme :
        if ($(this).next("ul.subMenu:visible").length != 0) {
            $(this).next("ul.subMenu").slideUp("normal");
        }
        // Si le sous-menu est caché, on ferme les autres et on l'affiche :
        else {
            $(".navigation ul.subMenu").slideUp("normal");
            $(this).next("ul.subMenu").slideDown("normal");
        }
        // On empêche le navigateur de suivre le lien :
        return false;
    });    


} ) ;
</script>  

   


<!--AFFICHAGE PIED DE PAGE 

function displayFooter()
{  ?> 
<div id="infoslegales">
    <p>Imosoweb<br/></p>
    <p>Tel: 06.59.42.92.18<br/></p>
    <p>imosoweb@me.com<br/></p>
    <p>10 boulevard Louise Michelle<br/></p>
    <p> 91042 Evry Cedex<br/></p>
    <p>Copyright© 2014 IMOSOWEB. Tous droits réservés<br/></p>
</div>
-->

<?php
function displayFooter()
{  ?> 
<footer class="row">
        <div class="col-lg-12">
          Pied de page
        <address>
          <p>Imosoweb<br/></p>
    <p>Tel: 06.59.42.92.18<br/></p>
    <p>imosoweb@me.com<br/></p>
    <p>10 boulevard Louise Michelle<br/></p>
    <p> 91042 Evry Cedex<br/></p>
    <p>Copyright© 2014 IMOSOWEB. Tous droits réservés<br/></p>
        </address>
        </div>
      </footer>

<?php
    echo "</body></html>"; 
}
 
?>