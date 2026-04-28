<?php
require 'db.php';
checkRole('teacher');

$request_id = $_GET['id'] ?? 0;

// ดึงรายละเอียดคำขอฝึกงาน
$stmt = $pdo->prepare("
    SELECT r.*, 
           c.company_name, c.address, c.contact_person, c.contact_phone, c.contact_email, 
           s.first_name, s.last_name, s.student_id as st_id, s.year, s.phone, s.email
    FROM Internship_Request r
    JOIN Company c ON r.company_id = c.company_id
    JOIN Student s ON r.student_id = s.student_id
    WHERE r.request_id = ?
");

$stmt->execute([$request_id]);
$req = $stmt->fetch();

if (!$req) {
    die("ไม่พบข้อมูลคำขอนี้");
}

// อัปเดตข้อมูล (การอนุมัติ/ปฏิเสธ และ บันทึกผลการนิเทศ)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // กรณีที่ 1: กดปุ่มอนุมัติ (Status 1 -> 2)
    if (isset($_POST['approve_btn']) && $req['status'] == 1) {
        $new_status = 2; // อนุมัติ
        $log_stmt = $pdo->prepare("INSERT INTO Status_Log (request_id, old_status, new_status, changed_by) VALUES (?, ?, ?, ?)");
        $log_stmt->execute([$request_id, 1, $new_status, $_SESSION['name']]);
        
        $up_stmt = $pdo->prepare("UPDATE Internship_Request SET status = ? WHERE request_id = ?");
        $up_stmt->execute([$new_status, $request_id]);
    }
    
    // กรณีที่ 2: กดปุ่มปฏิเสธการอนุมัติ (เพิ่มส่วนนี้)
    if (isset($_POST['reject_btn']) && $req['status'] == 1) {
        $new_status = 0; // 0: ปฏิเสธ/ไม่ผ่าน
        $reason = $_POST['reject_reason'] ?? '';

        $log_stmt = $pdo->prepare("INSERT INTO Status_Log (request_id, old_status, new_status, changed_by) VALUES (?, ?, ?, ?)");
        $log_stmt->execute([$request_id, 1, $new_status, $_SESSION['name']]);
        
        // อัปเดตสถานะ พร้อมบันทึกเหตุผลลงใน supervision_note (หรือคอลัมน์ที่เก็บเหตุผล)
        $up_stmt = $pdo->prepare("UPDATE Internship_Request SET status = ?, supervision_note = ? WHERE request_id = ?");
        $up_stmt->execute([$new_status, $reason, $request_id]);
    }
    
    // จัดการผลการนิเทศทั่วไป (ถ้ามี)
    if (isset($_POST['supervision_note']) && !isset($_POST['reject_btn'])) {
        $note = $_POST['supervision_note'];
        $up_stmt = $pdo->prepare("UPDATE Internship_Request SET supervision_note = ? WHERE request_id = ?");
        $up_stmt->execute([$note, $request_id]);
    }

    header("Location: teacher_dashboard.php?updated=1");
    exit();
}

