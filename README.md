# pages_groupes_fb
Outil de récupération des évènements provenants de pages et de groupes Facebook

## Structure SQL
### Table contenant les IDs des pages et Groupes Facebook : z_ids_des_groupes_pages
````
CREATE TABLE `z_ids_des_groupes_pages` (
  `id` int(11) NOT NULL,
  `id_groupe_page` bigint(55) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

  ALTER TABLE `z_ids_des_groupes_pages`
  ADD PRIMARY KEY (`id`);
````

### Table contenant informations des évènements : z_agenda
````
CREATE TABLE `z_agenda` ( 
`ag_id` int(11) NOT NULL, 
`ag_name` varchar(255) NOT NULL, // NOM EVENEMENT 
`ag_namerewrite` varchar(255) NOT NULL, 
`ag_metadesc` varchar(255) NOT NULL, 
`ag_desc` text NOT NULL, 
`ag_begin` date NOT NULL, 
`ag_h_begin` time NOT NULL, 
`ag_end` date NOT NULL, 
`ag_h_end` time NOT NULL, 
`ag_grid` int(11) NOT NULL, // ID GROUPE DEMUSIQUE 
`ag_lieuid` int(11) NOT NULL, // ID DU LIEU DE L'EVENEMENT 
`ag_catid` int(11) NOT NULL, // CATEGORIE (COncert, trio, boeuf, etc?,...) 
`ag_statut` tinyint(4) NOT NULL, // 0 hors ligne - 1 en ligne 
`ag_mav` tinyint(1) NOT NULL, // 0 false - 1 true 
`ag_idfb` varchar(50) NOT NULL // ID event Facebook 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
````
**Remarque : La colonne ag_id doit être PRIMAIRE et vous devez ajouter l'Auto INCREMENT !!! Attention**

## Configuration des Scripts :
### config.php
Vous devez ici changer uniquement vos identifiants de connexion à votre base de données MySQL

### index.php
Ce fichier vous permet de récupérer les informations des évènements de pages et de groupes et de les stocker dans votre Bdd SQL<br />

Ligne 4 : Vous devez rajouter votre token Facebook<br />
**Remarque : Ce token ne doit pas être temporaire**
1. Pour cela, rendez-vous sur https://developers.facebook.com/tools/explorer/
2. Choisissez votre App en haut à droite
3. Cliquez ensuite sur le petit "I" bleu à côité du token généré
4. Dans le popup cliquez sur "Ouvrir sur l'outil access token"
5. En bas de la page, cliquez sur "Etendre le token d'accès"

### generate_json.php
Ligne 39 : Renseignez l'adresse relative de votre fichier events.json<br />
Par défaut, il doit être placé dans le même dossier que index.php et config.php

### events.json
Format des objets dans le JSON :<br />
````{
"id" : "",
"start_time" : "",
"end_time" : "",
"band_name" : "",
"place_name" : "",
"description" : ""
}````





