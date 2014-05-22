<?php

error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;

if($post)
{
/************************************************************
 * Script realise par Emacs
 * Crée le 19/12/2004
 * Maj : 23/06/2008
 * Licence GNU / GPL
 * webmaster@apprendre-php.com
 * http://www.apprendre-php.com
 * http://www.hugohamon.com
 *
 * Changelog:
 *
 * 2008-06-24 : suppression d'une boucle foreach() inutile
 * qui posait problème. Merci à Clément Robert pour ce bug.
 *
 *************************************************************/
 
/************************************************************
 * Definition des constantes / tableaux et variables
 *************************************************************/
define('MAX_SIZE', 100000);    // Taille max en octets du fichier
define('WIDTH_MAX', 800);    // Largeur max de l'image en pixels
define('HEIGHT_MAX', 800);    // Hauteur max de l'image en pixels
 
if(isset($_POST["profile"])) {
    $dossier = "img\profile\/";
}
else{
$dossier = "img\/";
}


// Constantes
define('TARGET', $dossier);    // Repertoire cible

// Tableaux de donnees
$tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
$infosImg = array();
 
// Variables
$extension = '';
$message = '';
$nomImage = '';
 
/************************************************************
 * Creation du repertoire cible si inexistant
 *************************************************************/
if( !is_dir(TARGET) ) {
  if( !mkdir(TARGET, 0755) ) {
    exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
  }
}
 
/************************************************************
 * Script d'upload
 *************************************************************/

  // On verifie si le champ est rempli
  if( !empty($_FILES['fichier']['name']) )
  {
    // Recuperation de l'extension du fichier
    $extension  = strtolower(pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION));
           
    if ($extension != "jpg")
    {
        $error .= "Seulment sont acceptes fichiers avec l'extension JPG";
        
    }
    else {
    // On verifie l'extension du fichier
        if(in_array(strtolower($extension),$tabExt))
        {
          // On recupere les dimensions du fichier
          $infosImg = getimagesize($_FILES['fichier']['tmp_name']);

          // On verifie le type de l'image
          if($infosImg[2] >= 1 && $infosImg[2] <= 14)
          {
            // On verifie les dimensions et taille de l'image
            if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE))
            {
              // Parcours du tableau d'erreurs
              if(isset($_FILES['fichier']['error']) 
                && UPLOAD_ERR_OK === $_FILES['fichier']['error'])
              {
                // On renomme le fichier
                  if (isset($_SESSION["login"]))
                  {
                      $nomImage = $_SESSION["login"] .'.'. $extension;
                  }
                  else
                  {
                     $nomImage = md5(uniqid()) .'.'. $extension;
                  }

                // Si c'est OK, on teste l'upload
                if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage))
                {

                  $message = 'Upload réussi !  '.TARGET.$nomImage ;
                  $cool = "OK";
                }
                else
                {
                  // Sinon on affiche une erreur systeme
                  $error .= 'Problème lors de l\'upload !';
                }
              }
              else
              {
                $error .= 'Une erreur interne a empêché l\'uplaod de l\'image';
              }
            }
            else
            {
              // Sinon erreur sur les dimensions et taille de l'image
              $error .= 'Erreur dans les dimensions de l\'image !';
            }
          }
          else
          {
            // Sinon erreur sur le type de l'image
            $error .= 'Le fichier à uploader n\'est pas une image !';
          }
        }
        else
        {
          // Sinon on affiche une erreur pour l'extension
          $error .= 'L\'extension du fichier est incorrecte !';
        }
    }
  }
  else
  {
      // Sinon on affiche une erreur pour le champ vide
      $error .= 'Veuillez remplir le formulaire svp !';
  }

  
    if($cool)
    {
        echo '<script language="Javascript">
                <!--
                window.location.reload();
                // -->
                </script>';
    }

    else
    {
    echo '<div class="notification_error">'.$error.'</div>';
    }

}
