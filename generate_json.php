<?php
/* Format des objets dans le JSON :
{
"id" : "",
"start_time" : "",
"end_time" : "",
"band_name" : "",
"place_name" : "",
"description" : ""
}

*/
include ('config.php');

// effectuer une requete sur la table contenant les evenements z_agenda
$sql_search = "SELECT * FROM `z_agenda` ";
$result_search = mysqli_query($link, $sql_search);

// Stocker chaque evenement dans un Array()
$gros_tab = array();

while ($row = mysqli_fetch_array($result_search, MYSQLI_ASSOC))
	{
	$petit_tab_temporaire = array(
		"id" => $row["ag_idfb"],
		"start_time" => $row["ag_begin"],
		"end_time" => $row["ag_end"],
		"band_name" => '',
		"place_name" => '',
		"description" => $row["ag_desc"]
	);
	array_push($gros_tab, $petit_tab_temporaire);
	}

// Tranformer le tableau en JSON
$json = json_encode($gros_tab);

// Créer le fichier et ecrire sur l'hébergement (le dossier contenant events.json doit avoir un CHMOD de 755)
$fp = fopen('events.json', 'w');
fwrite($fp, $json);
fclose($fp);
?>
