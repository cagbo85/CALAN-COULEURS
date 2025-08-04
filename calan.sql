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
	login VARCHAR(255) NOT NULL UNIQUE COMMENT 'login de la personne',
    email VARCHAR(255) NOT NULL UNIQUE COMMENT 'Email unique',
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL COMMENT 'Mot de passe',
    role ENUM('admin', 'editor') NOT NULL DEFAULT 'editor' COMMENT 'Rôles différenciés',
	statut VARCHAR(255) NOT NULL COMMENT 'Statut de la personne au sein de l\'Association',
    actif BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Utilisateur actif/inactif',
    remember_token VARCHAR(100) NULL,
	updated_by INT NULL COMMENT 'ID de l\utilisateur qui a modifié',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date de modification',
	FOREIGN KEY (updated_by) REFERENCES users(id)
) COMMENT='Table des utilisateurs de l\'équipe';

INSERT INTO users (firstname, lastname, login, email, password, role, statut, actif, updated_by) VALUES
('Charles', 'Agbo', 'cagbo', 'agbo.charles85@gmail.com', 'P@ssw0rd', 'admin', 'Administrateur', TRUE, NULL);

-- =================================================================
-- TABLE ARTISTES - Gestion des artistes du festival
-- =================================================================
CREATE TABLE IF NOT EXISTS artistes (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL COMMENT 'Nom de scène de l\'artiste',
	style VARCHAR(100) NULL COMMENT 'Style de musique de l\'artiste',
    description TEXT NULL COMMENT 'Description/bio de l\'artiste',
    photo VARCHAR(255) NULL COMMENT 'Chemin vers l\'image',
    day ENUM('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche') NOT NULL COMMENT 'Jour de passage',
    begin_date DATETIME NOT NULL COMMENT 'Date et heure exacte du début de la représentation',
	ending_date DATETIME NOT NULL COMMENT 'Date et heure exacte de la fin de la représentation',
    scene ENUM('Extérieur', 'Intérieur') NOT NULL COMMENT 'Type de scène',
    soundcloud_url VARCHAR(500) NULL COMMENT 'Lien SoundCloud',
    spotify_url VARCHAR(500) NULL COMMENT 'Lien Spotify',
    youtube_url VARCHAR(500) NULL COMMENT 'Lien YouTube Music',
    deezer_url VARCHAR(500) NULL COMMENT 'Lien Deezer',
    actif BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Artiste actif/masqué',
	created_by INT NULL COMMENT 'ID utilisateur créateur',
	updated_by INT NULL COMMENT 'ID de l\utilisateur qui a modifié',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date de modification',
	FOREIGN KEY (created_by) REFERENCES users(id),
	FOREIGN KEY (updated_by) REFERENCES users(id)
) COMMENT='Table des artistes du festival';


