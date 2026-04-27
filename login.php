<?php require 'db.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ - SWU Information Studies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;500&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<header>
   <div class="header">
      <div class="white_bg">
         <div class="container-fluid">
            
            <div class="row align-items-center g-0">
               <div class="col-lg-5 col-md-6 ps-0 logo_section">
                     <div class="center-desk">
                        <a href="#" style="display: flex; align-items: center;">
                           <img src="img/Srinakharinwirot_Logo (1).png" alt="Icon" class="logo_icon">
                           <div class="logo_text">
                           คณะมนุษยศาสตร์ หลักสูตรสารสนเทศศึกษา
                              <span>Srinakharinwirot University</span>
                           </div>
                        </a>
                  </div>
               </div>
               <div class="col-lg-7 col-md-6">
                  <nav class="navigation navbar navbar-expand-md navbar-dark">
                     <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04">
                        <span class="navbar-toggler-icon"></span>
                         </button>
                     <div class="collapse navbar-collapse" id="navbarsExample04">
                        <ul class="navbar-nav ms-auto">
                           <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                           <li class="nav-item"><a class="nav-link" href="index.php#news">ข่าวสาร</a></li>
                           <li class="nav-item"><a class="nav-link" href="index.php#activity">กิจกรรม</a></li>
                           <li class="nav-item"><a class="nav-link" href="#">นิสิต</a>
                              <ul class="dropdown">
                              <li><a href="member.php">เกี่ยวกับนิสิต</a></li>
                              <li><a href="course.php">เกี่ยวกับหลักสูตร</a></li>
                              <li><a href="course2.php">แผนการศึกษา</a></li>
                              </ul>
                           </li>
                           <li class="nav-item"><a class="nav-link" href="teachers.php">บุคลากร</a></li>
                           <li class="nav-item"><a class="nav-link" href="https://drive.google.com/file/d/1o4Z9JTbRhPV13Lgg8DGTI-sw7FfVjtIs/view">ขั้นตอนฝึกงาน</a></li>
                           <li class="nav-item d_none le_co active"><a class="nav-link" href="login.php"><i class="fa fa-user"></i> Login</a></li>
                        </ul>
                     </div>
                  </nav>
               </div>
            </div>

            <div class="container" style="min-height: 70vh; display: flex; align-items: center; justify-content: center;">
        
        <!-- Login Section -->
        <section id="login" class="login-container" style="width: 100%; max-width: 500px; margin: 0 auto;">
            <div class="card" style="background-color: var(--white); box-shadow: var(--shadow-lg); width: 100%; padding: 40px; border-radius: 15px;">   
            <h2 style="text-align:center; color: var(--primary-red); margin-bottom: 1.5rem; font-family: 'Prompt', sans-serif;">
            ระบบจัดการฝึกงาน (Internships)</h2>
            <?php if(isset($_GET['error']) && $_GET['error'] == 'invalid'): ?>
                <div class="alert alert-danger" style="color: red; text-align: center; margin-bottom: 1rem;">
                    Username หรือ Password ไม่ถูกต้อง</div>
            <?php endif; ?>
            <form action="login_process.php" method="POST">
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="username">Username (รหัสนิสิต / admin / teacher)</label>
                    <input type="text" id="username" name="username" class="form-control" required placeholder="เช่น 661000001" style="width: 100%; padding: 0.5rem;">
                </div>
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="password">Password (ค่าเริ่มต้น 1234)</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="ใส่รหัสผ่าน" style="width: 100%; padding: 0.5rem;">
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; background-color: var(--primary-red); color: white; border: none; cursor: pointer; border-radius: 5px;">
                <i class="fa fa-sign-in" aria-hidden="true"></i> เข้าสู่ระบบ
                </button>
            </form>
            </div>
        </section>

    </div>

         </div> 
      </div> 
   </div> 
</header>

    <footer>
        <p>&copy; 2026 Information Studies, Srinakharinwirot University. All rights reserved.</p>
    </footer>

</body>
</html>
