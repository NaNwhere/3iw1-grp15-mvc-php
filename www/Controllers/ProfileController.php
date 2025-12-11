<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Core\Validator;

class ProfileController extends Controller
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
        $userModel = new User();
        $user = $userModel->find($_SESSION['user']['id']);
        $this->render('Profile/index', ['user' => $user]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $userModel = new User();
            $user = $userModel->find($_SESSION['user']['id']);

            $validator = new Validator($data);
            $validator->required('firstname');
            $validator->min('firstname', 2);
            $validator->required('lastname');
            $validator->min('lastname', 2);
            $validator->required('email');
            $validator->email('email');
            
            $validator->unique('email', 'users', 'email', $user['id']);

            if (!empty($data['password'])) {
               $validator->password('password');
            }

            if (!empty($validator->errors())) {
                $this->render('Profile/index', ['user' => $user, 'errors' => $validator->errors(), 'data' => $data]);
                return;
            }

            $updateData = [
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'role' => $user['role']
            ];
            
            $userModel->update($user['id'], $updateData);

            if (!empty($data['password'])) {
                $userModel->updatePassword($user['id'], $data['password']);
            }
            $_SESSION['user'] = $userModel->find($user['id']);
            
            $this->redirect('/profile?success=1');
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $userModel->delete($_SESSION['user']['id']);
            
            session_destroy();
            $this->redirect('/?account_deleted=1');
        }
    }
}
