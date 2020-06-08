?<?php
// Si le répertoire a été défini et s'il existe...
if (isset($_GET['id']) && $_GET['id']) {
    $id = $_GET['id'];
    rmdir($id); // On le supprime
    header('Location: ../files-explorer');
  }
?>
