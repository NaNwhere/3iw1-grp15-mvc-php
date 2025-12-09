<?php
/**
 * Point d'entrée de l'application.
 * Charge l'autoloader et lance le routeur.
 */

// Définition de la racine du projet
define('ROOT', dirname(__DIR__));

// Démarrage de la session pour toute l'application
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Chargement de l'autoloader
require ROOT . '/Core/Autoloader.php';
App\Core\Autoloader::register();

// Chargement de l'autoloader Composer (pour PHPMailer, etc.)
if (file_exists(ROOT . '/vendor/autoload.php')) {
    require ROOT . '/vendor/autoload.php';
}

// Démarrage de l'application via le routeur
$app = new App\Core\Router();
$app->run();
