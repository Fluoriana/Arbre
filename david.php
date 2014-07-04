<?php

include'miseenpage.php';
include'functions(1).php';


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
/*
if(isset($_POST['exec']))
{
  if(isset($_GET['action']) && $_GET['action'] == 'yes')
  {
    $cmd = exec('./main')	;
   
    if($cmd)
    {
       echo 'Lancement Ok ';
    }
    else
    {
       echo 'Le lancement du shell n\'a pas fonctionner';
    }
  }
}

echo '<form method="post" action="david.php?action=yes">
<input type="submit" name="exec" value="Executer" >
</form>'; */
echo exec('./main.sh');

if(exec('./main.sh'))
{print "pilipipi!";}
else 
{print " bouuuh";}
?>