<?php include_once 'functions.php'; ?>

<?php
if (isset($_POST['selectedfile'])) {
  $selectedfile = $_POST['selectedfile'];
  //echo $selectedfile;
  if (chdir($selectedfile)) {
    chdir($selectedfile);
  }
  else {
    chdir(getcwd());
  }
}
// always home Sergio
  $home = dirname(__DIR__)."/";
  if (isset($_POST['selectedfile'])) {
    $selectedfile = $_POST['selectedfile'];
    $replace = str_replace($home, "http://olivier/", $selectedfile);
    //echo $replace;
  }
?>

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

  <div class="container card mb-5">

    <div class="row">
      <div class="col-sm px-3 py-3 mt-3 bg-dark text-white text-center">
        <h1>Files Manager</h1>
      </div>
    </div>

    <div class="row">
      <div class="col-sm px-3 py-1">

        <?php
        if(isset($_GET['action']) && $_GET['action'] == 'nofile') {
          echo "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
            <i class='fas fa-exclamation-triangle'></i> Erreur : nom de fichier vide
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
        }

        if(isset($_GET['action']) && $_GET['action'] == 'file_exists') {
          echo "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
            <i class='fas fa-exclamation-triangle'></i> Le fichier existe déjà
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
        }

        if(isset($_GET['action']) && $_GET['action'] == 'norep') {
          echo "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
            <i class='fas fa-exclamation-triangle'></i> Erreur : nom de répertoire vide
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
        }

        if(isset($_GET['action']) && $_GET['action'] == 'rep_exists') {
          echo "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
            <i class='fas fa-exclamation-triangle'></i> Le répertoire existe déjà
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
        }

        echo "</div>";
        echo "</div>";

        // créer un fichier
        echo "
        <div class=\"row\">
          <div class=\"col-sm card p-2 m-3\">
            <form action='ajouter.php' method='POST'>
              <div class='form-group'>
                <label for='name'>Créer un nouveau fichier : </label><br>
                <input type='text' class='form-control-sm' name='name' placeholder='Entrez un nom de fichier' size='50'>
                <button onclick=\"return confirm('Êtes-vous certain de vouloir ajouter ce fichier ?')\" type='submit' name='submit' class='btn btn-primary btn-sm'>
                  Envoyer
                  </button>
                  <button class='btn btn-secondary btn-sm' type='reset'>
                    Annuler
                  </button>
              </div>
            </form>
          </div>
        ";

        // créer un répertoire
        echo "
        <div class=\"col-sm card p-2 m-3\">
          <form action='ajouterrep.php' method='POST'>
            <div class='form-group'>
              <label for='name'>Créer un nouveau répertoire : </label><br>
              <input type='text' class='form-control-sm' name='namerep' placeholder='Entrez un nom de répertoire' size='50'>
              <button onclick=\"return confirm('Êtes-vous certain de vouloir créer ce répertoire ?')\" type='submit' name='submitrep' class='btn btn-primary btn-sm'>
                Envoyer
              </button>
              <button class='btn btn-secondary btn-sm' type='reset'>
                Annuler
              </button>
            </div>
          </form>
        </div>
      </div><!-- //row -->
        ";
        ?>

        <?php
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
            $value = $segment;

            $breadcrumbs[] = '<a href="' . $crumb_path . '">' . $value . '</a>';
        }

        $breadcrumbs[] = ucwords(str_replace('_', ' ', $path['filename']));
        $breadcrumbs   = implode(' > ', $breadcrumbs);
        */

        /* ---- TEST ----*/
        if(!empty($_GET['dir'])) $dir = simplePath($_GET['dir']);
          else $dir = './';

          $opendir = false;
          if(is_dir($dir)) $opendir = opendir($dir);
            if(!$opendir) {
              $dir = './';
              $opendir = opendir('./') or die();
            }

            echo '<div class="bg-info mt-3 text-white px-3 py-2">Chemin : <a class="text-white" href="?dir=./">Root</a> '.$dir.'</div>';

            if(substr($dir, 0, 2) == './') $dir = substr($dir, 2);

            echo '
            <div id="background" class="container">
              <div class="row">
                <div class="col-sm mt-3">
                  <table class="table table-sm mb-3 text-white">
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
            ';

            while(($file = readdir($opendir)) !== false) {

              $size = formatSizeUnits(filesize($dir.$file));
              $date = date("d-m-Y H:i:s", filemtime($dir.$file));
              $owner = fileowner($dir.$file);

              // on recherche le type de fichier
              $finfo = finfo_open(FILEINFO_MIME_TYPE);
              $type = finfo_file($finfo, $dir.$file);

              echo '
                <tr>
                  <td>
              ';

              // on recherche le type de fichier
              $finfo = finfo_open(FILEINFO_MIME_TYPE);
              $type = finfo_file($finfo, $dir.$file);

              // Todo: on peut aussi le faire avec un switch
              if (isset($type)) {
                 if (in_array($type, array("image/png", "image/jpeg", "image/gif"))) {
                   $check = "<i class='far fa-image fa-2x'></i>";
                 }
                 elseif(in_array($type, array("text/plain"))) {
                   $check = "<i class='fas fa-file fa-2x'></i>";
                 }
                 elseif(in_array($type, array("text/x-php"))) {
                   $check = "<i class='fab fa-php fa-2x'></i>";
                 }
                 elseif(in_array($type, array("text/x-js"))) {
                   $check = "<i class='fab fa-js fa-2x'></i>";
                 }
                 else {
                   $check = "<i class='fas fa-file-alt fa-2x'></i>";
                 }
               }

              if(is_file($dir.$file)) {
                echo $check.' <a class="text-white" href="'.$dir.$file.'" title="'.$dir.$file.'">'.$file.'</a><br/>', "\n";
              }
              elseif(is_dir($dir.$file)) {
                echo '<i class="fas fa-folder fa-2x"></i> <a class="text-white" href="?dir='.urlencode($dir.$file).'" title="'.$dir.$file.'">'.$file.'</a><br/>', "\n";
              }
            echo '</td>';

            echo '
            <td class="smalltext">'.$size.'</td>
            <td class="smalltext">'.$type.'</td>
            <td class="smalltext">'.$owner.'</td>
            <td class="smalltext">'.$date.'</td>
            ';

            if(is_file($dir.$file)) {
              if($file != 'ajouter.php' && $file != 'ajouterrep.php' && $file != 'functions.php' && $file != 'index.php' && $file != 'supprimer.php' && $file != 'supprimerrep.php') {
                echo '<td class="lastcol"><a title="Supprimer '.$file.' ?" class="text-white trash" href="supprimer.php?id='.$file.'" onclick="return confirm(\'Êtes-vous certain de vouloir supprimer ce fichier ?\')"><i class="fas fa-trash"></i></a></td>';
              }
              else{
                echo '<td class="lastcol"><i class="fas fa-trash text-muted"></i></td>';
              }
            }
            elseif(is_dir($dir.$file) && $file != '.') {
              echo '<td class="lastcol"><a title="Supprimer le répertoire '.$dir.$file.' ?" class="text-white trash" href="supprimerrep.php?id='.$file.'" onclick="return confirm(\'Êtes-vous certain de vouloir supprimer répertoire ?\')"><i class="fas fa-trash"></i></a></td>';
            }

            echo '</tr>';
          } //while

            echo '</tbody></table>';

            closedir($opendir);


        /*
        $def = "index";
        $dPath = $_SERVER['PHP_SELF'];
        $dChunks = explode("/", $dPath);
        */

        /*if (isset($_POST['selectedfile'])) {
          echo $selectedfile;
        }*/

        /*
        echo('<p class="bg-light px-3 py-2"><a href="/">Accueil</a><span> > </span>');
        for($i=1; $i<count($dChunks); $i++ ){
	         echo('<a href="/');
	         for($j=1; $j<=$i; $j++ ){
		           echo($dChunks[$j]);
		           if($j!=count($dChunks)-1){
                 echo("/");
               }
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
        */
        ?>

        <!--
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><?php echo $breadcrumbs; ?></li>
          </ol>
        </nav>
        -->



      </div>
    </div>
  </div>

