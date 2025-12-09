<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Page;

class MainController extends Controller
{
    public function home()
    {
        // Récupérer la page d'accueil depuis la BDD si elle existe, sinon afficher une vue par défaut
        $pageModel = new Page();
        $page = $pageModel->findBy('slug', 'home');

        if ($page) {
            $this->render('Main/page', ['page' => $page]);
        } else {
            $this->render('Main/home');
        }
    }

    public function page($slug)
    {
        $pageModel = new Page();
        $page = $pageModel->findBy('slug', $slug);

        if (!$page) {
            http_response_code(404);
            $this->render('Main/404');
            return;
        }

        $this->render('Main/page', ['page' => $page]);
    }
}
