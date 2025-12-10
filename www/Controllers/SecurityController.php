<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Core\Mailer;
use App\Core\Validator;
use App\Core\Security;

class SecurityController extends Controller
{
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = $_POST;
            $userModel = new User();

            $validator = new Validator($data);
            $validator->required('firstname');
            $validator->min('firstname', 2);
            $validator->required('lastname');
            $validator->min('lastname', 2);
            $validator->required('email');
            $validator->email('email');
            $validator->unique('email', 'users', 'email');
            $validator->required('password');
            $validator->password('password');
            $validator->required('password_confirm');
            $validator->match('password_confirm', 'password');

            if (!empty($validator->errors())) {
                $this->render('Security/register', ['errors' => $validator->errors(), 'data' => $data]);
                return;
            }

            // Génération du token de vérification
            $token = bin2hex(random_bytes(32));
            $data['verification_token'] = $token;

            if ($userModel->create($data)) {
                // Envoi de l'email de vérification
                $mailer = new Mailer();
                $link = "http://" . $_SERVER['HTTP_HOST'] . "/verify?token=" . $token;
                $subject = "Vérification de votre compte";
                $body = "Bonjour,<br><br>Veuillez cliquer sur le lien suivant pour vérifier votre compte : <a href='$link'>$link</a>";
                
                if ($mailer->send($data['email'], $subject, $body)) {
                    $this->render('Security/register_success');
                } else {
                    $error = "Compte créé mais erreur lors de l'envoi de l'email.";
                    $this->render('Security/register', ['error' => $error]);
                }
                return;
            } else {
                $error = "Une erreur est survenue lors de l'inscription.";
                $this->render('Security/register', ['error' => $error]);
                return;
            }
        }

        $this->render('Security/register');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->findBy('email', $email);

            if ($user && password_verify($password, $user['password'])) {
                if (!$user['is_verified']) {
                    $error = "Veuillez vérifier votre email avant de vous connecter.";
                    $this->render('Security/login', ['error' => $error]);
                    return;
                }

                // Connexion réussie
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'firstname' => $user['firstname'],
                    'lastname' => $user['lastname'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];

                $this->redirect('/');
            } else {
                $error = "Identifiants incorrects.";
                $this->render('Security/login', ['error' => $error]);
                return;
            }
        }

        $this->render('Security/login');
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/login');
    }

    public function verify()
    {
        $token = $_GET['token'] ?? null;
        if (!$token) {
            die("Token manquant.");
        }

        $userModel = new User();
        $user = $userModel->findBy('verification_token', $token);

        if ($user) {
            $userModel->verifyAccount($user['id']);

            $this->render('Security/verify_success');
        } else {
            die("Token invalide.");
        }
    }

    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = $_POST['email'];
            $userModel = new User();
            $user = $userModel->findBy('email', $email);

            if ($user) {
                $token = bin2hex(random_bytes(32));
                $userModel->setResetToken($email, $token);

                $mailer = new Mailer();
                $link = "http://" . $_SERVER['HTTP_HOST'] . "/reset-password?token=" . $token;
                $subject = "Réinitialisation de votre mot de passe";
                $body = "Bonjour,<br><br>Veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe : <a href='$link'>$link</a>";
                
                $mailer->send($email, $subject, $body);
            }
            
            // On affiche toujours le même message pour ne pas dévoiler si l'email existe
            $success = "Si un compte existe avec cet email, un lien de réinitialisation a été envoyé.";
            $this->render('Security/forgot_password', ['success' => $success]);
            return;
        }

        $this->render('Security/forgot_password');
    }

    public function resetPassword()
    {
        $token = $_GET['token'] ?? null;
        if (!$token) {
            die("Token manquant.");
        }

        $userModel = new User();
        $user = $userModel->findByResetToken($token);

        if (!$user) {
            die("Lien invalide ou expiré.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $password = $_POST['password'];
            $passwordConfirm = $_POST['password_confirm'];

            $validator = new Validator($_POST);
            $validator->required('password');
            $validator->password('password');
            $validator->required('password_confirm');
            $validator->match('password_confirm', 'password');

            if (!empty($validator->errors())) {
                 $this->render('Security/reset_password', ['errors' => $validator->errors(), 'token' => $token]);
                 return;
            }

            $userModel->updatePassword($user['id'], $password);
            $this->render('Security/login', ['success' => "Mot de passe mis à jour avec succès. Vous pouvez vous connecter."]);
            return;
        }

        $this->render('Security/reset_password', ['token' => $token]);
    }
}
