<?php
require 'db.php';
checkRole('student');

// ดึงข้อมูลคำขอฝึกงานของนิสิตคนนี้
$stmt = $pdo->prepare("
    SELECT r.*, c.company_name 
    FROM Internship_Request r
    JOIN Company c ON r.company_id = c.company_id
    WHERE r.student_id = ?
    ORDER BY r.created_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$requests = $stmt->fetchAll();

// ฟังก์ชันสำหรับแสดงป้ายสถานะ
/*function getStatusBadge($status) {
    switch($status) {
        case 1: return '<span class="badge bg-1">รับเรื่องเข้าระบบ</span>';
        case 2: return '<span class="badge bg-2">อาจารย์ที่ปรึกษาอนุมัติ</span>';
        case 3: return '<span class="badge bg-3">ออกใบส่งตัวแล้ว</span>';
        case 4: return '<span class="badge bg-4">ฝึกงานเสร็จสิ้น</span>';
        case 9: return '<span class="badge bg-9">ยกเลิก</span>';
        default: return '<span class="badge bg-1">ไม่ทราบสถานะ</span>';
    }
}*/
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ระบบฝึกงาน - หน้าแรกนิสิต</title>
    <link rel="stylesheet" href="style_sst.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-brand">
            <img src="img/Srinakharinwirot_Logo (1).png" alt="SWU Logo" onerror="this.src='img/images.png'">
            <span>ระบบติดตามสถานะการฝึกงาน</span>
        </div>
        <div class="nav-links">
            <span style="margin-right: 1rem; font-weight: 500;">นิสิต: <?php echo htmlspecialchars($_SESSION['name']); ?></span>
            <a href="logout.php" class="btn-outline" style="padding: 0.4rem 1rem; border-radius: 50px;">ออกจากระบบ</a>
        </div>
    </nav>

    <div class="container">
        <!-- Dashboard Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2><i class="fas fa-list-alt" style="color: var(--primary-red);"></i> รายการคำขอฝึกงานของคุณ</h2>
            <a href="student_request.php" class="btn btn-primary"><i class="fas fa-plus"></i> ยื่นคำขอฝึกงานใหม่</a>
        </div>

        <?php if(isset($_GET['success'])): ?>
            <div class="alert alert-success">ยื่นคำขอฝึกงานเรียบร้อยแล้ว</div>
        <?php endif; ?>

        <!-- Table -->
        <div class="card table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>เลขที่คำขอ</th>
                        <th>สถานประกอบการ</th>
                        <th>วันที่ยื่น</th>
                        <th>ระยะเวลาฝึก</th>
                        <th>สถานะปัจจุบัน</th>
                        <th>รายละเอียด</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($requests) > 0): ?>
                        <?php foreach($requests as $req): ?>
                        <tr>
                            <td>#<?php echo $req['request_id']; ?></td>
                            <td><?php echo htmlspecialchars($req['company_name']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($req['created_at'])); ?></td>
                            <td>
                                <?php echo date('d/m/Y', strtotime($req['start_date'])); ?> 
                                ถึง 
                                <?php echo date('d/m/Y', strtotime($req['end_date'])); ?>
                            </td>
                            <!-- <td><?php echo htmlspecialchars($req['supervision_note'] ?: '-'); ?></td> -->
                            <td><?php echo getStatusBadge($req['status']); ?></td>
                            <td><a href="view_detail.php?id=<?php echo $req['request_id']; ?>" class="btn btn-outline" style="padding: 0.2rem 0.5rem; font-size: 0.85rem;">
                                <i class="fas fa-search"></i> ดูรายละเอียด</a></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem;">คุณยังไม่มีข้อมูลการขอฝึกงาน</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
