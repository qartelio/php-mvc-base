<?php

namespace App\Controllers\Student;

use App\Core\Controller;
use App\Models\Student;

class DashboardController extends Controller
{
    private $studentModel;
    
    public function __construct()
    {
        parent::__construct();
        $this->studentModel = new Student();
    }

    public function index()
    {
        if (!isset($_SESSION['student_id'])) {
            $this->redirect('/login');
            return;
        }

        $studentId = $_SESSION['student_id'];
        $student = $this->studentModel->getById($studentId);
        
        if (!$student) {
            $_SESSION['error'] = 'Студент не найден';
            $this->redirect('/login');
            return;
        }

        // Получаем общее количество баллов
        $totalPoints = $this->studentModel->getTotalPoints($studentId);
        $student['total_points'] = $totalPoints;

        $this->view('student/dashboard', ['student' => $student]);
    }
}
