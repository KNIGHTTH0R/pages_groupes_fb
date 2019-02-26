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
__Remarque : La colonne ag_id doit être PRIMAIRE et vous devez ajouter l'Auto INCREMENT !!! Attention