-- Insertion des artistes pour le vendredi
INSERT INTO artistes (name, style, description, photo, day, begin_date, ending_date, scene, soundcloud_url, spotify_url, youtube_url, deezer_url, actif, created_by, updated_by) VALUES
('Rock 109', 'Reprises rock des années 70 à aujourd’hui', NULL, NULL, 'Vendredi', '2025-09-12 20:00:00', '2025-09-12 21:30:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('La Rif et Nos Men', 'Rap-Rock festif et engagé', NULL, NULL, 'Vendredi', '2025-09-12 21:00:00', '2025-09-12 22:30:00', 'Intérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('An\'Om x Vayn', 'Rap & électro mélodique', NULL, NULL, 'Vendredi', '2025-09-12 22:30:00', '2025-09-13 00:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Wazy', 'DJ set – hip-hop, afro, house, rap', NULL, NULL, 'Vendredi', '2025-09-13 00:00:00', '2025-09-13 02:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('AXL R.', 'House, Afro house, Disco house, Techno, Hard techno', NULL, NULL, 'Vendredi', '2025-09-13 00:30:00', '2025-09-13 02:00:00', 'Intérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Hono', 'Electro House / Généraliste', NULL, NULL, 'Vendredi', '2025-09-13 02:00:00', '2025-09-13 04:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Dymeister', 'Techno – Acid – Hard Trance', NULL, NULL, 'Vendredi', '2025-09-13 02:00:00', '2025-09-13 03:30:00', 'Intérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1);

-- Insertion des artistes pour le samedi
INSERT INTO artistes (name, style, description, photo, day, begin_date, ending_date, scene, soundcloud_url, spotify_url, youtube_url, deezer_url, actif, created_by, updated_by) VALUES
('Youth Collective', 'Reggae Roots & Dub UK – Sound System', NULL, NULL, 'Samedi', '2025-09-13 15:00:00', '2025-09-13 17:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Maklos', 'House / Techno – Old School & Underground', NULL, NULL, 'Samedi', '2025-09-13 17:00:00', '2025-09-13 18:30:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Klö', 'Electro', NULL, NULL, 'Samedi', '2025-09-13 18:30:00', '2025-09-13 19:30:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Kaboum', NULL, NULL, NULL, 'Samedi', '2025-09-13 19:30:00', '2025-09-13 21:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('TOM WORRF', NULL, NULL, NULL, 'Samedi', '2025-09-13 20:30:00', '2025-09-13 22:00:00', 'Intérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('2TH', NULL, NULL, NULL, 'Samedi', '2025-09-13 22:00:00', '2025-09-13 23:30:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Mūne', NULL, NULL, NULL, 'Samedi', '2025-09-13 23:30:00', '2025-09-14 02:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Yonex', NULL, NULL, NULL, 'Samedi', '2025-09-14 00:30:00', '2025-09-14 02:00:00', 'Intérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Leydon', NULL, NULL, NULL, 'Samedi', '2025-09-14 02:00:00', '2025-09-14 04:00:00', 'Extérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1),
('Tripidium', NULL, NULL, NULL, 'Samedi', '2025-09-14 02:00:00', '2025-09-14 03:30:00', 'Intérieur', NULL, NULL, NULL, NULL, TRUE, 1, 1);

CREATE TABLE IF NOT EXISTS faqs (
	id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	question VARCHAR(500) NOT NULL COMMENT 'Question FAQ',
    answer TEXT NOT NULL COMMENT 'Réponse à la question',
    actif BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'FAQ active/masquée',
    ordre INT NOT NULL DEFAULT 0 COMMENT 'Ordre d\'affichage',
    created_by INT NULL COMMENT 'ID utilisateur créateur',
    updated_by INT NULL COMMENT 'ID de l\utilisateur qui a modifié',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de création',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date de modification',
	FOREIGN KEY (created_by) REFERENCES users(id),
	FOREIGN KEY (updated_by) REFERENCES users(id)
) COMMENT='Table des questions fréquentes';

INSERT INTO faqs (question, answer, actif, ordre, created_by, updated_by) VALUES
('Où et quand se déroule le festival ?', 'Rendez-vous à Campbon (44) les 12 & 13 septembre pour deux jours de vibes 🔥', TRUE, 1, 1, 1),
('À quelle heure ouvrent les portes ?', 'On t’accueille dès 19h vendredi et 13h samedi. Viens tôt, repars tard 😉', TRUE, 2, 1, 1),
('Quels sont les styles de musique proposés ?', 'Électro, rock, rap, dub… On mélange les styles pour faire kiffer tout le monde 🎶', TRUE, 3, 1, 1),
('Y a-t-il une billetterie sur place ?', 'Oui, mais sans garantie 😬. Le mieux, c’est de choper ta place en ligne avant que ça parte !', TRUE, 4, 1, 1),
('Y aura-t-il des espaces de restauration ?', 'Évidemment ! Foodtrucks, buvette, de quoi manger, boire et recharger les batteries 🍔🍻', TRUE, 5, 1, 1),
('Pourra-t-on dormir sur place ?', 'Oui carrément ! Le camping est prévu, ramène juste ton matériel et ta bonne humeur 🌙🎪🔥', TRUE, 6, 1, 1);
