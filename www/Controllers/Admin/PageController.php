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
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('/login');
        }
    }

    public function index()
    {
        $pageModel = new Page();
        $pages = $pageModel->findAll();
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
            
            $validator = new Validator($data);
            $validator->required('title');
            $validator->min('title', 3);
            $validator->required('slug');
            $validator->min('slug', 3);
            $validator->unique('slug', 'pages', 'slug');
            $validator->required('content');

            if (!empty($validator->errors())) {
                $this->render('Admin/Pages/create', ['errors' => $validator->errors(), 'data' => $data]);
                return;
            }

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
        $this->render('Admin/Pages/edit', ['page' => $page]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = $_POST;

            $validator = new Validator($data);
            $validator->required('title');
            $validator->min('title', 3);
            $validator->required('slug');
            $validator->min('slug', 3);
            $validator->unique('slug', 'pages', 'slug', $id);
            $validator->required('content');

            if (!empty($validator->errors())) {
                $page = (new Page())->find($id);
                $this->render('Admin/Pages/edit', ['page' => $page, 'errors' => $validator->errors(), 'data' => $data]);
                return;
            }

            $pageModel = new Page();
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
        $pageModel->delete($id);
        $this->redirect('/admin/pages');
    }
}
