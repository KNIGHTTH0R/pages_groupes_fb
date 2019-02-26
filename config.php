<?php
/* A remplacer par vos identifiants */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'group_pages');

/* Se Connecter à MySQL database */
// Ici la variable s'apelle $link, à changer avec un nom que vous souhaitez
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Checker les informations !
if($link === false){
    die("ERREUR: Impossible de se connecter. " . mysqli_connect_error());
}



?>
