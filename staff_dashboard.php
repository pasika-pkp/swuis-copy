<?php

// =========================

// เชื่อมต่อฐานข้อมูล

// =========================

require 'db.php';


// =========================

// ตรวจสอบสิทธิ์ผู้ใช้งาน (ต้องเป็นเจ้าหน้าที่)

// =========================

checkRole('staff');


// =========================

// รับค่า status จาก URL (ใช้สำหรับ tab filter)

// =========================

$status = $_GET['status'] ?? 'all';


// =========================

// สร้าง query ตาม status ที่เลือก

// =========================

if ($status === 'all') {

    // ดึงข้อมูลทั้งหมด

    $stmt = $pdo->query("

        SELECT r.*,

               c.company_name,

               s.first_name,

               s.last_name,

               s.student_id AS st_id

        FROM Internship_Request r

        JOIN Company c ON r.company_id = c.company_id

        JOIN Student s ON r.student_id = s.student_id

        ORDER BY r.created_at DESC

    ");

} else {

    // ดึงเฉพาะสถานะที่เลือก

    $stmt = $pdo->prepare("

        SELECT r.*,

               c.company_name,

               s.first_name,

               s.last_name,

               s.student_id AS st_id

        FROM Internship_Request r

        JOIN Company c ON r.company_id = c.company_id

        JOIN Student s ON r.student_id = s.student_id

        WHERE r.status = ?

        ORDER BY r.created_at DESC

    ");

    $stmt->execute([(int)$status]);

}


// เก็บข้อมูลทั้งหมด

$requests = $stmt->fetchAll();

?>


<!DOCTYPE html>

<html lang="th">

<head>

    <meta charset="UTF-8">

    <title>ระบบเจ้าหน้าที่</title>

    <link rel="stylesheet" href="style_sst.css">

    <style>

        /* ตกแต่งคร่าวๆ */

        body { font-family: sans-serif; background: #f4f7f6; padding: 20px; }

        .container { max-width: 1000px; margin: auto; background: white; padding: 20px; border-radius: 8px; }

        .badge { padding: 5px 10px; border-radius: 4px; color: white; font-size: 0.9em; }

        .bg-1 { background: #6c757d; } .bg-2 { background: #0d6efd; }

        .bg-3 { background: #ffc107; color: #000; } .bg-4 { background: #198754; }

        .bg-9 { background: #dc3545; }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; color: #000000; }

        th, td { border: 1px solid #dddd; padding: 10px; text-align: left; }

        th { background-color: #f98581; }

        .alert { background: #d1e7dd; color: #0f5132; padding: 10px; border-radius: 4px; margin-bottom: 15px; }

        /* สไตล์สำหรับกล่องหุ้ม */
.status-filter-container {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 2rem;
    padding: 10px 0;
}

/* สไตล์ของปุ่ม Link */
.status-link {
    text-decoration: none;
    padding: 8px 20px;
    border-radius: 50px; /* ทรงแคปซูล */
    background-color: #f0f0f0;
    color: #555;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    border: 1px solid #ddd;
}

/* เมื่อเอาเมาส์ไปชี้ */
.status-link:hover {
    background-color: #e0e0e0;
    color: #000;
}

/* สไตล์สำหรับปุ่มที่ถูกเลือก (Active) */
.status-link.active {
    background-color: #ce1126; /* สีแดง มศว */
    color: white;
    border-color: #ce1126;
    box-shadow: 0 4px 10px rgba(206, 17, 38, 0.2);
}


    </style>

</head>

<body>


<nav class="navbar" style="margin-bottom: 20px;">

    <div class="nav-brand">
    <img src="img/Srinakharinwirot_Logo (1).png" alt="SWU Logo" onerror="this.src='img/images.png'">
        <h2>ระบบเจ้าหน้าที่</h2>

    </div>

    <div class="nav-links">

        เจ้าหน้าที่: <?php echo htmlspecialchars($_SESSION['name'] ?? 'ผู้ดูแลระบบ'); ?>

        <a href="logout.php"  class="btn-outline" style="padding: 0.4rem 1rem; border-radius: 50px;">ออกจากระบบ</a>

    </div>

</nav>


<div class="container">

    <h2>รายการคำขอฝึกงาน</h2>
    <?php $current_status = $_GET['status'] ?? 'all'; ?>

<div class="status-filter-container">
    <a href="?status=all" class="status-link <?php echo $current_status == 'all' ? 'active' : ''; ?>">ทั้งหมด</a>
    <a href="?status=1" class="status-link <?php echo $current_status == '1' ? 'active' : ''; ?>">รออนุมัติ</a>
    <a href="?status=2" class="status-link <?php echo $current_status == '2' ? 'active' : ''; ?>">อนุมัติแล้ว</a>
    <a href="?status=3" class="status-link <?php echo $current_status == '3' ? 'active' : ''; ?>">ออกใบส่งตัว</a>
    <a href="?status=4" class="status-link <?php echo $current_status == '4' ? 'active' : ''; ?>">เสร็จสิ้น</a>
    <a href="?status=9" class="status-link <?php echo $current_status == '9' ? 'active' : ''; ?>">ยกเลิก</a>
</div>

    <?php if(isset($_GET['updated'])): ?>

        <div class="alert">✅ อัปเดตสถานะสำเร็จเรียบร้อยแล้ว</div>

    <?php endif; ?>


    <table>

        <tr>

            <th>เลขที่</th>

            <th>รหัสนิสิต</th>

            <th>ชื่อ</th>

            <th>บริษัท</th>

            <th>สถานะ</th>

            <th>จัดการ</th>

        </tr>

        <?php foreach($requests as $req): ?>

        <tr>

            <td><?php echo htmlspecialchars($req['request_id']); ?></td>

            <td><?php echo htmlspecialchars($req['st_id']); ?></td>

            <td><?php echo htmlspecialchars($req['first_name'].' '.$req['last_name']); ?></td>

            <td><?php echo htmlspecialchars($req['company_name']); ?></td>

            <td><?php echo getStatusBadge($req['status']); ?></td>

            <td>
            <a href="staff_detail.php?id=<?php echo (int)$req['request_id']; ?>" 
            class="btn btn-outline" 
            style="padding: 0.2rem 0.5rem; font-size: 0.85rem; text-decoration: none; border: 1px solid #ccc; border-radius: 4px; display: inline-block;">
            <i class="fas fa-search"></i> ดูรายละเอียด/แก้ไข
                </a>
            </td>


        </tr>

        <?php endforeach; ?>

    </table>

</div>


</body>

</html>