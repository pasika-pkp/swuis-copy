<?php
require 'db.php';
checkRole('teacher');

// ดึงข้อมูลคำขอฝึกงานทั้งหมดจากฐานข้อมูล
$stmt = $pdo->query("
    SELECT r.*, c.company_name, s.first_name, s.last_name, s.student_id as st_id
    FROM Internship_Request r
    JOIN Company c ON r.company_id = c.company_id
    JOIN Student s ON r.student_id = s.student_id
    ORDER BY r.created_at DESC
");
$requests = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ระบบอาจารย์ - รายการคำขอฝึกงานทั้งหมด</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style_sst.css">
    <link rel="stylesheet" href="https://cloudflare.com">
</head>

<!-- แถบเมนูด้านบน -->
<body>
    <nav class="navbar">
        <div class="nav-brand">
            <img src="img/Srinakharinwirot_Logo (1).png" alt="SWU Logo" onerror="this.src='img/images.png'">
            <span>อาจารย์บันทึกผล </span>
        </div>
        <div class="nav-links">
            <span style="margin-right: 1rem; font-weight: 500;">อาจารย์: <?php echo htmlspecialchars($_SESSION['name']); ?></span>
            <a href="logout.php" class="btn-outline" style="padding: 0.4rem 1rem; border-radius: 50px;">ออกจากระบบ</a>
        </div>
    </nav>


    <div class="container">
        <h2 style="margin-bottom: 1.5rem;"><i class="fas fa-chalkboard-teacher" style="color: var(--primary-red);"></i> รายการคำขอฝึกงานทั้งหมด </h2>

        <?php if(isset($_GET['updated'])): ?>
            <div class="alert alert-success">บันทึกข้อมูลเรียบร้อยแล้ว</div>
        <?php endif; ?>

        <!-- ตารางแสดงข้อมูล -->
        <div class="card table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>เลขที่/วันที่ยื่น</th>
                        <th>รหัสนิสิต</th>
                        <th>ชื่อ-สกุล</th>
                        <th>สถานประกอบการ</th>
                        <th>สถานะปัจจุบัน</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($requests) > 0): ?>
                        <?php foreach($requests as $req): ?>
                        <tr>
                            <td>
                                <b>#<?php echo $req['request_id']; ?></b><br>
                                <small style="color:gray;"><?php echo date('d/m/Y', strtotime($req['created_at'])); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($req['st_id']); ?></td>
                            <td><?php echo htmlspecialchars($req['first_name'] . ' ' . $req['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($req['company_name']); ?></td>
                            <td><?php echo getStatusBadge($req['status']); ?></td>
                            <td>
                                <a href="teacher_detail.php?id=<?php echo $req['request_id']; ?>" class="btn btn-outline" style="padding: 0.2rem 0.5rem; font-size: 0.85rem;">
                                    <i class="fas fa-search"></i> ดูรายละเอียด/ประเมินผล
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align: center; padding: 2rem;">ไม่มีข้อมูลคำขอ</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>