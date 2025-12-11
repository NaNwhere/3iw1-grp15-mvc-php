<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Page;
use App\Core\Validator;
use App\Core\Security;

class PageController extends Controller
{
    protected $layout = 'back';

    public function __construct()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
        }
    }

    public function index()
    {
        $pageModel = new Page();
        if ($_SESSION['user']['role'] === 'admin') {
            $pages = $pageModel->findAllWithAuthor();
        } else {
            $pages = $pageModel->findByAuthor($_SESSION['user']['id']);
        }
        $this->render('Admin/Pages/index', ['pages' => $pages]);
    }

    public function create()
    {
        $this->render('Admin/Pages/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = $_POST;
            $data['slug'] = str_replace(' ', '-', $data['slug']);
            $data['slug'] = urlencode($data['slug']);
            $validator = new Validator($data);
            $validator->required('title');
            $validator->min('title', 3);
            $validator->required('slug');
            $validator->min('slug', 3);
            $validator->unique('slug', 'pages', 'slug');
            if (strlen($data['slug']) > 100) {
                $validator->addError('slug', "Le slug ne doit pas dépasser 100 caractères.");
            }
            $validator->required('content');

            if (!empty($validator->errors())) {
                $this->render('Admin/Pages/create', ['errors' => $validator->errors(), 'data' => $data]);
                return;
            }

            $allowed_tags = '<p><br><strong><em><ul><ol><li><a><img><div><span><table><tr><td><th><blockquote><code><pre>';
            $data['content'] = strip_tags($data['content'], $allowed_tags);
            $data['user_id'] = $_SESSION['user']['id'];

            $pageModel = new Page();
            if ($pageModel->create($data)) {
                $this->redirect('/admin/pages');
            } else {
                die("Erreur lors de la création de la page.");
            }
        }
    }

    public function edit($id)
    {
        $pageModel = new Page();
        $page = $pageModel->find($id);

        if (!$page) {
            $this->redirect('/admin/pages');
        }

        if ($_SESSION['user']['role'] !== 'admin' && $page['user_id'] !== $_SESSION['user']['id']) {
            $this->redirect('/admin/pages');
        }

        $this->render('Admin/Pages/edit', ['page' => $page]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = $_POST;
            $data['slug'] = str_replace(' ', '-', $data['slug']);
            $data['slug'] = urlencode($data['slug']);
            $validator = new Validator($data);
            $validator->required('title');
            $validator->min('title', 3);
            $validator->required('slug');
            $validator->min('slug', 3);
            $validator->unique('slug', 'pages', 'slug', $id);
            if (strlen($data['slug']) > 100) {
                $validator->addError('slug', "Le slug ne doit pas dépasser 100 caractères.");
            }
            $validator->required('content');

            if (!empty($validator->errors())) {
                $page = (new Page())->find($id);
                $this->render('Admin/Pages/edit', ['page' => $page, 'errors' => $validator->errors(), 'data' => $data]);
                return;
            }

            $allowed_tags = '<p><br><strong><em><ul><ol><li><a><img><div><span><table><tr><td><th><blockquote><code><pre>';
            $data['content'] = strip_tags($data['content'], $allowed_tags);
            $data['user_id'] = $_SESSION['user']['id'];

            $pageModel = new Page();
            $page = $pageModel->find($id);

            if (!$page) {
                $this->redirect('/admin/pages');
            }
    
            if ($_SESSION['user']['role'] !== 'admin' && $page['user_id'] !== $_SESSION['user']['id']) {
                die("Action non autorisée");
            }

            if ($pageModel->update($id, $data)) {
                $this->redirect('/admin/pages');
            } else {
                die("Erreur lors de la mise à jour de la page.");
            }
        }
    }

    public function delete($id)
    {
        $pageModel = new Page();
        $page = $pageModel->find($id);

        if ($page) {
            if ($_SESSION['user']['role'] === 'admin' || $page['user_id'] === $_SESSION['user']['id']) {
                $pageModel->delete($id);
            }
        }
        
        $this->redirect('/admin/pages');
    }
}
