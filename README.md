# pages_groupes_fb
Outil de récupération des évènements provenants de pages et de groupes Facebook

## Structure SQL
### Table contenant les IDs des pages et Groupes Facebook
````
CREATE TABLE `z_ids_des_groupes_pages` (
  `id` int(11) NOT NULL,
  `id_groupe_page` bigint(55) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

  ALTER TABLE `z_ids_des_groupes_pages`
  ADD PRIMARY KEY (`id`);
````

### Table contenant les IDs des pages et Groupes Facebook

