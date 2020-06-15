<?php

if(!empty($_GET['dir'])){
  $dir = simplePath($_GET['dir']);
}
else{
  $dir = './';
}

$opendir = false;
if(is_dir($dir)){
  $opendir = opendir($dir);
}
if(!$opendir) {
  $dir = './';
  $opendir = opendir('./') or die();
}

if(substr($dir, 0, 2) == './'){
  $dir = substr($dir, 2);
}

// si on a cliqué sur le bouton "Créer un nouveau fichier"...
if (isset($_POST['submit'])) {

  // si le nom de fichier est vide
  if (empty($_POST['name'])) {
    header('Location: index.php?action=nofile');
    exit();
  }

  else {
    // Si le fichier n'existe pas...
    if (!file_exists($_POST['name'])) {
      $nom_file = htmlspecialchars($_POST['name']);

      // création du fichier
      $f = fopen($dir.$nom_file, "x+");

      // fermeture
      fclose($f);

      // on renvoie sur la page principale du files explorer
      header('Location: ../files-explorer');
    }
    else {
      // si le fichier existe déjà on renvoie sur un message d'erreur
      header('Location: index.php?action=file_exists');
      exit();
    }
  }
}

else {
    echo "Vous ne pouvez pas accéder à cette page directement.";
}

?>
