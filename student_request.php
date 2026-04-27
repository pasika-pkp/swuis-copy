<?php
require 'db.php';
checkRole('student');

// ดึงรายชื่อบริษัทที่มีอยู่แล้วมาทำ Auto-complete (datalist)
$stmt = $pdo->query("SELECT * FROM Company ORDER BY company_name");
$companies = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_name = trim($_POST['company_name']);
    $address = $_POST['address']; 
    $contact_person = $_POST['contact_person'];
    $contact_phone = $_POST['contact_phone'];
    $contact_email = trim($_POST['contact_email']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $student_id = $_SESSION['user_id'];
    $internship_position = trim($_POST['internship_position']);


     try {
        $checkStmt = $pdo->prepare("SELECT company_id FROM Company WHERE company_name = ?");
        $checkStmt->execute([$company_name]);
        $existingCompany = $checkStmt->fetch();

        if ($existingCompany) {
            $company_id = $existingCompany['company_id'];
            // อัปเดตข้อมูลติดต่อรวมถึงที่อยู่ (address)
            $updateStmt = $pdo->prepare("UPDATE Company SET address = ?, contact_person = ?, contact_phone = ?, contact_email = ? WHERE company_id = ?");
            $updateStmt->execute([$address, $contact_person, $contact_phone,$contact_email, $company_id]);
        } else {
            // เพิ่มบริษัทใหม่พร้อมที่อยู่ (address)
            $insertCompStmt = $pdo->prepare("INSERT INTO Company (company_name, address, contact_person, contact_phone, contact_email) VALUES (?, ?, ?, ?, ?)");
            $insertCompStmt->execute([$company_name, $address, $contact_person, $contact_phone, $contact_email]);
            $company_id = $pdo->lastInsertId();
        }

        // 2. บันทึกลงตาราง Internship_Request
        $stmt = $pdo->prepare("INSERT INTO Internship_Request (student_id, company_id, internship_position, start_date, end_date, status) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->execute([$student_id, $company_id, $internship_position, $start_date, $end_date]);


        header("Location: student_dashboard.php?success=1");
        exit();
        
    } catch (PDOException $e) {
        $error = "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ยื่นคำขอฝึกงาน - นิสิต</title>
    <link rel="stylesheet" href="style_sst.css">
    <link rel="stylesheet" href="https://cloudflare.com">
</head>
<body>

    <nav class="navbar">
        <div class="nav-brand">
            <img src="img/Srinakharinwirot_Logo (1).png" alt="SWU Logo" onerror="this.src='img/images.png'">
            <span>แบบฟอร์มยื่นคำขอฝึกงาน</span>
        </div>
        <div class="nav-links">
            <span style="margin-right: 1rem; font-weight: 500;">นิสิต: <?php echo htmlspecialchars($_SESSION['name']); ?></span>
            <a href="logout.php" class="btn-outline" style="padding: 0.4rem 1rem; border-radius: 50px;">ออกจากระบบ</a>
        </div>
    </nav>

    <div class="container-std">
        <div style="max-width: 600px; margin: 0 auto;">
            <div style="margin-bottom: 1rem;">
                <a href="student_dashboard.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> กลับไปหน้ารายการ</a>
            </div>

            <?php if(isset($error)): ?>
                <div style="color: red; margin-bottom: 1rem;"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="card">
                <h2 class="card-title">แบบฟอร์มยื่นคำขอฝึกงาน</h2>
                <form action="student_request.php" method="POST">
                    
                    <div class="form-group">
                        <label for="company_name">ชื่อสถานประกอบการ (พิมพ์ค้นหาหรือกรอกใหม่)</label>
                        <input type="text" name="company_name" id="company_name" class="form-control" list="company_list" placeholder="ระบุชื่อบริษัท..." required autocomplete="off">
                        <datalist id="company_list">
                            <?php foreach($companies as $c): ?>
                                <option value="<?php echo htmlspecialchars($c['company_name']); ?>">
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label for="address">ที่อยู่สถานประกอบการ</label>
                        <textarea name="address" id="address" class="form-control" rows="3" placeholder="ระบุเลขที่บ้าน, ถนน, แขวง/ตำบล, เขต/อำเภอ, จังหวัด..." required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="internship_position">ตำแหน่งที่ฝึกงาน</label>
                        <input type="text" name="internship_position" id="internship_position" class="form-control" placeholder="เช่น Software Engineer, ฝ่ายบุคคล" required>
                    </div>

                    <div class="form-group">
                        <label for="contact_person">ชื่อผู้ประสานงาน / ผู้ติดต่อ</label>
                        <input type="text" name="contact_person" id="contact_person" class="form-control" placeholder="เช่น คุณสมชาย ใจดี" required>
                    </div>

                    <div class="form-group">
                        <label for="contact_phone">เบอร์โทรศัพท์ติดต่อ</label>
                        <input type="text" name="contact_phone" id="contact_phone" class="form-control" placeholder="เช่น 0812345678" required>
                    </div>

                    <div class="form-group">
                        <label for="contact_email">อีเมลติดต่อ</label>
                        <input type="email" name="contact_email" id="contact_email" class="form-control" placeholder="เช่น somchai@email.com" required>
                    </div>

                    <div class="grid grid-2">
                        <div class="form-group">
                            <label for="start_date">วันที่เริ่มฝึกงาน</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="end_date">วันที่สิ้นสุดฝึกงาน</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                        <i class="fas fa-paper-plane"></i> ยืนยันการยื่นคำขอ
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
