-- Base de données pour le festival Calan'Couleurs avec traçabilité
DROP TABLE IF EXISTS cache, cache_locks, migrations, password_reset_tokens, sessions, failed_jobs, jobs, job_batches;

CREATE TABLE IF NOT EXISTS cache (
    key varchar(255) NOT NULL,
    value mediumtext NOT NULL,
    expiration INT NOT NULL,
    PRIMARY KEY (key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS cache_locks (
    `key` VARCHAR(255) NOT NULL,
    owner VARCHAR(255) NOT NULL,
    expiration INT NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS migrations (
    id INT NOT NULL AUTO_INCREMENT,
    migration VARCHAR(255) NOT NULL,
    batch INT NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS password_reset_tokens (
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT current_timestamp(),
    PRIMARY KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) NOT NULL,
    user_id BIGINT(20) DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    PRIMARY KEY (id),
    KEY sessions_user_id_index (user_id),
    KEY sessions_last_activity_index (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS failed_jobs (
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    uuid VARCHAR(255) NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (id),
    UNIQUE KEY failed_jobs_uuid_unique (uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

CREATE TABLE IF NOT EXISTS jobs (
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT(3) UNSIGNED NOT NULL,
    reserved_at INT DEFAULT NULL,
    available_at INT NOT NULL,
    created_at INT NOT NULL,
    PRIMARY KEY (id),
    KEY jobs_queue_index (queue)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS job_batches (
    id VARCHAR(255) NOT NULL,
    name VARCHAR(255) DEFAULT NULL,
    total_jobs int NOT NULL,
    pending_jobs int NOT NULL,
    failed_jobs int NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options MEDIUMTEXT DEFAULT NULL,
    cancelled_at INT DEFAULT NULL,
    created_at INT NOT NULL,
    finished_at INT DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
    reactivation_requested_at TIMESTAMP NULL DEFAULT NULL COMMENT 'Date de demande de réactivation',
    reactivation_requested_by INT DEFAULT NULL COMMENT 'ID de l\'utilisateur qui a demandé la réactivation',
    reactivation_approved_at TIMESTAMP NULL DEFAULT NULL COMMENT 'Date d\'approbation de la réactivation',
    reactivation_approved_by INT DEFAULT NULL COMMENT 'ID de l\'utilisateur qui a approuvé la réactivation',
    remember_token VARCHAR(100) DEFAULT NULL,
    updated_by INT DEFAULT NULL COMMENT 'ID de l\'utilisateur qui a modifié',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    updated_at TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date de modification',
    UNIQUE KEY login (login),
    UNIQUE KEY email (email),
    KEY updated_by (updated_by),
    KEY reactivation_requested_by (reactivation_requested_by),
    KEY reactivation_approved_by (reactivation_approved_by),
    CONSTRAINT users_ibfk_1 FOREIGN KEY (updated_by) REFERENCES users(id),
    CONSTRAINT users_ibfk_2 FOREIGN KEY (reactivation_requested_by) REFERENCES users(id),
    CONSTRAINT users_ibfk_3 FOREIGN KEY (reactivation_approved_by) REFERENCES users(id)
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
    -- actif BOOLEAN NOT NULL DEFAULT 1 COMMENT 'Artiste actif/masqué',
    created_by INT DEFAULT NULL COMMENT 'ID utilisateur créateur',
    updated_by INT DEFAULT NULL COMMENT 'ID de l\'utilisateur qui a modifié',
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
('La Rif et Nos Men', 'Rap-Rock festif et engagé', 'La Rif et Nos Men, c’est une histoire de famille et de musique. Deux frères, Léo et Tonio, bercés par le hip-hop, rejoints par leurs parents musiciens à l’accordéon et à la guitare, pour un cocktail unique de rap-rock festif.\nLeur son mêle des messages engagés (écologie, inégalités) à des textes plus poétiques, portés par une énergie communicative et une complicité sincère.\nUn vrai moment de partage, entre groove, conscience et chaleur humaine.', 'img/artists/photos/Photos_artistes/LA RIF ET NOS MEN.webp', 'Vendredi', '2025-09-12 21:00:00', '2025-09-12 22:30:00', 'Intérieur', 'https://soundcloud.com/toniorina', NULL, 'https://music.youtube.com/channel/UCqyjRgA71R8A0jCuopYEbhA', 'https://www.deezer.com/fr/artist/75987212?host=6419575083&deferredFl=1&fbclid=IwY2xjawKbv1RleHRuA2FlbQIxMABicmlkETFnQ3Z2bGw4Y01qUHZkR0pqAR4748kQhqzZGgjReEhijP9rprGnHfCOnd8X85oZrCj1cUmGD0Vm8DDo8Er-3Q_aem_8FPs1pQIei2j88XaZOqOKw&host=6419575083&deferredFl=1&fbclid=IwY2xjawKbv1RleHRuA2FlbQIxMABicmlkETFnQ3Z2bGw4Y01qUHZkR0pqAR4748kQhqzZGgjReEhijP9rprGnHfCOnd8X85oZrCj1cUmGD0Vm8DDo8Er-3Q_aem_8FPs1pQIei2j88XaZOqOKw', TRUE, 1, 1),
('An\'Om x Vayn', 'Rap & électro mélodique', 'Entre flow précis et ambiance électronique puissante, An’Om x Vayn font exploser les frontières musicales. An’Om livre ses émotions avec justesse pendant que Vayn sublime le tout avec ses productions.\nLe duo, révélé par leur hit "Astronaute", enchaîne les titres forts comme "À mes démons", introspectif et percutant.\nSur scène, leur complicité est palpable : un vrai show énergique et sensible, entre kick, partage et frissons.', 'img/artists/photos/Photos_artistes/AN\'OM X VAYN.webp', 'Vendredi', '2025-09-12 22:30:00', '2025-09-13 00:00:00', 'Extérieur', 'https://soundcloud.com/anomxvayn ', NULL, NULL, NULL, TRUE, 1, 1),
('Wazy', 'DJ set – hip-hop, afro, house, rap', 'Wazy, artiste plurielle et passionnée, fait vibrer les platines comme les cœurs. Passée par le chant, la batterie, la guitare et le piano, elle propose aujourd’hui un DJ set éclectique mêlant hip-hop, afro, house et rap avec une fluidité rare.\nSon objectif : créer un voyage sonore intense et joyeux, célébrant la diversité et l’unité par la musique.\nUne fin de soirée haute en couleurs, pour danser, sourire et s’élever ensemble jusqu’au bout de la nuit.', 'img/artists/photos/Photos_artistes/WAZY.webp', 'Vendredi', '2025-09-13 00:00:00', '2025-09-13 02:00:00', 'Extérieur', 'https://soundcloud.com/user-630239260', NULL, NULL, NULL, TRUE, 1, 1),
('AXL R.', 'House, Afro house, Disco house, Techno, Hard techno', 'Figure bien connue de la scène nantaise, AXL R. fait vibrer les platines depuis plus de 12 ans. Des clubs aux festivals, il distille un mix percutant et polyvalent, toujours en phase avec l’ambiance du moment.\nNourri par une passion née sur les dancefloors, il enchaîne aujourd’hui les dates dans les meilleurs spots de la région, avec une signature sonore qui va de la house solaire à la techno brute.\nSur scène, AXL R. transforme la nuit en terrain de jeu électrisant, entre rythmes envoûtants et montées d’adrénaline. Prépare-toi à danser sans pause, jusqu’au dernier battement.', 'img/artists/photos/Photos_artistes/AXL R..webp', 'Vendredi', '2025-09-13 00:30:00', '2025-09-13 02:00:00', 'Intérieur', 'https://soundcloud.com/dj-axl-r', NULL, NULL, NULL, TRUE, 1, 1),
('Hono', 'Electro House / Généraliste', 'HONO, c’est l’assurance d’un set fédérateur et explosif. À l’aise aussi bien dans l’électro house que dans un registre plus généraliste, il enchaîne les sons qui font danser tous les publics, sans jamais baisser l’intensité.\nEntre gros drops, refrains cultes et beats puissants, HONO transforme la piste en un espace de fête totale, où tout le monde trouve son moment.\nUne closing party XXL, pleine d’énergie, de lights et de good vibes pour finir la nuit en apothéose.', 'img/artists/photos/Photos_artistes/HONO.webp', 'Vendredi', '2025-09-13 02:00:00', '2025-09-13 04:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Dymeister', 'Techno – Acid – Hard Trance', 'Place aux vibrations brutes et sans compromis avec DYMEISTER, architecte sonore des nuits les plus intenses.\nSes sets oscillent entre techno nerveuse, acid hypnotique et hard trance survoltée, propulsant le public dans un univers aussi percutant que transcendant.\nAvec un sens du rythme chirurgical et une énergie sans relâche, DYMEISTER promet un final sous haute tension, taillé pour les noctambules en quête de lâcher-prise total.', 'img/artists/photos/Photos_artistes/DYMEISTER.webp', 'Vendredi', '2025-09-13 02:00:00', '2025-09-13 03:30:00', 'Intérieur', 'https://soundcloud.com/dylan-chevalier-56586261', NULL, NULL, NULL, TRUE, 1, 1);

-- Insertion des artistes pour le samedi
INSERT INTO artistes (name, style, description, photo, day, begin_date, ending_date, scene, soundcloud_url, spotify_url, youtube_url, deezer_url, actif, created_by, updated_by) VALUES
('Youth Collective', 'Reggae Roots & Dub UK – Sound System', 'Né en 2015 autour de la culture sound system nantaise, Youth Collective rassemble six passionnés qui font vibrer les murs avec leur sono artisanale.\nLeur mission : transmettre un message d’unité et de partage, dans la plus pure tradition des sound systems anglais.\nLeur sélection navigue entre reggae roots chaleureux et dub UK dynamique, agrémentée de quelques pépites maison issues de leur propre studio.\nUn moment convivial, puissant et solaire pour bien démarrer la journée.', 'img/artists/photos/Photos_artistes/YOUTH COLLECTIVE.webp', 'Samedi', '2025-09-13 15:00:00', '2025-09-13 17:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Maklos', 'House / Techno – Old School & Underground', 'Maklos est un DJ et producteur qui fait le lien entre house old school et techno underground.\nSon univers mêle rythmes percussifs, énergie brute et progressions hypnotiques, pour des sets qui montent en tension et captivent les corps comme les esprits.\nUn moment taillé pour les puristes comme pour les curieux, à savourer les yeux fermés ou les bras levés.', 'img/artists/photos/Photos_artistes/MAKLOS.webp', 'Samedi', '2025-09-13 17:00:00', '2025-09-13 18:30:00', 'Extérieur', 'https://soundcloud.com/maklosmusic', NULL, 'https://music.youtube.com/channel/UC3oi2p8BmFFb4k3YhkgOdNA', NULL, TRUE, 1, 1),
('Klö', 'Electro', 'Klö, DJ émergente de la scène locale, fait partie de cette nouvelle génération qui électrise les platines avec style et audace.\nAvec ses mix envoûtants et ses sélections percutantes, elle promet un set qui fait bouger les corps et monte en intensité à mesure que le soleil décline.\nUne vague électro pleine de fraîcheur, à ne pas manquer !', 'img/artists/photos/Photos_artistes/KLÖ.webp', 'Samedi', '2025-09-13 18:30:00', '2025-09-13 19:30:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Kaboum', NULL, NULL, 'img/artists/photos/Photos_artistes/KABOUM.webp', 'Samedi', '2025-09-13 19:30:00', '2025-09-13 21:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('TOM WORRF', NULL, NULL, 'img/artists/photos/Photos_artistes/TOM WORRF.webp', 'Samedi', '2025-09-13 20:30:00', '2025-09-13 22:00:00', 'Intérieur', 'https://music.youtube.com/channel/UCdJep-VuS_wqB_aNXEO9VPw', NULL, 'https://music.youtube.com/channel/UCdJep-VuS_wqB_aNXEO9VPw', 'https://www.deezer.com/fr/artist/250327002?host=6419575083&deferredFl=1&fbclid=IwY2xjawKbv1RleHRuA2FlbQIxMABicmlkETFnQ3Z2bGw4Y01qUHZkR0pqAR4748kQhqzZGgjReEhijP9rprGnHfCOnd8X85oZrCj1cUmGD0Vm8DDo8Er-3Q_aem_8FPs1pQIei2j88XaZOqOKw&host=6419575083&deferredFl=1&fbclid=IwY2xjawKbv1RleHRuA2FlbQIxMABicmlkETFnQ3Z2bGw4Y01qUHZkR0pqAR4748kQhqzZGgjReEhijP9rprGnHfCOnd8X85oZrCj1cUmGD0Vm8DDo8Er-3Q_aem_8FPs1pQIei2j88XaZOqOKw', TRUE, 1, 1),
('2TH', NULL, NULL, 'img/artists/photos/Photos_artistes/2TH.webp', 'Samedi', '2025-09-13 22:00:00', '2025-09-13 23:30:00', 'Extérieur', 'https://soundcloud.com/user-86681471', NULL, 'https://music.youtube.com/channel/UCLP2wR6chac-0YlUPRJmb5A', 'https://www.deezer.com/fr/artist/278029?host=6419575083&deferredFl=1&fbclid=IwY2xjawKbv1RleHRuA2FlbQIxMABicmlkETFnQ3Z2bGw4Y01qUHZkR0pqAR4748kQhqzZGgjReEhijP9rprGnHfCOnd8X85oZrCj1cUmGD0Vm8DDo8Er-3Q_aem_8FPs1pQIei2j88XaZOqOKw&host=6419575083&deferredFl=1&fbclid=IwY2xjawKbv1RleHRuA2FlbQIxMABicmlkETFnQ3Z2bGw4Y01qUHZkR0pqAR4748kQhqzZGgjReEhijP9rprGnHfCOnd8X85oZrCj1cUmGD0Vm8DDo8Er-3Q_aem_8FPs1pQIei2j88XaZOqOKw', TRUE, 1, 1),
('Mūne', NULL, NULL, 'img/artists/photos/Photos_artistes/MŪNE.webp', 'Samedi', '2025-09-13 23:30:00', '2025-09-14 02:00:00', 'Extérieur', 'https://soundcloud.com/user-951350425-867779404', NULL, NULL, NULL, TRUE, 1, 1),
('Yonex', NULL, NULL, 'img/artists/photos/Photos_artistes/YONEX.webp', 'Samedi', '2025-09-14 00:30:00', '2025-09-14 02:00:00', 'Intérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Leydon', NULL, NULL, 'img/artists/photos/Photos_artistes/LEYDON.webp', 'Samedi', '2025-09-14 02:00:00', '2025-09-14 04:00:00', 'Extérieur', NULL, NULL, NULL, 'https://www.deezer.com/fr/artist/9308144?host=6419575083&deferredFl=1&fbclid=IwY2xjawKbv1RleHRuA2FlbQIxMABicmlkETFnQ3Z2bGw4Y01qUHZkR0pqAR4748kQhqzZGgjReEhijP9rprGnHfCOnd8X85oZrCj1cUmGD0Vm8DDo8Er-3Q_aem_8FPs1pQIei2j88XaZOqOKw&host=6419575083&deferredFl=1&fbclid=IwY2xjawKbv1RleHRuA2FlbQIxMABicmlkETFnQ3Z2bGw4Y01qUHZkR0pqAR4748kQhqzZGgjReEhijP9rprGnHfCOnd8X85oZrCj1cUmGD0Vm8DDo8Er-3Q_aem_8FPs1pQIei2j88XaZOqOKw', TRUE, 1, 1),
('Tripidium', NULL, NULL, 'img/artists/photos/Photos_artistes/TRIPIDIUM.webp', 'Samedi', '2025-09-14 02:00:00', '2025-09-14 03:30:00', 'Intérieur', 'https://soundcloud.com/iav-498336354', NULL, NULL, NULL, TRUE, 1, 1);

CREATE TABLE IF NOT EXISTS faqs (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    question VARCHAR(500) NOT NULL COMMENT 'Question FAQ',
    answer MEDIUMTEXT NOT NULL COMMENT 'Réponse à la question',
    actif BOOLEAN NOT NULL DEFAULT 1 COMMENT 'FAQ active/masquée',
    ordre INT NOT NULL DEFAULT 0 COMMENT 'Ordre d\'affichage',
    created_by INT DEFAULT NULL COMMENT 'ID utilisateur créateur',
    updated_by INT DEFAULT NULL COMMENT 'ID de l\'utilisateur qui a modifié',
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

CREATE TABLE IF NOT EXISTS stands (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL COMMENT 'Nom du stand ou de la boutique',
    description TEXT DEFAULT NULL COMMENT 'Description courte',
    photo VARCHAR(255) DEFAULT NULL COMMENT 'Chemin vers l\'image',
    type ENUM('boutique', 'foodtruck', 'tatouage', 'autre') NOT NULL COMMENT 'Catégorie du stand',
    instagram_url VARCHAR(255) DEFAULT NULL COMMENT 'Lien Instagram',
    facebook_url VARCHAR(255) DEFAULT NULL COMMENT 'Lien Facebook',
    website_url VARCHAR(255) DEFAULT NULL COMMENT 'Site web officiel',
    other_link VARCHAR(255) DEFAULT NULL COMMENT 'Autre lien (TikTok, etc.)',
    -- actif BOOLEAN NOT NULL DEFAULT 1 COMMENT 'Stand affiché ou non',
    ordre INT NOT NULL DEFAULT 0 COMMENT 'Ordre d\'affichage',
    -- year YEAR DEFAULT NULL COMMENT 'Année du festival (pour gérer les éditions)',
    created_by INT DEFAULT NULL COMMENT 'ID utilisateur créateur',
    updated_by INT DEFAULT NULL COMMENT 'ID de l\'utilisateur qui a modifié',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    updated_at TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date de modification',
    KEY created_by (created_by),
    KEY updated_by (updated_by),
    CONSTRAINT stands_ibfk_1 FOREIGN KEY (created_by) REFERENCES users(id),
    CONSTRAINT stands_ibfk_2 FOREIGN KEY (updated_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Stands et exposants du festival';

INSERT INTO stands (name, description, photo, type, instagram_url, website_url, actif, ordre, year)
VALUES
('Calan\'Boutique', 'Collection officielle Calan’Couleurs : t-shirts, sweats et accessoires exclusifs.', 'img/surplace/Calan\'Boutique.webp', 'boutique', NULL, NULL, 1, 1, 2025),
('Atelier Solle', 'Créatrice de vêtements et accessoires en upcycling, uniques et stylés.', 'img/surplace/Atelier Solle.webp', 'boutique', 'https://www.instagram.com/atelier_solle/', NULL, 1, 2, 2025),
('So\'Galettes', 'Je vous propose des galettes et crêpes garnies traditionnelles ou originales, pour un goût authentique de la Bretagne.', 'img/surplace/So\'Galettes.webp', 'foodtruck', 'https://www.instagram.com/sogalettes/', NULL, 1, 3, 2025),
('Sylvain Tacos et Burgers', 'Tacos garnis de viandes juteuses, burgers généreux, paninis grillés, une sélection de snacks et de petites bouchées pour les petites faims.', 'img/surplace/Sylvain Tacos et Burgers.webp', 'foodtruck', 'https://www.instagram.com/sylvain_cart_/', NULL, 1, 4, 2025),
('Ocelypse tattoo', 'Propose des flashs exclusifs ou des tatouages éphémères pour tester l\'expérience.', 'img/surplace/Ocelypse tattoo.webp', 'tatouage', 'https://www.instagram.com/ocelypse_tattoo/', NULL, 1, 5, 2025),
('Les Dauphinelles Tattoo', 'Proposent des flashs exclusifs ou des tatouages éphémères pour tester l\'expérience.', 'img/surplace/Les Dauphinelles Tattoo.webp', 'tatouage', 'https://www.instagram.com/lesdauphinelles_tattoo/', NULL, 1, 6, 2025),
('Stand Prévention & Sécurité', 'Sensibiliser tout en s\'amusant ! Infos, jeux et conseils pour faire la fête en toute sécurité, avec le sourire et les bons réflexes.', 'img/surplace/Stand Prévention & Sécurité.webp', 'autre', NULL, NULL, 1, 7, 2025);

CREATE TABLE IF NOT EXISTS partenaires (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL COMMENT 'Nom du partenaire',
    description TEXT DEFAULT NULL COMMENT 'Description du partenaire',
    logo VARCHAR(255) DEFAULT NULL COMMENT 'Chemin vers l\'image',
    photo VARCHAR(255) DEFAULT NULL COMMENT 'Photo du partenaire',
    site_url VARCHAR(255) DEFAULT NULL COMMENT 'Lien vers le site du partenaire',
    instagram_url VARCHAR(255) DEFAULT NULL COMMENT 'Lien Instagram',
    facebook_url VARCHAR(255) DEFAULT NULL COMMENT 'Lien Facebook',
    linkedin_url VARCHAR(255) DEFAULT NULL COMMENT 'Lien LinkedIn',
    autre_url VARCHAR(255) DEFAULT NULL COMMENT 'Autre lien',
    phone VARCHAR(20) DEFAULT NULL COMMENT 'Numéro de téléphone',
    adresse VARCHAR(255) DEFAULT NULL COMMENT 'Adresse complète (numéro et rue)',
    ville VARCHAR(100) DEFAULT NULL COMMENT 'Ville',
    departement VARCHAR(100) DEFAULT NULL COMMENT 'Département ou région',
    code_postal VARCHAR(20) DEFAULT NULL COMMENT 'Code postal',
    pays VARCHAR(100) DEFAULT NULL COMMENT 'Pays',
    latitude DECIMAL(10,8) DEFAULT NULL COMMENT 'Latitude',
    longitude DECIMAL(11,8) DEFAULT NULL COMMENT 'Longitude',
    -- actif BOOLEAN NOT NULL DEFAULT 1 COMMENT 'Partenaire actif',
    ordre INT NOT NULL DEFAULT 0 COMMENT 'Ordre d\'affichage',
    -- annee YEAR DEFAULT NULL COMMENT 'Année de partenariat',
    created_by INT DEFAULT NULL COMMENT 'ID utilisateur créateur',
    updated_by INT DEFAULT NULL COMMENT 'ID de l\'utilisateur qui a modifié',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    updated_at TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date de modification',
    KEY created_by (created_by),
    KEY updated_by (updated_by),
    CONSTRAINT partenaires_ibfk_1 FOREIGN KEY (created_by) REFERENCES users(id),
    CONSTRAINT partenaires_ibfk_2 FOREIGN KEY (updated_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Partenaires du festival';

INSERT INTO partenaires (name, description, adresse, ville, code_postal, pays, latitude, longitude, phone, instagram_url, facebook_url, linkedin_url, site_url, actif, ordre, annee)
VALUES
('Le Grand Lunetier', 'Magasin de lunettes et lunettes de soleil', '1 Rue de Nantes', 'Pontchâteau', '44160', 'France', 47.437198, -2.089572, '02 40 88 14 66', 'https://www.instagram.com/legrandlunetier/?hl=fr', 'https://www.facebook.com/LGLPontchateau/?locale=fr_FR', NULL, NULL, 1, 1, 2025),
('Merzhin Production', 'Prestataire évènementiel', '68 Rue de la Gare', 'Saint-Gildas-des-Bois', '44530', 'France', 47.516899, -2.043508, '07 81 63 00 64', NULL, 'https://m.facebook.com/p/Merzhin-Production-61554676089339/', NULL, NULL, 1, 2, 2025),
('Paul & Joseph', 'Cave & Bar', 'ZAC de la Colleraye', 'Savenay', '44260', 'France', 47.374066, -1.935305, '02 40 69 09 56', NULL, 'https://www.facebook.com/photo.php?fbid=1587669938053267&id=226807257472882&set=a.248854148601526&locale=fr_FR', 'https://fr.linkedin.com/company/paul-et-joseph', 'https://www.pauletjoseph.fr/', 1, 3, 2025),
('Judic Mécanique Automobiles', 'Mécanique automobile', '29 La Mercerie', 'Campbon', '44750', 'France', 47.429946, -1.997097, '02 40 33 57 31', NULL, NULL, NULL, NULL, 1, 4, 2025),
('Aimantik', 'Bijoux Switchables Pour Homme', NULL, 'La Baule', NULL, 'France', NULL, NULL, NULL, 'https://www.instagram.com/aimantik/', NULL, NULL, NULL, 1, 5, 2025),
('JGM Evenements', 'Prestataire technique : son, régie, logistique & distribution électrique', '68 rue de la gare, La Croix Daniel ZA', 'Saint-Gildas-des-Bois', '44530', 'France', NULL, NULL, '02 40 13 85 85', 'https://www.instagram.com/jgmevent/', 'https://www.facebook.com/JGMEvenements/', 'https://fr.linkedin.com/company/jgmevent', NULL, 1, 6, 2025),
('Entreprise Violin Peinture', 'Peintre', '2 Rue de Saint-Nazaire', 'Campbon', '44750', 'France', 47.413889, -1.972212, '02 40 56 51 51', 'https://www.instagram.com/entviolinsarl/', 'https://www.facebook.com/EntrepriseVIOLINSarl/', NULL, NULL, 1, 7, 2025),
('NH multiservices', 'Plomberies & Electricité', NULL, 'Blain', NULL, 'France', NULL, NULL, '06 86 47 71 65', NULL, NULL, NULL, NULL, 1, 8, 2025),
('Utile', 'Supermarché', 'Rue des Musiciens', 'Malville', '44260', 'France', 47.35917, -1.861754, '02 40 56 08 96', NULL, 'https://www.facebook.com/utilemalvile44/?locale=fr_FR', NULL, NULL, 1, 9, 2025),
('Thélem Assurance (PontChâteau)', 'Assurances', '26 Rue Sainte-Catherine', 'Pontchâteau', '44160', 'France', 47.435649, -2.09018, '02 51 10 78 39', NULL, 'https://www.facebook.com/thelem.assurances/?locale=fr_FR', 'https://fr.linkedin.com/company/thelem-assurances', NULL, 1, 10, 2025);

-- CREATE TABLE IF NOT EXISTS benevoles (
--     id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
--     firstname VARCHAR(255) NOT NULL COMMENT 'Prénom de la personne',
--     lastname VARCHAR(255) NOT NULL COMMENT 'Nom de famille de la personne',
--     email VARCHAR(255) NOT NULL COMMENT 'Email unique',
--     mobile VARCHAR(20) DEFAULT NULL COMMENT 'Numéro de téléphone',
--     age INT DEFAULT NULL COMMENT 'Âge de la personne',
--     motivation TEXT DEFAULT NULL COMMENT 'Motivation pour devenir bénévole',
--     disponibilites VARCHAR(255) DEFAULT NULL COMMENT 'Disponibilités (dates et créneaux horaires)',
--     experience TEXT DEFAULT NULL COMMENT 'Expérience antérieure',
--     statut ENUM('nouveau', 'contacte', 'valide', 'refuse') DEFAULT 'nouveau',
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création',
--     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date de modification',
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Table des demandes de bénévolat du festival';

CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL COMMENT 'Titre du produit',
    slug VARCHAR(255) NOT NULL COMMENT 'Slug URL du produit',
    description TEXT DEFAULT NULL COMMENT 'Description détaillée du produit',
    detailed_description MEDIUMTEXT DEFAULT NULL COMMENT 'Description longue du produit',
    price DECIMAL(10,2) NOT NULL COMMENT 'Prix en euros',
    old_price DECIMAL(10,2) DEFAULT NULL COMMENT 'Ancien prix pour les promotions',
    is_featured BOOLEAN NOT NULL DEFAULT 0 COMMENT 'Produit mis en avant sur la page d\'accueil',
    image VARCHAR(255) DEFAULT NULL COMMENT 'Chemin vers l\'image principale du produit',
    category ENUM('vetements', 'accessoires', 'goodies') NOT NULL COMMENT 'Catégorie du produit',
    badge ENUM('t-shirt', 'pull', 'accessoire') DEFAULT NULL COMMENT 'Badge du produit',
    actif BOOLEAN NOT NULL DEFAULT 1 COMMENT 'Produit actif ou non',
    created_by INT DEFAULT NULL COMMENT 'ID utilisateur créateur',
    updated_by INT DEFAULT NULL COMMENT 'ID de l\'utilisateur qui a modifié',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    updated_at TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date de modification',
    KEY created_by (created_by),
    KEY updated_by (updated_by),
    CONSTRAINT produits_ibfk_1 FOREIGN KEY (created_by) REFERENCES users(id),
    CONSTRAINT produits_ibfk_2 FOREIGN KEY (updated_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Produits du de la boutique en ligne';

CREATE TABLE IF NOT EXISTS products_variants (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    product_id INT NOT NULL COMMENT 'ID du produit parent',
    sku VARCHAR(100) DEFAULT NULL COMMENT 'Référence SKU unique pour cette variante',
    size_id INT DEFAULT NULL COMMENT 'ID de la taille',
    color_id INT DEFAULT NULL COMMENT 'ID de la couleur',
    quantity INT NOT NULL DEFAULT 0 COMMENT 'Quantité en stock pour cette variante',
    image VARCHAR(255) DEFAULT NULL COMMENT 'Chemin vers l\'image spécifique à cette variante (ex: couleur)',
    created_by INT DEFAULT NULL COMMENT 'ID utilisateur créateur',
    updated_by INT DEFAULT NULL COMMENT 'ID de l\'utilisateur qui a modifié',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    updated_at TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date de modification',
    KEY created_by (created_by),
    KEY updated_by (updated_by),
    CONSTRAINT products_variants_ibfk_1 FOREIGN KEY (created_by) REFERENCES users(id),
    CONSTRAINT products_variants_ibfk_2 FOREIGN KEY (updated_by) REFERENCES users(id),
    CONSTRAINT products_variants_ibfk_3 FOREIGN KEY (product_id) REFERENCES products(id),
    CONSTRAINT products_variants_ibfk_4 FOREIGN KEY (size_id) REFERENCES sizes(id),
    CONSTRAINT products_variants_ibfk_5 FOREIGN KEY (color_id) REFERENCES colors(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Variantes des produits (taille, couleur, etc.)';

CREATE TABLE IF NOT EXISTS products_images (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    product_id INT DEFAULT NULL COMMENT 'ID du produit parent',
    variant_id INT DEFAULT NULL COMMENT 'ID de la variante (optionnel)',
    image VARCHAR(255) NOT NULL COMMENT 'Chemin vers l\'image du produit ou de la variante',
    ordre INT NOT NULL DEFAULT 0 COMMENT 'Ordre d\'affichage des images',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    updated_at TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date de modification',
    CONSTRAINT products_images_ibfk_1 FOREIGN KEY (product_id) REFERENCES products(id),
    CONSTRAINT products_images_ibfk_2 FOREIGN KEY (variant_id) REFERENCES products_variants(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Images supplémentaires pour les produits et variantes';

CREATE TABLE IF NOT EXISTS sizes (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    label VARCHAR(10) NOT NULL UNIQUE COMMENT 'Libellé de la taille (XS, S, M, L, XL, XXL)',
    description VARCHAR(255) DEFAULT NULL COMMENT 'Description optionnelle de la taille',
    ordre INT NOT NULL DEFAULT 0 COMMENT 'Ordre d\'affichage',
    created_by INT DEFAULT NULL COMMENT 'ID utilisateur créateur',
    updated_by INT DEFAULT NULL COMMENT 'ID de l\'utilisateur qui a modifié',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    updated_at TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date de modification',
    KEY created_by (created_by),
    KEY updated_by (updated_by),
    CONSTRAINT sizes_ibfk_1 FOREIGN KEY (created_by) REFERENCES users(id),
    CONSTRAINT sizes_ibfk_2 FOREIGN KEY (updated_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tailles disponibles pour les produits';

CREATE TABLE IF NOT EXISTS colors (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE COMMENT 'Nom de la couleur (ex: Rouge, Bleu, Vert)',
    hex_code VARCHAR(7) DEFAULT NULL COMMENT 'Code hexadécimal de la couleur (ex: #FF5733)',
    ordre INT NOT NULL DEFAULT 0 COMMENT 'Ordre d\'affichage',
    created_by INT DEFAULT NULL COMMENT 'ID utilisateur créateur',
    updated_by INT DEFAULT NULL COMMENT 'ID de l\'utilisateur qui a modifié',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    updated_at TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date de modification',
    KEY created_by (created_by),
    KEY updated_by (updated_by),
    CONSTRAINT colors_ibfk_1 FOREIGN KEY (created_by) REFERENCES users(id),
    CONSTRAINT colors_ibfk_2 FOREIGN KEY (updated_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Couleurs disponibles pour les produits';

CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL COMMENT 'Email du client',
    firstname VARCHAR(255) NOT NULL COMMENT 'Prénom du client',
    lastname VARCHAR(255) NOT NULL COMMENT 'Nom de famille du client',
    adresse VARCHAR(255) DEFAULT NULL COMMENT 'Adresse complète (numéro et rue)',
    ville VARCHAR(100) DEFAULT NULL COMMENT 'Ville',
    departement VARCHAR(100) DEFAULT NULL COMMENT 'Département ou région',
    code_postal VARCHAR(20) DEFAULT NULL COMMENT 'Code postal',
    pays VARCHAR(100) DEFAULT NULL COMMENT 'Pays',
    total_amount DECIMAL(10,2) NOT NULL COMMENT 'Montant total de la commande en euros',
    helloasso_id VARCHAR(100) DEFAULT NULL COMMENT 'ID de la commande HelloAsso',
    payment_status VARCHAR(255) DEFAULT NULL COMMENT 'Statut du paiement',
    cashout_state VARCHAR(255) DEFAULT NULL COMMENT 'État du versement',
    helloasso_payment_id VARCHAR(100) DEFAULT NULL COMMENT 'ID du paiement HelloAsso',
    paid_at TIMESTAMP NULL DEFAULT NULL COMMENT 'Date et heure du paiement',
    payment_metadata JSON DEFAULT NULL COMMENT 'Métadonnées du paiement (stockées en JSON)',
    token VARCHAR(255) NOT NULL COMMENT 'Token unique pour accéder à la commande',
    stock_decremented BOOLEAN NOT NULL DEFAULT 0 COMMENT 'Indique si le stock a été décrémenté pour cette commande',
    status ENUM('pending', 'paid', 'shipped', 'delivered', 'cancelled', 'refunded') NOT NULL DEFAULT 'pending' COMMENT 'Statut de la commande',
    updated_by INT DEFAULT NULL COMMENT 'ID de l\'utilisateur qui a modifié',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    updated_at TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date de modification',
    KEY updated_by (updated_by),
    CONSTRAINT orders_ibfk_1 FOREIGN KEY (updated_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Commandes passées sur la boutique en ligne';

CREATE TABLE IF NOT EXISTS order_items (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    order_id INT NOT NULL COMMENT 'ID de la commande',
    product_id INT NOT NULL COMMENT 'ID du produit',
    variant_id INT DEFAULT NULL COMMENT 'ID de la variante du produit (taille, couleur, etc.)',
    quantity INT NOT NULL DEFAULT 1 COMMENT 'Quantité commandée',
    unit_price DECIMAL(10,2) NOT NULL COMMENT 'Prix unitaire au moment de la commande',
    updated_by INT DEFAULT NULL COMMENT 'ID de l\'utilisateur qui a modifié',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    updated_at TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date de modification',
    KEY updated_by (updated_by),
    CONSTRAINT order_items_ibfk_1 FOREIGN KEY (order_id) REFERENCES orders(id),
    CONSTRAINT order_items_ibfk_2 FOREIGN KEY (product_id) REFERENCES products(id),
    CONSTRAINT order_items_ibfk_3 FOREIGN KEY (variant_id) REFERENCES products_variants(id),
    CONSTRAINT order_items_ibfk_4 FOREIGN KEY (updated_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Articles dans les commandes';

CREATE TABLE IF NOT EXISTS shipments (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    order_id INT NOT NULL COMMENT 'ID de la commande',
    tracking_number VARCHAR(255) DEFAULT NULL COMMENT 'Numéro de suivi du colis',
    carrier VARCHAR(100) DEFAULT NULL COMMENT 'Transporteur',
    shipped_at TIMESTAMP NULL DEFAULT NULL COMMENT 'Date et heure d\'expédition',
    delivered_at TIMESTAMP NULL DEFAULT NULL COMMENT 'Date et heure de livraison',
    status ENUM('in preparation', 'shipped', 'delivered', 'returned') NOT NULL DEFAULT 'in preparation' COMMENT 'Statut d\'expédition',
    created_by INT DEFAULT NULL COMMENT 'ID utilisateur créateur',
    updated_by INT DEFAULT NULL COMMENT 'ID de l\'utilisateur qui a modifié',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    updated_at TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date de modification',
    KEY created_by (created_by),
    KEY updated_by (updated_by),
    CONSTRAINT shipments_ibfk_1 FOREIGN KEY (order_id) REFERENCES orders(id),
    CONSTRAINT shipments_ibfk_2 FOREIGN KEY (created_by) REFERENCES users(id),
    CONSTRAINT shipments_ibfk_3 FOREIGN KEY (updated_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Expéditions des commandes';

CREATE TABLE IF NOT EXISTS editions (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    year YEAR NOT NULL UNIQUE COMMENT 'Année de l\'édition',
    name VARCHAR(255) DEFAULT NULL COMMENT 'Nom de l\'édition',
    begin_date DATETIME NOT NULL COMMENT 'Date et heure exacte de l\'ouverture des portes de l\'édition',
    ending_date DATETIME NOT NULL COMMENT 'Date et heure exacte de la fermeture des portes de l\'édition',
    actif BOOLEAN NOT NULL DEFAULT 1 COMMENT 'Édition actif/inactif',
    created_by INT DEFAULT NULL COMMENT 'ID utilisateur créateur',
    updated_by INT DEFAULT NULL COMMENT 'ID de l\'utilisateur qui a modifié',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    updated_at TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date de modification',
    KEY created_by (created_by),
    KEY updated_by (updated_by),
    CONSTRAINT editions_ibfk_1 FOREIGN KEY (created_by) REFERENCES users(id),
    CONSTRAINT editions_ibfk_2 FOREIGN KEY (updated_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Éditions du festival';

CREATE TABLE IF NOT EXISTS edition_artistes (
    edition_id INT NOT NULL,
    artiste_id INT NOT NULL,
    actif BOOLEAN NOT NULL DEFAULT 1 COMMENT 'Artiste actif/masqué',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    PRIMARY KEY (edition_id, artiste_id),
    CONSTRAINT edition_artistes_ibfk_1 FOREIGN KEY (edition_id) REFERENCES editions(id),
    CONSTRAINT edition_artistes_ibfk_2 FOREIGN KEY (artiste_id) REFERENCES artistes(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Association entre les éditions et les artistes';

CREATE TABLE IF NOT EXISTS edition_stands (
    edition_id INT NOT NULL,
    stand_id INT NOT NULL,
    actif BOOLEAN NOT NULL DEFAULT 1 COMMENT 'Stand actif/masqué',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    PRIMARY KEY (edition_id, stand_id),
    CONSTRAINT edition_stands_ibfk_1 FOREIGN KEY (edition_id) REFERENCES editions(id),
    CONSTRAINT edition_stands_ibfk_2 FOREIGN KEY (stand_id) REFERENCES stands(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Association entre les éditions et les stands';

CREATE TABLE IF NOT EXISTS edition_partenaires (
    edition_id INT NOT NULL,
    partenaire_id INT NOT NULL,
    actif BOOLEAN NOT NULL DEFAULT 1 COMMENT 'Partenaire actif/masqué',
    created_at TIMESTAMP NULL DEFAULT current_timestamp() COMMENT 'Date de création',
    PRIMARY KEY (edition_id, partenaire_id),
    CONSTRAINT edition_partenaires_ibfk_1 FOREIGN KEY (edition_id) REFERENCES editions(id),
    CONSTRAINT edition_partenaires_ibfk_2 FOREIGN KEY (partenaire_id) REFERENCES partenaires(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Association entre les éditions et les partenaires';

INSERT INTO editions (year, name, begin_date, ending_date, created_by, updated_by)
VALUES (2025, 'Calan\'Couleurs 2K25', '2025-09-12 19:00:00', '2025-09-14 05:00:00', 1, 1);
