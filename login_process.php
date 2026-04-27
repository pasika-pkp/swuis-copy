<?php
require 'db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // ตรวจสอบเจ้าหน้าที่หรืออาจารย์ก่อน
    $stmt = $pdo->prepare("SELECT * FROM Staff WHERE username = ?");
    $stmt->execute([$username]);
    $staff = $stmt->fetch();
    
    // เพื่อให้ทดสอบง่ายสำหรับโปรเจ็คต์ จึงเช็คทั้งแบบข้อความธรรมดา '1234' และแบบ Hash
    if ($staff && ($password === '1234' || password_verify($password, $staff['password']))) {
        $_SESSION['user_id'] = $staff['staff_id'];
        $_SESSION['role'] = $staff['role'];
        $_SESSION['name'] = $staff['first_name'] . ' ' . $staff['last_name'];
        
        if ($staff['role'] == 'teacher') {
            header("Location: teacher_dashboard.php");
        } else {
            header("Location: staff_dashboard.php");
        }
        exit();
    }
    
    // ตรวจสอบนิสิต
    $stmt = $pdo->prepare("SELECT * FROM Student WHERE student_id = ?");
    $stmt->execute([$username]);
    $student = $stmt->fetch();
    
    if ($student && ($password === '1234' || password_verify($password, $student['password']))) {
        $_SESSION['user_id'] = $student['student_id'];
        $_SESSION['role'] = 'student';
        $_SESSION['name'] = $student['first_name'] . ' ' . $student['last_name'];
        header("Location: student_dashboard.php");
        exit();
    }
    
    // ล็อกอินไม่สำเร็จ
    header("Location: index.php?error=invalid#login");
    exit();
}
?>
