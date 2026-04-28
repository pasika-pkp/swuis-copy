<?php

// =========================

// เชื่อมต่อฐานข้อมูล

// =========================

require 'db.php';


// =========================

// ตรวจสอบสิทธิ์ (เฉพาะ staff)

// =========================

checkRole('staff');


// =========================

// รับ request_id และแปลงเป็นตัวเลข

// =========================

$request_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


// =========================

// ดึงข้อมูลคำขอฝึกงาน

// =========================

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


// ถ้าไม่พบข้อมูล → redirect

if (!$req) {

    header("Location: staff_dashboard.php?error=notfound");

    exit();

}


// =========================

// กำหนด flow ของสถานะ

// =========================

$allowedFlow = [
    0 => [9],
    1 => [2, 9], // รับเรื่อง → อนุมัติ หรือ ยกเลิก

    2 => [3],    // อนุมัติ → ออกใบส่งตัว

    3 => [4],    // ออกใบ → เสร็จสิ้น

    4 => [],     // จบแล้ว

    9 => []      // ยกเลิก (จบ)

];


$statusLabels = [
    0 => 'ปฏิเสธการอนุมัติ',

    1 => 'รับเรื่องเข้าระบบ',

    2 => 'อาจารย์ที่ปรึกษาอนุมัติ',

    3 => 'ออกใบส่งตัวแล้ว',

    4 => 'ฝึกงานเสร็จสิ้น',

    9 => 'ยกเลิก'

];


// =========================

// อัปเดตสถานะ

// =========================

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_status'])) {


    $current_status = $req['status'];

    $new_status = (int)$_POST['new_status'];


    if (!in_array($new_status, $allowedFlow[$current_status])) {

        die("ไม่สามารถเปลี่ยนสถานะนี้ได้");

    }


    try {

        $pdo->beginTransaction();


        $log_stmt = $pdo->prepare("

            INSERT INTO Status_Log (request_id, old_status, new_status, changed_by)

            VALUES (?, ?, ?, ?)

        ");

        $log_stmt->execute([

            $request_id,

            $current_status,

            $new_status,

            $_SESSION['name']

        ]);


        $up_stmt = $pdo->prepare("

            UPDATE Internship_Request

            SET status = ?

            WHERE request_id = ?

        ");

        $up_stmt->execute([$new_status, $request_id]);


        $pdo->commit();


        header("Location: staff_dashboard.php?updated=1");

        exit();


    } catch (Exception $e) {

        $pdo->rollBack();

        die("เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $e->getMessage());

    }

}


?>


<!DOCTYPE html>

<html lang="th">

<head>

    <meta charset="UTF-8">

    <title>รายละเอียดคำขอฝึกงาน #<?php echo htmlspecialchars($request_id); ?></title>

    <link rel="stylesheet" href="style_sst.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <style>

        body { font-family: sans-serif; background: #f4f7f6; padding: 20px; }

        .container { max-width: 800px; margin: auto; }

        .card { background: #fff; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

        .badge { padding: 5px 10px; border-radius: 4px; color: white; font-size: 0.9em; }

        .bg-1 { background: #6c757d; } .bg-2 { background: #0d6efd; }

        .bg-3 { background: #ffc107; color: #000; } .bg-4 { background: #198754; }

        .bg-9 { background: #dc3545; }

        select, button { padding: 8px; margin-top: 10px; }

        button { background: #0d6efd; color: white; border: none; cursor: pointer; border-radius: 4px; }

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

        <a href="logout.php" class="btn-outline" style="padding: 0.4rem 1rem; border-radius: 50px;">ออกจากระบบ</a>

    </div>

</nav>


<div class="container">

    <div style="margin-bottom: 2rem;">

        <a href="staff_dashboard.php"class="btn btn-outline"><i class="fas fa-arrow-left"></i> กลับหน้ารายการทั้งหมด</a>

    </div>


    <div class="grid-2">

        <div class="card">

            <h3>ข้อมูลนิสิต</h3>

            <p><b>รหัสนิสิต:</b> <?php echo htmlspecialchars($req['st_id']); ?></p>

            <p><b>ชื่อ:</b> <?php echo htmlspecialchars($req['first_name'].' '.$req['last_name']); ?></p>

            <p><b>ชั้นปี:</b> <?php echo htmlspecialchars($req['year']); ?></p>

            <p><b>อีเมล:</b> <?php echo htmlspecialchars($req['email']); ?></p>

            <p><b>เบอร์:</b> <?php echo htmlspecialchars($req['phone']); ?></p>

            <h3 style="margin-top: 1rem;">ข้อมูลฝึกงาน</h3>

            <p><b>บริษัท:</b> <?php echo htmlspecialchars($req['company_name']); ?></p>

            <p><b>ที่อยู่สถานประกอบการ:</b> <?php echo htmlspecialchars($req['address']); ?></p>

            <p><b>ตำแหน่งที่ฝึกงาน:</b> <?php echo htmlspecialchars($req['internship_position']); ?></p>
            
            <p><b>ผู้ประสานงาน:</b> <?php echo htmlspecialchars($req['contact_person']); ?></p>
            
            <p><b>เบอร์โทรศัพท์ติดต่อ:</b> <?php echo htmlspecialchars($req['contact_phone']); ?></p>
            
            <p><b>อีเมลติดต่อ:</b> <?php echo htmlspecialchars($req['contact_email']?? '-' ); ?></p>

            <p><b>ระยะเวลา:</b>

                <?php echo date('d/m/Y', strtotime($req['start_date'])); ?> -

                <?php echo date('d/m/Y', strtotime($req['end_date'])); ?>

            </p>

            <p><b>สถานะ:</b> <?php echo getStatusBadge($req['status']); ?></p>

        </div>


        <div class="card">

            <h3>แก้ไขสถานะ</h3>

            <form method="POST" action="staff_detail.php?id=<?php echo (int)$request_id; ?>">

                <label>เลือกสถานะใหม่:</label>

                <select name="new_status" required>

                    <?php

                    $current = $req['status'];

                    $allStatus = [1, 2, 3, 4, 9];


                    foreach ($allStatus as $s):

                    ?>

                    <option value="<?php echo $s; ?>"

                        <?php

                        if ($s == $current) echo 'selected';

                        elseif (!in_array($s, $allowedFlow[$current])) echo 'disabled';

                        ?>

                    >

                        <?php echo htmlspecialchars($statusLabels[$s]); ?>

                    </option>

                    <?php endforeach; ?>

                </select>

                <br><br>

                <button type="submit" class= "btn btn-success" >บันทึกสถานะ</button>

            </form>

        </div>

    </div>

</div>


</body>

</html>