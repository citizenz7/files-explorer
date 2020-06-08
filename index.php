<?php include_once 'functions.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
  <title>Files manager</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="container">
    <div class="row">
      <div class="col-sm px-3 py-3 mt-3">
        <h2>Files Manager</h2>
      </div>
    </div>

    <div class="row">
      <div class="col-sm px-3 py-1">

        <?php

        if (isset($_POST['selectedfile'])) {
          $selectedfile = $_POST['selectedfile'];
          if (chdir($selectedfile)) {
            chdir($selectedfile);
          }
          else {
            chdir(getcwd());
          }
        }

        // BREADCRUMBS

        /*
        $url = "files-explorer";

        // analyse l'url et retourne ses composants
        $parts = parse_url($url);

        // retourne les infos sur le chemin du répertoire
        $path = pathinfo($parts['path']);

        // explode sépare chaque élément, trim = supprime les espaces
        $segments = explode('/', trim($path['dirname'],'/'));

        $breadcrumbs[] = '<a href="/">Accueil</a>';
        $crumb_path = '';

        foreach ($segments as $segment)
        {
            $crumb_path .= '/' . $segment;

            // ucfirst : majuscule première lettre du mot
            $value = ucfirst($segment);

            $breadcrumbs[] = '<a href="' . $crumb_path . '">' . $value . '</a>';
        }

        $breadcrumbs[] = ucwords(str_replace('_', ' ', $path['filename']));
        $breadcrumbs   = implode(' > ', $breadcrumbs);
        */

        $def = "index";
        $dPath = $_SERVER['PHP_SELF'];
        $dChunks = explode("/", $dPath);

        echo('<p class="bg-primary text-white px-3 py-2"><a class="text-white" href="/">Accueil</a><span> > </span>');
        for($i=1; $i<count($dChunks); $i++ ){
	         echo('<a class="text-white" href="/');
	          for($j=1; $j<=$i; $j++ ){
		            echo($dChunks[$j]);
		              if($j!=count($dChunks)-1){ echo("/");}
	          }

	          if($i==count($dChunks)-1){
		            $prChunks = explode(".", $dChunks[$i]);
		              if ($prChunks[0] == $def) $prChunks[0] = "";
		                $prChunks[0] = $prChunks[0] . "</a>";
	          }
	          else $prChunks[0]=$dChunks[$i] . '</a><span> > </span>';
	           echo('">');
	           echo(str_replace("_" , " " , $prChunks[0]));
             echo "</p>";
        }
        ?>

        <!--
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><?php echo $breadcrumbs; ?></li>
          </ol>
        </nav>
      -->

        <?php
        if(isset($_GET['action']) && $_GET['action'] == 'nofile') {
          echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <i class='fas fa-exclamation-triangle'></i> Erreur : nom de fichier vide
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
        }

        if(isset($_GET['action']) && $_GET['action'] == 'file_exists') {
          echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <i class='fas fa-exclamation-triangle'></i> Le fichier existe déjà
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
        }

        echo "
          <form action='ajouter.php' method='POST'>
            <div class='form-group'>
              <label for='name'>Créer un nouveau fichier : </label>
              <input type='text' class='form-control-sm' name='name' placeholder='Entrez un nom de fichier' size='50'>
              <button onclick=\"return confirm('Êtes-vous certain de vouloir ajouter ce fichier ?')\" type='submit' name='submit' class='btn btn-primary btn-sm'>
                Envoyer
              </button>
              <button class='btn btn-secondary btn-sm' type='reset'>
                Annuler
              </button>
            </div>
          </form>
        ";
        ?>

      </div>
    </div>
  </div>

<div class="container">
  <div class="row">
    <div class="col-sm mt-3">

<table class="table table-sm table-hover mb-5">
  <thead>
    <tr>
      <th scope="col">Nom</th>
      <th scope="col">Taille</th>
      <th scope="col">Type</th>
      <th scope="col">Propriétaire</th>
      <th scope="col">Date modif</th>
      <th scope="col">Suppr.</th>
    </tr>
  </thead>
  <tbody>

    <?php
    $url = getcwd(); //gets the current working directory
    $contents = scandir($url); //scan the directory

      foreach ($contents as $item) {
         $size = formatSizeUnits(filesize($item));
         //$type = mime_content_type($item);
         $date = date("d-m-Y H:i:s", filemtime($item));
         $owner = fileowner($item);

         // on recherche le type de fichier
         $finfo = finfo_open(FILEINFO_MIME_TYPE);
         $type = finfo_file($finfo, $item);

         // Todo: on peut aussi le faire avec un switch
         if (isset($type)) {
            if (in_array($type, array("image/png", "image/jpeg", "image/gif"))) {
              $check = "<i class='far fa-image'></i>";
            }
            elseif(in_array($type, array("text/plain"))) {
              $check = "<i class='fas fa-file'>";
            }
            elseif(in_array($type, array("text/x-php"))) {
              $check = "<i class='fab fa-php'>";
            }
            elseif(in_array($type, array("text/x-php"))) {
              $check = "<i class='fab fa-js'>";
            }
            else {
              $check = "<i class='fas fa-file-alt'>";
            }
          }

         if (is_dir($item)) {
            echo "
            <form method=\"POST\">
            <tr>
              <td>
                <i class='fas fa-folder-open'></i>
                <input type=\"hidden\" name=\"selectedfile\" value=\"".realpath($item). "\"><a href=\"".$_SERVER['REQUEST_URI']."/".$item."\">
                <input type=\"submit\" value=\"".$item."\">
                </a>
              </td>
              <td class='smalltext'>".$size."</td>
              <td class='smalltext'>".$type."</td>
              <td class='smalltext'>".$owner."</td>
              <td class='smalltext'>".$date."</td>
            </tr>
            </form>
            ";
         }
         else {
            echo "
            <tr>
              <td class='firstcol'>".$check."</i> <a href='".$item."'>$item</a></td>
              <td class='smalltext'>".$size."</td>
              <td class='smalltext'>".$type."</td>
              <td class='smalltext'>".$owner."</td>
              <td class='smalltext'>".$date."</td>
              <td class='lastcol'><a href='supprimer.php?id=".$item."' onclick=\"return confirm('Êtes-vous certain de vouloir supprimer ce fichier ?')\"><i class='fas fa-trash'></i></a></td>
            </tr>
            ";
         }
      } //for each
    ?>

  </tbody>
</table>
  </div>
</div>
</div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>
