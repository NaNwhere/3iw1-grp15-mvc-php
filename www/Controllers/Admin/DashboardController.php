<?php
namespace App\Controllers\Admin;

use App\Core\Controller;

class DashboardController extends Controller
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
        $this->render('Admin/dashboard');
    }
}
