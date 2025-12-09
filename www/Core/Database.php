<?php
namespace App\Core;

use PDO;
use PDOException;

/**
 * Class Database
 * Gestion de la connexion à la base de données via le pattern Singleton.
 */
class Database
{
    /**
     * @var Database|null Instance unique de la classe
     */
    private static $instance = null;

    /**
     * @var PDO Connexion PDO
     */
    private $pdo;

    /**
     * Constructeur privé pour empêcher l'instanciation directe.
     * Récupère les variables d'environnement pour la connexion.
     */
    private function __construct()
    {
        // Récupération des variables d'environnement (définies dans docker-compose ou .env)
        // On utilise getenv() ou $_ENV selon la configuration
        $host = getenv('DB_HOST') ?: 'db'; // Nom du service docker
        $dbname = getenv('POSTGRES_DB') ?: 'app_db';
        $user = getenv('POSTGRES_USER') ?: 'user';
        $pass = getenv('POSTGRES_PASSWORD') ?: 'password';
        $port = getenv('DB_PORT') ?: '5432';

        try {
            // Connexion PostgreSQL
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
            $this->pdo = new PDO($dsn, $user, $pass);
            
            // Configuration des erreurs PDO
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    /**
     * Récupère l'instance unique de la classe Database.
     * @return Database
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Récupère la connexion PDO.
     * @return PDO
     */
    public function getConnection()
    {
        return $this->pdo;
    }
}