<!--
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
    /*
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


          if (is_dir(realpath($item))) {
            echo "
            <form method=\"POST\">
            <tr>
              <td>
                <i class='fas fa-folder-open'></i>
                <input type='hidden' name='selectedfile' value='".realpath($item)."'><a href='".realpath($item)."'>
                <button type='submit' class='btn btn-link'>".$item."</button>
                </a>
              </td>
              <td class='smalltext'>".$size."</td>
              <td class='smalltext'>".$type."</td>
              <td class='smalltext'>".$owner."</td>
              <td class='smalltext'>".$date."</td>
              <td class='lastcol'><a href='supprimerrep.php?id=".$item."' onclick=\"return confirm('Êtes-vous certain de vouloir supprimer ce répertoire ?')\"><i class='fas fa-trash'></i></a></td>
            </tr>
            </form>
            ";
         }
         else {
            echo "
            <tr>
              <td class='firstcol'>".$check."</i> <a class=\"px-3\" href='".$item."'>".$item."</a></td>
              <td class='smalltext'>".$size."</td>
              <td class='smalltext'>".$type."</td>
              <td class='smalltext'>".$owner."</td>
              <td class='smalltext'>".$date."</td>
              <td class='lastcol'><a href='supprimer.php?id=".$item."' onclick=\"return confirm('Êtes-vous certain de vouloir supprimer ce fichier ?')\"><i class='fas fa-trash'></i></a></td>
            </tr>
            ";
         }
      } //for each
      */
    ?>

  </tbody>
</table>

  </div>
</div>
</div>
-->
</div>
<div class="container text-center pb-5">
  <i class="fab fa-creative-commons-pd"></i> Olivier Prieur - Access Code School Nevers (58000) - Juin 2020
</div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>
