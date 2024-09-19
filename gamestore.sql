-- Structure de la table `game`

DROP TABLE IF EXISTS `game`;
CREATE TABLE IF NOT EXISTS `game` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `pegi` int NOT NULL,
  `genre` json NOT NULL,
  `quantity` int NOT NULL,
  `plateforme` json NOT NULL,
  `promotion` int NOT NULL,
  `release_date` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Déchargement des données de la table `game`


INSERT INTO `game` (`id`, `name`, `description`, `price`, `created_at`, `updated_at`, `pegi`, `genre`, `quantity`, `plateforme`, `promotion`, `release_date`) VALUES
(5, 'Monster Hunter Wilds', 'Monster Hunter Wilds est un futur jeu vidéo type action-RPG développé et publié par Capcom.', 69.99, '2024-09-11 10:01:08', NULL, 16, '[\"RPG\", \"Action\"]', 1000, '[\"Playstation\", \"PC\", \"Xbox\"]', 0, '2025'),
(8, 'Légendes Pokémon : Arceus', 'Légendes Pokémon : Arceus est un jeu vidéo de rôle de la série Pokémon développé par Game Freak et édité par The Pokémon Company et Nintendo.', 19.99, '2024-09-12 22:39:15', NULL, 12, '[\"RPG, Aventure\"]', 100, '[\"Nintendo\"]', 0, '06/04/1999'),
(9, 'Civilization VI', 'Sid Meier\'s Civilization VI est un jeu vidéo de stratégie au tour par tour de type 4X et le sixième opus de la série Civilization, développé par Firaxis Games et édité par 2K Games.', 59.99, '2024-09-12 22:40:59', NULL, 8, '[\"Stratégie, 4X\"]', 100, '[\"PC\", \"Playstation\", \"Nintendo\", \"Xbox\"]', 0, '21/10/2016'),
(10, 'Assassin\'s Creed Shadows', 'Assassin\'s Creed Shadows est un futur jeu vidéo de rôle et d\'action-aventure développé par Ubisoft Québec et édité par Ubisoft.', 69.99, '2024-09-15 10:44:06', NULL, 18, '[\"RPG\", \"Action\", \"Aventure\", \"Plates-formes\"]', 100, '[\"Playstation\", \"Xbox\", \"PC\"]', 0, '12/11/2024'),
(11, 'Age of Empire IV', 'Age of Empires IV est un jeu vidéo de stratégie en temps réel développé par Relic Entertainment et édité par Xbox Game Studios.', 39.99, '2024-09-15 10:46:31', NULL, 18, '[\"Stratégie\", \"4X\"]', 100, '[\"Xbox\", \"PC\"]', 10, '28/10/2021'),
(13, 'Astro bot', 'Astro Bot est un jeu de plateforme développé par Team Asobi et publié par Sony Interactive Entertainment.', 69.99, '2024-09-15 10:50:45', NULL, 7, '[\"Plates-formes\", \"Combat\"]', 100, '[\"Playstation\"]', 0, '06/09/2024'),
(14, 'Black Myth: Wukong', 'Black Myth: Wukong est un jeu vidéo de type action-RPG créé par le studio indépendant chinois Game Science.', 69.99, '2024-09-15 10:53:24', NULL, 16, '[\"Aventure\", \"Combat\", \"RPG\", \"Action\"]', 100, '[\"Playstation\", \"Xbox\", \"PC\"]', 5, '20/08/2024'),
(15, 'Call of Duty: Black Ops 6', 'Call of Duty: Black Ops 6 est un futur jeu vidéo de tir à la première personne développé par Treyarch et Raven Software et publié par Activision.', 79.99, '2024-09-15 10:56:19', NULL, 18, '[\"FPS\"]', 100, '[\"Playstation\", \"Xbox\", \"PC\"]', 0, '25/10/2024'),
(16, 'Dragon Age: The Veilguard', 'Dragon Age: The Veilguard, anciennement nommé Dragon Age: Dreadwolf est un futur jeu vidéo de rôle en développement par BioWare qui doit être édité par Electronic Arts.', 69.99, '2024-09-15 11:01:00', NULL, 18, '[\"RPG\", \"Aventure\", \"Combat\"]', 100, '[\"Playstation\", \"Xbox\", \"PC\"]', 0, '31/10/2024'),
(17, 'Elden Ring', 'Elden Ring est un jeu vidéo d\'action-RPG développé par FromSoftware et édité par Bandai Namco Entertainment.', 69.99, '2024-09-15 11:02:59', NULL, 18, '[\"RPG\", \"Aventure\", \"Combat\", \"Action\"]', 100, '[\"Playstation\", \"Xbox\", \"PC\"]', 20, '25/02/2022'),
(18, 'Final Fantasy XVI', 'Final Fantasy XVI est un jeu vidéo de rôle d\'action-aventure développé et édité par Square Enix.', 49.99, '2024-09-15 11:09:38', NULL, 18, '[\"RPG\", \"Aventure\", \"Combat\", \"Action\"]', 100, '[\"Playstation\", \"PC\"]', 10, '22/06/2023'),
(19, 'Ghost of Tsushima', 'Ghost of Tsushima est un jeu vidéo d\'action en monde ouvert développé par Sucker Punch et édité par Sony.', 69.99, '2024-09-15 11:11:49', NULL, 18, '[\"RPG\", \"Aventure\", \"Combat\", \"Action\"]', 100, '[\"Playstation\", \"PC\"]', 20, '17/07/2020'),
(20, 'God of War Ragnarök', 'God of War Ragnarök est un jeu vidéo d\'action-aventure développé par SIE Santa Monica Studio et édité par Sony Interactive Entertainment.', 69.99, '2024-09-15 11:15:18', NULL, 18, '[\"RPG\", \"Aventure\", \"Combat\", \"Action\"]', 100, '[\"Playstation\", \"PC\"]', 0, '09/11/2022'),
(21, 'Grand Theft Auto V', 'Grand Theft Auto V est un jeu vidéo d\'action-aventure, développé par Rockstar North et édité par Rockstar Games.', 49.99, '2024-09-15 11:18:22', NULL, 18, '[\"Aventure\", \"Action\"]', 100, '[\"Playstation\", \"PC\", \"Xbox\"]', 10, '17/09/2013'),
(22, 'Halo Infinite', 'Halo Infinite est un jeu vidéo de tir à la première personne développé par 343 Industries et édité par Xbox Game Studios.', 59.99, '2024-09-15 11:30:51', NULL, 16, '[\"Aventure\", \"FPS\"]', 100, '[\"PC\", \"Xbox\"]', 0, '08/12/2021'),
(23, 'Kingdom Come: Deliverance II', 'Kingdom Come: Deliverance II est un jeu vidéo de rôle développé par le studio tchèque Warhorse Studios et édité par Deep Silver.', 79.99, '2024-09-15 11:33:29', NULL, 18, '[\"Aventure\", \"RPG\", \"Combat\"]', 100, '[\"PC\", \"Xbox\", \"Playstation\"]', 0, '11/02/2025'),
(24, 'Mario Kart 8', 'Mario Kart 8 est un jeu vidéo de course développé par Nintendo EAD et édité par Nintendo.', 44.99, '2024-09-15 11:37:28', NULL, 3, '[\"Course\", \"Action\"]', 100, '[\"Nintendo\"]', 0, '29/05/2014'),
(25, 'Minecraft', 'Minecraft est un jeu vidéo de type aventure « bac à sable » développé par le Suédois Markus Persson, alias Notch, puis par la société Mojang Studios.', 29.99, '2024-09-15 11:45:09', NULL, 7, '[\"Survie\", \"Action\", \"Aventure\"]', 100, '[\"Nintendo\", \"PC\", \"Playstation\", \"Xbox\"]', 50, '18/11/2011'),
(26, 'No Man\'s Sky', 'No Man\'s Sky est un jeu vidéo multiplateforme de science-fiction, de type bac-à-sable, développé et édité par Hello Games.', 39.99, '2024-09-15 11:46:58', NULL, 7, '[\"Survie\", \"Action\", \"Aventure\"]', 100, '[\"Nintendo\", \"PC\", \"Playstation\", \"Xbox\"]', 0, '09/08/2016'),
(27, 'Star Wars Outlaws', 'Star Wars Outlaws est un jeu d\'action-aventure développé par Massive Entertainment, édité par Ubisoft et sous licence par Lucasfilm Games.', 69.99, '2024-09-15 11:49:35', NULL, 12, '[\"Action\", \"Aventure\"]', 100, '[\"PC\", \"Playstation\", \"Xbox\"]', 0, '27/08/2024'),
(28, 'The Last of Us Part II', 'The Last of Us Part II est un jeu vidéo d’action-aventure en vue à la troisième personne, de type survival horror et se déroulant dans un monde post-apocalyptique.', 69.99, '2024-09-15 11:52:40', NULL, 18, '[\"Action\", \"Aventure\"]', 100, '[\"PC\", \"Playstation\"]', 5, '19/06/2020'),
(29, 'Zelda: Echoes of Wisdom', 'The Legend of Zelda: Echoes of Wisdom est un jeu d\'action-aventure édité par Nintendo.', 59.99, '2024-09-15 11:54:57', NULL, 7, '[\"Action\", \"Aventure\"]', 100, '[\"Nintendo\"]', 0, '26/09/2024'),
(30, 'Zelda : Tears of the Kingdom', 'The Legend of Zelda: Tears of the Kingdom est un jeu d\'action-aventure développé par Nintendo EPD, assisté par Monolith Soft et édité par Nintendo.', 69.99, '2024-09-15 11:56:13', NULL, 7, '[\"Action\", \"Aventure\"]', 100, '[\"Nintendo\"]', 0, '12/05/2023');


