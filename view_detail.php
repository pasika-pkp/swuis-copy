<?php
require 'db.php';
checkRole('student');

$request_id = $_GET['id'] ?? null;

if (!$request_id) {
    header("Location: student_home.php");
    exit;
}

// ดึงข้อมูลอย่างละเอียด (Join ข้อมูลที่จำเป็นมาให้หมด)
$stmt = $pdo->prepare("
    SELECT r.*, c.company_name, c.address as company_address, c.contact_person, c.contact_phone, 
        c.contact_email
    FROM Internship_Request r
    JOIN Company c ON r.company_id = c.company_id
    WHERE r.request_id = ? AND r.student_id = ?
");
$stmt->execute([$request_id, $_SESSION['user_id']]);
$data = $stmt->fetch();

if (!$data) {
    die("ไม่พบข้อมูลคำขอ หรือคุณไม่มีสิทธิ์เข้าถึง");
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดคำขอ #<?php echo $data['request_id']; ?></title>
    <link rel="stylesheet" href="style_sst.css">
    <style>
    /* ปรับความกว้างและเพิ่มเงาให้ตัว Card */
    .card {
        max-width: 1000px;
        margin: 2rem auto; 
        background: #fff;
        border-radius: 15px; 
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); 
        border: none;
        overflow: hidden;
    }
    .card-body {
        padding: 40px; 
    }
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .note-box {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        border-left: 5px solid #ce1126; 
        margin-top: 10px;
        overflow-wrap: break-word; 
        white-space: normal;
    }
    .card-header{
        color: #ce1126;
    }
</style>

</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header ">
                <h3>รายละเอียดการยื่นคำขอฝึกงาน</h3>
                <p>สถานะปัจจุบัน: <?php echo getStatusBadge($data['status']); ?></p>
            </div>
            
            <div class="card-body">
                <div class="detail-grid">
                    <div>
                        <strong>บริษัท:</strong> 
                        <p><?php echo htmlspecialchars($data['company_name']); ?></p>
                    </div>
                    
                    <div>
                        <strong>ที่อยู่สถานประกอบการ:</strong> 
                        <p><?php echo nl2br(htmlspecialchars($data['company_address'])); ?></p>
                    </div>

                    <div>
                        <strong>ตำแหน่งที่ฝึกงาน:</strong> 
                        <p><?php echo htmlspecialchars($data['internship_position']); ?></p>
                    </div>
                     
                    <div>
                        <strong>ผู้ประสานงาน:</strong> 
                        <p><?php echo htmlspecialchars($data['contact_person']); ?></p>
                    </div>

                    <div>
                        <strong>เบอร์โทรศัพท์ติดต่อ:</strong> 
                        <p><?php echo htmlspecialchars($data['contact_phone'] ?? '-'); ?></p>
                    </div>
                    
                    <div>
                        <strong>อีเมลติดต่อ:</strong> 
                        <p><?php echo htmlspecialchars($data['contact_email'] ?? '-'); ?></p>
                    </div>

                    <div>
                        <strong>ช่วงเวลาฝึกงาน:</strong> 
                        <p><?php echo date('d/m/Y', strtotime($data['start_date'])); ?> ถึง <?php echo date('d/m/Y', strtotime($data['end_date'])); ?></p>
                    </div>
                </div>
                
                <hr>
                
                <h4>ผลการนิเทศ:</h4>
                <div class="note-box">
                    <?php echo $data['supervision_note'] ?: 'ไม่มีข้อความตอบกลับ'; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
