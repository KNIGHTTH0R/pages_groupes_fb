<?php
include('config.php');

$token = "";

// Récupération des IDs stockés en BDD dans un table qui stocke unniquement les IDs des groupes
/*

  CREATE TABLE `z_ids_des_groupes_pages` (
  `id` int(11) NOT NULL,
  `id_groupe_page` bigint(55) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

  ALTER TABLE `z_ids_des_groupes_pages`
  ADD PRIMARY KEY (`id`);

*/
$sql     = "SELECT * FROM z_ids_des_groupes_pages";
$result  = mysqli_query($link, $sql);
$tab_ids = array();
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    array_push($tab_ids, $row["id_groupe_page"]);
}

print_r($tab_ids);

// Pour chaque ID
// exemple page ID 1052997051527627
foreach ($tab_ids as $id_page_ou_group) {
    // Effectuer une requete à l'API Graph /page de Facebook
    // GET /v3.2/{page-id}/events HTTP/1.1
    // Host: graph.facebook.com
    // Lien vers la doc : https://developers.facebook.com/docs/graph-api/reference/page/events/

    // Ou bien
    // GET /v3.2/{group-id}/events HTTP/1.1
    // Host: graph.facebook.com

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://graph.facebook.com/v3.2/" . $id_page_ou_group . "/events?access_token=" . $token,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => array()
    ));

    $response = curl_exec($curl);
    $err      = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "Erreur retour du cURL #:" . $err;
    }

    // Récupérer les informations Que Facebook nous renvoie via un JSON organisé : $tab_retour
    // Modifier la date en FRANCAIS
    $tab_retour = json_decode($response, true);
    echo '<pre>';
    print_r($tab_retour);
    echo '</pre>';
    $description = $tab_retour["data"][0]["description"];
    $name        = $tab_retour["data"][0]["name"];
    $id_event    = $tab_retour["data"][0]["id"];
    //setlocale(LC_TIME, "fr_FR");
    $ag_begin    = strftime('%Y-%m-%d', strtotime($tab_retour["data"][0]["start_time"]));
    $ag_h_begin  = strftime('%X', strtotime($tab_retour["data"][0]["start_time"]));
    $ag_end      = strftime('%Y-%m-%d', strtotime($tab_retour["data"][0]["end_time"]));
    $ag_h_end    = strftime('%X', strtotime($tab_retour["data"][0]["end_time"]));
    $end_time    = strftime('%d %B %Y à %R', strtotime($tab_retour["data"][0]["end_time"]));
    // Info toujours présente : place_name
    $place_name  = $tab_retour["data"][0]["place"]["name"];
    // Ces informations ne sont peut être pas toujours présentes
    $city        = $tab_retour["data"][0]["place"]["location"]["city"];
    $country     = $tab_retour["data"][0]["place"]["location"]["country"];
    $latitude    = $tab_retour["data"][0]["place"]["location"]["latitude"];
    $longitude   = $tab_retour["data"][0]["place"]["location"]["longitude"];
    $street      = $tab_retour["data"][0]["place"]["location"]["street"];
    $zip         = $tab_retour["data"][0]["place"]["location"]["zip"];
    if ($tab_retour["data"][0]["place"]["id"] != '') {
        $lieuid = $tab_retour["data"][0]["place"]["id"];
    } else {
        $lieuid = "";
    }


    // Vérifier si cette information existe déja en Base de données dans la table de stockage des events : z_agenda
    // Si oui, ne rien faire
    // Si non, stocker les nouvelles données
    $sql_search    = "SELECT * FROM `z_agenda` WHERE `ag_idfb` = '$id_event' ";
    $result_search = mysqli_query($link, $sql_search);
    $compte        = mysqli_num_rows($result_search);
    if ($compte == 0) {
        // C'est ok, on peut stocker dans la base de dobbées le nouvel évènement
        // Rajouter ici dans cette requete les IDs des catégories, le statut, etc ...

        $sql_insert = "INSERT INTO `z_agenda` (`ag_id`, `ag_name`, `ag_namerewrite`, `ag_metadesc`, `ag_desc`, `ag_begin`, `ag_h_begin`, `ag_end`, `ag_h_end`, `ag_grid`, `ag_lieuid`, `ag_catid`, `ag_statut`, `ag_mav`, `ag_idfb`)
              VALUES ( NULL, '$name', '', '', '$description', '$ag_begin', '$ag_h_begin', '$ag_end', '$ag_h_end', '', '$lieuid', '', '', '', $id_event)";
        echo $sql_insert;
        $result_insert = mysqli_query($link, $sql_insert);

    }


    // Générer le fichier event.json avec les données une fois que ce CRON est terminé
    // Voir le script dans generate_json.php


}
?>