-- Structure de la table `picture`


DROP TABLE IF EXISTS `picture`;
CREATE TABLE IF NOT EXISTS `picture` (
  `id` int NOT NULL AUTO_INCREMENT,
  `game_id` int NOT NULL,
  `title` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_16DB4F89E48FD905` (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Déchargement des données de la table `picture`


INSERT INTO `picture` (`id`, `game_id`, `title`, `created_at`, `updated_at`, `path`) VALUES
(3, 10, '', '2024-09-15 13:28:34', NULL, 'ac-shadows.jpg'),
(4, 5, '', '2024-09-15 22:16:18', NULL, 'mhwilds.jpg'),
(5, 8, '', '2024-09-15 22:17:10', NULL, 'pokemon-arceus.jpg'),
(6, 9, '', '2024-09-15 22:18:44', NULL, 'civ-6.jpg'),
(7, 11, '', '2024-09-15 22:20:00', NULL, 'aoe-4.jpg'),
(8, 13, '', '2024-09-15 22:20:17', NULL, 'astrobot.jpg'),
(9, 14, '', '2024-09-15 22:20:34', NULL, 'Black-myth-wukong.jpg'),
(10, 15, '', '2024-09-15 22:21:02', NULL, 'cod-bo6.jpg'),
(11, 16, '', '2024-09-15 22:21:17', NULL, 'dragon-age-veilguard.jpg'),
(12, 17, '', '2024-09-15 22:21:33', NULL, 'elden-ring.jpg'),
(13, 18, '', '2024-09-15 22:21:49', NULL, 'final-fantasy-xvi.jpg'),
(14, 19, '', '2024-09-15 22:22:14', NULL, 'ghost-of-tsushima.jpg'),
(15, 20, '', '2024-09-15 22:22:29', NULL, 'god-of-war-ragnarok.jpg'),
(16, 21, '', '2024-09-15 22:22:50', NULL, 'GTAV.jpg'),
(17, 22, '', '2024-09-15 22:23:03', NULL, 'halo-infinite.jpg'),
(18, 23, '', '2024-09-15 22:23:19', NULL, 'kingdom-come-deliverance-2.jpg'),
(19, 24, '', '2024-09-15 22:23:44', NULL, 'mario-kart-8.jpg'),
(20, 25, '', '2024-09-15 22:23:57', NULL, 'minecraft.jpg'),
(21, 26, '', '2024-09-15 22:24:10', NULL, 'no-man-s-sky.jpg'),
(22, 27, '', '2024-09-15 22:24:33', NULL, 'star-wars-outlaws.jpg'),
(23, 28, '', '2024-09-15 22:24:49', NULL, 'the-last-of-us-2.jpg'),
(24, 29, '', '2024-09-15 22:25:11', NULL, 'zelda-eow.jpg'),
(25, 30, '', '2024-09-15 22:25:27', NULL, 'zelda-totk.jpg');


-- Structure de la table `user`


DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codepostal` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Déchargement des données de la table `user`


INSERT INTO `user` (`id`, `email`, `roles`, `password`, `created_at`, `updated_at`, `api_token`, `first_name`, `last_name`, `adresse`, `codepostal`, `ville`) VALUES
(12, 'admin@mail.com', '[\"ROLE_ADMIN\"]', '$2y$13$VKZRlgThT/oRz3hMjBfEPeQe8QnQMcRU3gIFPPFAxw94xLKToMJOq', '2024-09-18 13:48:26', NULL, 'af0a394590af8109957241be70a677839e2d534a', '', '', '', '', ''),
(13, 'employe@mail.com', '[\"ROLE_EMPLOYE\"]', '$2y$13$POye7c6MYr2dYHl5JJIb8..0UhUIl/2amIP1y2zqFJn8CtPYgTiDe', '2024-09-18 13:51:47', NULL, '95e6c107f282a3f4552082d6fe8a75dd14060f9f', '', '', '', '', ''),
(14, 'client@mail.com', '[]', '$2y$13$s3CTMyTQ9EpGk3HybyTf/.096ausdQ.JZ4H3xabfpYxjF2cU9Z5fq', '2024-09-18 13:53:35', NULL, '9ac8805aa275db1f4e2c36e4af87a633e6903bc5', 'John', 'Doe', '7 rue d\'Alembert', '33000', 'Bordeaux');
