<?php
// กาารเชื่อมต่อฐานข้อมูล PDO
$host = 'localhost';
$db   = 'internships';
$user = 'root';
$pass = ''; // เปลี่ยนเป็นรหัสผ่านของคุณถ้ามี
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // ให้ระบบแสดง Error หากมีปัญหา
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // ดึงข้อมูลออกมาในรูปแบบ Array
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// 1. เปิดการแสดง Error ทั้งหมด
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

session_start(); // เปิดใช้งาน Session ทุกครั้งที่มีการเรียกใช้ db.php

// ฟังก์ชันสำหรับตรวจสอบการล็อกอิน
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function checkRole($role) {
    if (!isLoggedIn() || $_SESSION['role'] !== $role) {
        header('Location: index.php?error=unauthorized');
        exit();
    }
}
function getStatusBadge($status) {
    switch($status) {
        case 1: return '<span class="badge bg-1">รับเรื่องเข้าระบบ</span>';
        case 2: return '<span class="badge bg-2">อาจารย์ที่ปรึกษาอนุมัติ</span>';
        case 3: return '<span class="badge bg-3">ออกใบส่งตัวแล้ว</span>';
        case 4: return '<span class="badge bg-4">ฝึกงานเสร็จสิ้น</span>';
        case 9: return '<span class="badge bg-9">ยกเลิก</span>';
        default: return '<span class="badge bg-1">ไม่ทราบสถานะ</span>';
    }
}
?>
