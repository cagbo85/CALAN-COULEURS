-- Base de données pour le festival Calan'Couleurs avec traçabilité

-- Suppression des tables si elles existent (ordre important à cause des contraintes)
DROP TABLE IF EXISTS faqs;
DROP TABLE IF EXISTS artistes;
DROP TABLE IF EXISTS users;

-- =================================================================
-- TABLE USERS - Gestion des utilisateurs de l'équipe
-- =================================================================
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(255) NOT NULL COMMENT 'Prénom de la personne',
    lastname VARCHAR(255) NOT NULL COMMENT 'Nom de famille de la personne',
    login VARCHAR(255) NOT NULL COMMENT 'login de la personne',
    email VARCHAR(255) NOT NULL COMMENT 'Email unique',
    email_verified_at TIMESTAMP NULL DEFAULT NULL,
    password VARCHAR(255) NOT NULL COMMENT 'Mot de passe',
    role ENUM('super-admin','admin','editor') NOT NULL DEFAULT 'editor' COMMENT 'Rôles différenciés',
    statut VARCHAR(255) NOT NULL COMMENT 'Statut de la personne au sein de l\'Association',
    actif BOOLEAN NOT NULL DEFAULT 1 COMMENT 'Utilisateur actif/inactif',
    remember_token VARCHAR(100) DEFAULT NULL,
    updated_by INT DEFAULT NULL COMMENT 'ID de lutilisateur qui a modifié',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    updated_at TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date de modification',
    UNIQUE KEY login (login),
    UNIQUE KEY email (email),
    KEY updated_by (updated_by),
    CONSTRAINT users_ibfk_1 FOREIGN KEY (updated_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table des utilisateurs de l\'équipe';

-- =================================================================
-- TABLE ARTISTES - Gestion des artistes du festival
-- =================================================================
CREATE TABLE IF NOT EXISTS artistes (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL COMMENT 'Nom de scène de l\'artiste',
    style VARCHAR(100) DEFAULT NULL COMMENT 'Style de musique de l\'artiste',
    description MEDIUMTEXT DEFAULT NULL COMMENT 'Description/bio de l\'artiste',
    photo VARCHAR(255) DEFAULT NULL COMMENT 'Chemin vers l\'image',
    day ENUM('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche') NOT NULL COMMENT 'Jour de passage',
    begin_date DATETIME NOT NULL COMMENT 'Date et heure exacte du début de la représentation',
    ending_date DATETIME NOT NULL COMMENT 'Date et heure exacte de la fin de la représentation',
    scene ENUM('Extérieur', 'Intérieur') NOT NULL COMMENT 'Type de scène',
    soundcloud_url VARCHAR(500) DEFAULT NULL COMMENT 'Lien SoundCloud',
    spotify_url VARCHAR(500) DEFAULT NULL COMMENT 'Lien Spotify',
    youtube_url VARCHAR(500) DEFAULT NULL COMMENT 'Lien YouTube Music',
    deezer_url VARCHAR(500) DEFAULT NULL COMMENT 'Lien Deezer',
    actif BOOLEAN NOT NULL DEFAULT 1 COMMENT 'Artiste actif/masqué',
    created_by INT DEFAULT NULL COMMENT 'ID utilisateur créateur',
    updated_by INT DEFAULT NULL COMMENT 'ID de lutilisateur qui a modifié',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    updated_at TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date de modification',
    KEY created_by (created_by),
    KEY updated_by (updated_by),
    CONSTRAINT artistes_ibfk_1 FOREIGN KEY (created_by) REFERENCES users (id),
    CONSTRAINT artistes_ibfk_2 FOREIGN KEY (updated_by) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table des artistes du festival';


-- Insertion des artistes pour le vendredi
INSERT INTO artistes (name, style, description, photo, day, begin_date, ending_date, scene, soundcloud_url, spotify_url, youtube_url, deezer_url, actif, created_by, updated_by) VALUES
('Rock 109', 'Reprises rock des années 70 à aujourd’hui', 'Rock 109, c’est un trio étonnant et détonnant qui revisite avec fougue les grands classiques du rock, des années 70 jusqu’à nos jours.\nUn show plein d’énergie pour ouvrir le festival en beauté et faire vibrer le public dès les premiers riffs. Prépare-toi à secouer la tête !', 'img/artists/photos/Photos_artistes/ROCK 109.webp', 'Vendredi', '2025-09-12 20:00:00', '2025-09-12 21:30:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('La Rif et Nos Men', 'Rap-Rock festif et engagé', 'La Rif et Nos Men, c’est une histoire de famille et de musique. Deux frères, Léo et Tonio, bercés par le hip-hop, rejoints par leurs parents musiciens à l’accordéon et à la guitare, pour un cocktail unique de rap-rock festif.\nLeur son mêle des messages engagés (écologie, inégalités) à des textes plus poétiques, portés par une énergie communicative et une complicité sincère.\nUn vrai moment de partage, entre groove, conscience et chaleur humaine.', 'img/artists/photos/Photos_artistes/LA RIF ET NOS MEN.webp', 'Vendredi', '2025-09-12 21:00:00', '2025-09-12 22:30:00', 'Intérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('An\'Om x Vayn', 'Rap & électro mélodique', 'Entre flow précis et ambiance électronique puissante, An’Om x Vayn font exploser les frontières musicales. An’Om livre ses émotions avec justesse pendant que Vayn sublime le tout avec ses productions.\nLe duo, révélé par leur hit "Astronaute", enchaîne les titres forts comme "À mes démons", introspectif et percutant.\nSur scène, leur complicité est palpable : un vrai show énergique et sensible, entre kick, partage et frissons.', 'img/artists/photos/Photos_artistes/AN\'OM X VAYN.webp', 'Vendredi', '2025-09-12 22:30:00', '2025-09-13 00:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Wazy', 'DJ set – hip-hop, afro, house, rap', 'Wazy, artiste plurielle et passionnée, fait vibrer les platines comme les cœurs. Passée par le chant, la batterie, la guitare et le piano, elle propose aujourd’hui un DJ set éclectique mêlant hip-hop, afro, house et rap avec une fluidité rare.\nSon objectif : créer un voyage sonore intense et joyeux, célébrant la diversité et l’unité par la musique.\nUne fin de soirée haute en couleurs, pour danser, sourire et s’élever ensemble jusqu’au bout de la nuit.', 'img/artists/photos/Photos_artistes/WAZY.webp', 'Vendredi', '2025-09-13 00:00:00', '2025-09-13 02:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('AXL R.', 'House, Afro house, Disco house, Techno, Hard techno', 'Figure bien connue de la scène nantaise, AXL R. fait vibrer les platines depuis plus de 12 ans. Des clubs aux festivals, il distille un mix percutant et polyvalent, toujours en phase avec l’ambiance du moment.\nNourri par une passion née sur les dancefloors, il enchaîne aujourd’hui les dates dans les meilleurs spots de la région, avec une signature sonore qui va de la house solaire à la techno brute.\nSur scène, AXL R. transforme la nuit en terrain de jeu électrisant, entre rythmes envoûtants et montées d’adrénaline. Prépare-toi à danser sans pause, jusqu’au dernier battement.', 'img/artists/photos/Photos_artistes/AXL R..webp', 'Vendredi', '2025-09-13 00:30:00', '2025-09-13 02:00:00', 'Intérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Hono', 'Electro House / Généraliste', 'HONO, c’est l’assurance d’un set fédérateur et explosif. À l’aise aussi bien dans l’électro house que dans un registre plus généraliste, il enchaîne les sons qui font danser tous les publics, sans jamais baisser l’intensité.\nEntre gros drops, refrains cultes et beats puissants, HONO transforme la piste en un espace de fête totale, où tout le monde trouve son moment.\nUne closing party XXL, pleine d’énergie, de lights et de good vibes pour finir la nuit en apothéose.', 'img/artists/photos/Photos_artistes/HONO.webp', 'Vendredi', '2025-09-13 02:00:00', '2025-09-13 04:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Dymeister', 'Techno – Acid – Hard Trance', 'Place aux vibrations brutes et sans compromis avec DYMEISTER, architecte sonore des nuits les plus intenses.\nSes sets oscillent entre techno nerveuse, acid hypnotique et hard trance survoltée, propulsant le public dans un univers aussi percutant que transcendant.\nAvec un sens du rythme chirurgical et une énergie sans relâche, DYMEISTER promet un final sous haute tension, taillé pour les noctambules en quête de lâcher-prise total.', 'img/artists/photos/Photos_artistes/DYMEISTER.webp', 'Vendredi', '2025-09-13 02:00:00', '2025-09-13 03:30:00', 'Intérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1);

-- Insertion des artistes pour le samedi
INSERT INTO artistes (name, style, description, photo, day, begin_date, ending_date, scene, soundcloud_url, spotify_url, youtube_url, deezer_url, actif, created_by, updated_by) VALUES
('Youth Collective', 'Reggae Roots & Dub UK – Sound System', 'Né en 2015 autour de la culture sound system nantaise, Youth Collective rassemble six passionnés qui font vibrer les murs avec leur sono artisanale.\nLeur mission : transmettre un message d’unité et de partage, dans la plus pure tradition des sound systems anglais.\nLeur sélection navigue entre reggae roots chaleureux et dub UK dynamique, agrémentée de quelques pépites maison issues de leur propre studio.\nUn moment convivial, puissant et solaire pour bien démarrer la journée.', 'img/artists/photos/Photos_artistes/YOUTH COLLECTIVE.webp', 'Samedi', '2025-09-13 15:00:00', '2025-09-13 17:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Maklos', 'House / Techno – Old School & Underground', 'Maklos est un DJ et producteur qui fait le lien entre house old school et techno underground.\nSon univers mêle rythmes percussifs, énergie brute et progressions hypnotiques, pour des sets qui montent en tension et captivent les corps comme les esprits.\nUn moment taillé pour les puristes comme pour les curieux, à savourer les yeux fermés ou les bras levés.', 'img/artists/photos/Photos_artistes/MAKLOS.webp', 'Samedi', '2025-09-13 17:00:00', '2025-09-13 18:30:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Klö', 'Electro', 'Klö, DJ émergente de la scène locale, fait partie de cette nouvelle génération qui électrise les platines avec style et audace.\nAvec ses mix envoûtants et ses sélections percutantes, elle promet un set qui fait bouger les corps et monte en intensité à mesure que le soleil décline.\nUne vague électro pleine de fraîcheur, à ne pas manquer !', 'img/artists/photos/Photos_artistes/KLÖ.webp', 'Samedi', '2025-09-13 18:30:00', '2025-09-13 19:30:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Kaboum', NULL, NULL, 'img/artists/photos/Photos_artistes/KABOUM.webp', 'Samedi', '2025-09-13 19:30:00', '2025-09-13 21:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('TOM WORRF', NULL, NULL, 'img/artists/photos/Photos_artistes/TOM WORRF.webp', 'Samedi', '2025-09-13 20:30:00', '2025-09-13 22:00:00', 'Intérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('2TH', NULL, NULL, 'img/artists/photos/Photos_artistes/2TH.webp', 'Samedi', '2025-09-13 22:00:00', '2025-09-13 23:30:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Mūne', NULL, NULL, 'img/artists/photos/Photos_artistes/MŪNE.webp', 'Samedi', '2025-09-13 23:30:00', '2025-09-14 02:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Yonex', NULL, NULL, 'img/artists/photos/Photos_artistes/YONEX.webp', 'Samedi', '2025-09-14 00:30:00', '2025-09-14 02:00:00', 'Intérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Leydon', NULL, NULL, 'img/artists/photos/Photos_artistes/LEYDON.webp', 'Samedi', '2025-09-14 02:00:00', '2025-09-14 04:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Tripidium', NULL, NULL, 'img/artists/photos/Photos_artistes/TRIPIDIUM.webp', 'Samedi', '2025-09-14 02:00:00', '2025-09-14 03:30:00', 'Intérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1);

CREATE TABLE IF NOT EXISTS faqs (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    question VARCHAR(500) NOT NULL COMMENT 'Question FAQ',
    answer MEDIUMTEXT NOT NULL COMMENT 'Réponse à la question',
    actif BOOLEAN NOT NULL DEFAULT 1 COMMENT 'FAQ active/masquée',
    ordre INT NOT NULL DEFAULT 0 COMMENT 'Ordre d\'affichage',
    created_by INT DEFAULT NULL COMMENT 'ID utilisateur créateur',
    updated_by INT DEFAULT NULL COMMENT 'ID de lutilisateur qui a modifié',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    updated_at TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date de modification',
    KEY created_by (created_by),
    KEY updated_by (updated_by),
    CONSTRAINT faqs_ibfk_1 FOREIGN KEY (created_by) REFERENCES users(id),
    CONSTRAINT faqs_ibfk_2 FOREIGN KEY (updated_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table des questions fréquentes';

INSERT INTO faqs (question, answer, actif, ordre, created_by, updated_by) VALUES
('Où et quand se déroule le festival ?', 'Rendez-vous à Campbon (44) les 12 & 13 septembre pour deux jours de vibes 🔥', TRUE, 1, 1, 1),
('À quelle heure ouvrent les portes ?', 'On t’accueille dès 19h vendredi et 13h samedi. Viens tôt, repars tard 😉', TRUE, 2, 1, 1),
('Quels sont les styles de musique proposés ?', 'Électro, rock, rap, dub… On mélange les styles pour faire kiffer tout le monde 🎶', TRUE, 3, 1, 1),
('Y a-t-il une billetterie sur place ?', 'Oui, mais sans garantie 😬. Le mieux, c’est de choper ta place en ligne avant que ça parte !', TRUE, 4, 1, 1),
('Y aura-t-il des espaces de restauration ?', 'Évidemment ! Foodtrucks, buvette, de quoi manger, boire et recharger les batteries 🍔🍻', TRUE, 5, 1, 1),
('Pourra-t-on dormir sur place ?', 'Oui carrément ! Le camping est prévu, ramène juste ton matériel et ta bonne humeur 🌙🎪🔥', TRUE, 6, 1, 1);
