<?php
namespace App\Core;

/**
 * Class Controller
 * Contrôleur de base dont héritent tous les contrôleurs.
 */
abstract class Controller
{
    /**
     * Affiche une vue.
     * @param string $view Chemin de la vue (ex: 'Main/home')
     * @param array $data Données à passer à la vue
     */
    protected function render($view, $data = [])
    {
        extract($data);

        // Récupération des pages pour le menu dynamique
        $menuPages = [];
        if (class_exists('App\Models\Page')) {
            $pageModel = new \App\Models\Page();
            $menuPages = $pageModel->findAll();
        }

        // Chemin vers le fichier de vue
        $viewFile = ROOT . '/Views/' . $view . '.php';

        if (file_exists($viewFile)) {
            ob_start();
            require $viewFile;
            $content = ob_get_clean();

            // Choix du layout (par défaut 'front', peut être surchargé)
            $layout = isset($this->layout) ? $this->layout : 'front';
            
            require ROOT . '/Views/Templates/' . $layout . '.php';
        } else {
            die("Vue introuvable : " . $view);
        }
    }
    
    /**
     * Redirige vers une URL.
     * @param string $url
     */
    protected function redirect($url)
    {
        header("Location: " . $url);
        exit;
    }

    /**
     * Échappe une chaîne pour l'affichage (XSS).
     * @param string $string
     * @return string
     */
    protected function e($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

}
