-- Création de la table users
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    is_verified BOOLEAN DEFAULT FALSE,
    verification_token VARCHAR(255),
    reset_token VARCHAR(255),
    reset_expires_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Création de la table pages
CREATE TABLE IF NOT EXISTS pages (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertion d'un admin par défaut (password: admin123)
-- Hash généré via password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO users (firstname, lastname, email, password, role, is_verified)
VALUES ('Admin', 'User', 'johan.ledoux25@gmail.com', '$2y$10$MQrPUCzmjo0ZuVxiUijvUu4dcl5Vt9VsF/E1jIOPRYvbQeTcFsaim', 'admin', TRUE)
ON CONFLICT (email) DO NOTHING;

-- Insertion d'une page d'accueil par défaut
INSERT INTO pages (title, slug, content)
VALUES ('Accueil', 'home', '<h1>Bienvenue sur notre Mini CMS</h1><p>Ceci est la page d''accueil générée par défaut.</p>')
ON CONFLICT (slug) DO NOTHING;