?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดคำขอฝึกงาน #<?php echo $request_id; ?></title>
    <link rel="stylesheet" href="style_sst.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-brand">
            <img src="img/Srinakharinwirot_Logo (1).png" alt="SWU Logo" onerror="this.src='img/images.png'">
            <span>จัดการคำขอฝึกงาน</span>
        </div>
        <div class="nav-links">
            <span style="margin-right: 1rem; font-weight: 500;">อาจารย์: <?php echo htmlspecialchars($_SESSION['name']); ?></span>
            <a href="logout.php" class="btn-outline" style="padding: 0.4rem 1rem; border-radius: 50px;">ออกจากระบบ</a>
        </div>
    </nav>

    <div class="container">
        <div style="margin-bottom: 2rem;">
            <a href="teacher_dashboard.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> กลับหน้ารวมรายการ</a>
        </div>

        <div class="grid grid-2">
            <!-- ข้อมูลนิสิต -->
            <div class="card">
                <h3 class="card-title">ข้อมูลนิสิต</h3>
                <p><b>รหัสนิสิต:</b> <?php echo htmlspecialchars($req['st_id']); ?></p>
                <p><b>ชื่อ-สกุล:</b> <?php echo htmlspecialchars($req['first_name'] . ' ' . $req['last_name']); ?> (ชั้นปีที่ <?php echo $req['year']; ?>)</p>
                <p><b>อีเมล:</b> <?php echo htmlspecialchars($req['email']); ?></p>
                <p><b>เบอร์:</b> <?php echo htmlspecialchars($req['phone']); ?></p>
                
                <h3 class="card-title" style="margin-top: 1.5rem;">ข้อมูลการฝึกงาน</h3>
                <p><b>สถานประกอบการ:</b> <?php echo htmlspecialchars($req['company_name']); ?></p>
                <p><b>ที่อยู่สถานประกอบการ:</b> <?php echo htmlspecialchars($req['address']); ?></p>
                <p><b>ตำแหน่งที่ฝึกงาน:</b> <?php echo htmlspecialchars($req['internship_position']); ?></p>
                <p><b>ผู้ประสานงาน:</b> <?php echo htmlspecialchars($req['contact_person']); ?></p>
                <p><b>เบอร์โทรศัพท์ติดต่อ:</b> <?php echo htmlspecialchars($req['contact_phone']); ?></p>
                <p><b>อีเมลติดต่อ:</b> <?php echo htmlspecialchars($req['contact_email']?? '-' ); ?></p>
                <p><b>ระยะเวลา:</b> <?php echo date('d/m/Y', strtotime($req['start_date'])); ?> - <?php echo date('d/m/Y', strtotime($req['end_date'])); ?></p>
                <p><b>สถานะปัจจุบัน:</b> <?php echo getStatusBadge($req['status']); ?></p>
                
                
                <?php if($req['status'] == 1): ?>
                    <form action="teacher_detail.php?id=<?php echo $request_id; ?>" method="POST" id="statusForm" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px dashed #ccc;">
                    <div class="alert alert-warning" style="margin-bottom: 1rem;">คำขอนี้รอการอนุมัติจากอาจารย์ที่ปรึกษา</div>
    
                    <div style="display: flex; gap: 10px; margin-bottom: 1rem;">
                    <button type="submit" name="approve_btn" value="1" class="btn btn-success" onclick="return confirm('ยืนยันการอนุมัติ?')">
                    <i class="fas fa-check"></i> อนุมัติ
                    </button>
        
        <!-- ปุ่มกดเพื่อแสดงช่องกรอกเหตุผลปฏิเสธ -->
        <button type="button" class="btn btn-danger" onclick="showRejectBox()">
            <i class="fas fa-times"></i> ปฏิเสธการอนุมัติ
        </button>
    </div>

    <!-- ส่วนที่ซ่อนไว้สำหรับปฏิเสธ -->
    <div id="reject_box" style="display: none; background: #fff5f5; padding: 15px; border-radius: 8px; border: 1px solid #feb2b2;">
        <label style="color: #c53030; font-weight: bold;">ระบุเหตุผลการปฏิเสธ:</label>
        <textarea name="reject_reason" class="form-control" rows="3" placeholder="ทำไมถึงไม่อนุมัติ..."></textarea>
        <button type="submit" name="reject_btn" class="btn btn-danger" style="margin-top: 10px; width: 100%;">ยืนยันการปฏิเสธ</button>
    </div>
</form>

<script>
function showRejectBox() {
    var box = document.getElementById('reject_box');
    box.style.display = (box.style.display === 'none') ? 'block' : 'none';
}
</script>
<?php endif; ?>

            </div>

            <!-- ฟอร์มบันทึกผลการนิเทศ -->
            <div class="card">
                <h3 class="card-title">บันทึกผลการนิเทศ</h3>
                <form action="teacher_detail.php?id=<?php echo $request_id; ?>" method="POST">
                    <div class="form-group">
                        <label>ผลการนิเทศ/หมายเหตุ:</label>
                        <textarea name="supervision_note" class="form-control" rows="8" placeholder="บันทึกผลการประเมินการปฏิบัติงานของนิสิต..."><?php echo htmlspecialchars($req['supervision_note'] ?? ''); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> บันทึกผลการนิเทศ</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
