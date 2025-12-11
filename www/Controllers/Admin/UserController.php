<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\User;
use App\Core\Validator;

class UserController extends Controller
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
        $userModel = new User();
        $users = $userModel->findAll();
        $this->render('Admin/Users/index', ['users' => $users]);
    }

    public function create()
    {
        $this->render('Admin/Users/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $userModel = new User();
            $data = $_POST;

            $validator = new Validator($data);
            $validator->required('firstname');
            $validator->min('firstname', 2);
            $validator->required('lastname');
            $validator->min('lastname', 2);
            $validator->required('email');
            $validator->email('email');
            $validator->required('password');
            $validator->password('password');

            if (!empty($validator->errors())) {
                $this->render('Admin/Users/create', ['errors' => $validator->errors(), 'data' => $data]);
                return;
            }

            $data['verification_token'] = null;
            
            if ($userModel->create($data)) {
                $this->redirect('/admin/users');
            } else {
                die("Erreur lors de la création de l'utilisateur.");
            }
        }
    }

    public function edit($id)
    {
        $userModel = new User();
        $user = $userModel->find($id);
        $this->render('Admin/Users/edit', ['user' => $user]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = $_POST;
            
            $validator = new Validator($data);
            $validator->required('firstname');
            $validator->min('firstname', 2);
            $validator->required('lastname');
            $validator->min('lastname', 2);
            $validator->required('email');
            $validator->email('email');

            if ($id == $_SESSION['user']['id']) {
                $data['role'] = $_SESSION['user']['role'];
            }

            if (!empty($validator->errors())) {
                $user = (new User())->find($id);
                $this->render('Admin/Users/edit', ['user' => $user, 'errors' => $validator->errors(), 'data' => $data]);
                return;
            }

            $userModel = new User();
            if ($userModel->update($id, $data)) {
                $this->redirect('/admin/users');
            } else {
                die("Erreur lors de la mise à jour de l'utilisateur.");
            }
        }
    }

    public function delete($id)
    {
        if ($id == $_SESSION['user']['id']) {
            die("Vous ne pouvez pas supprimer votre propre compte.");
        }

        $userModel = new User();
        $userModel->delete($id);
        $this->redirect('/admin/users');
    }

    public function verify($id)
    {
        $userModel = new User();
        $userModel->verifyAccount($id);
        
        $this->redirect('/admin/users');
    }

    public function sendResetLink($id)
    {
        $userModel = new User();
        $user = $userModel->find($id);

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $userModel->setResetToken($user['email'], $token);

            $mailer = new \App\Core\Mailer();
            $link = "http://" . $_SERVER['HTTP_HOST'] . "/reset-password?token=" . $token;
            $subject = "Réinitialisation de votre mot de passe (Admin)";
            $body = "Bonjour,<br><br>Un administrateur a demandé la réinitialisation de votre mot de passe.<br>Veuillez cliquer sur le lien suivant : <a href='$link'>$link</a>";
            
            $mailer->send($user['email'], $subject, $body);
        }

        $this->redirect('/admin/users');
    }
}
