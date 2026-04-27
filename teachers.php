<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แผนการเรียน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;500&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="cstyle.css">
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
                           <li class="nav-item "><a class="nav-link" href="index.php">Home</a></li>
                           <li class="nav-item"><a class="nav-link" href="index.php#news">ข่าวสาร</a></li>
                           <li class="nav-item"><a class="nav-link" href="index.php#activity">กิจกรรม</a></li>
                           <li class="nav-item"><a class="nav-link" href="#">นิสิต</a>
                              <ul class="dropdown">
                              <li><a href="member.php">เกี่ยวกับนิสิต</a></li>
                              <li><a href="course.php">เกี่ยวกับหลักสูตร</a></li>
                              <li><a href="course2.php">แผนการศึกษา</a></li>
                              </ul>
                           </li>
                           <li class="nav-item active"><a class="nav-link" href="teachers.php">บุคลากร</a></li>
                           <li class="nav-item"><a class="nav-link" href="https://drive.google.com/file/d/1o4Z9JTbRhPV13Lgg8DGTI-sw7FfVjtIs/view">ขั้นตอนฝึกงาน</a></li>
                           <li class="nav-item d_none le_co"><a class="nav-link" href="login.php"><i class="fa fa-user"></i> Login</a></li>
                        </ul>
                     </div>
                  </nav>
               </div>
            </div>
         </div> 
      </div> 
   </div> 
</header>

    <div class="container">
    <h1>คณะอาจารย์</h1>

<!-- Content -->
<div class="containertc">
  

<?php
$teachers = [
  [
    "name_th" => "อาจารย์ ดร. ดิษฐ์ สุทธิวงศ์",
    "name_en" => "Lecturer Dit Suthiwong, Ph.D.",
    "position" => "ประธานกรรมการบริหารหลักสูตร",
    "email" => "dit@g.swu.ac.th",
    "image" => "https://is.hu.swu.ac.th/wp-content/uploads/2021/01/Dit-scaled.jpg"
  ],
  [
    "name_th" => "อาจารย์ ดร. ฐิติ อติชาติชยากร",
    "name_en" => "Lecturer Thiti Atichartchayakorn, Ph.D.",
    "position" => "เลขานุการหลักสูตร",
    "email" => "thitik@g.swu.ac.th",
    "image" => "https://is.hu.swu.ac.th/wp-content/uploads/2021/01/thiti-scaled.jpg"
  ],
  [
    "name_th" => "ผู้ช่วยศาสตราจารย์ ดร. วิภากร วัฒนสินธุ์",
    "name_en" => "Assistant Professor Vipakorn Vadhanasin, Ph.D., PMP, FHEA",
    "position" => "กรรมการหลักสูตร",
    "email" => "vipakorn@g.swu.ac.th",
    "image" => "https://is.hu.swu.ac.th/wp-content/uploads/2020/02/Vipakorn-683x1024.jpg"
  ],
  [
    "name_th" => "อาจารย์ ดร. โชคธำรงค์ จงจอหอ",
    "name_en" => "Lecturer Chokthamrong Chongchorhor, Ph.D.",
    "position" => "กรรมการหลักสูตร",
    "email" => "chokthamrong@g.swu.ac.th",
    "image" => "https://is.hu.swu.ac.th/wp-content/uploads/2025/02/Chokthamrong.jpg"
  ],
  [
    "name_th" => "อาจารย์โชติมา วัฒนะ",
    "name_en" => "Lecturer Chotima Watana",
    "position" => "กรรมการหลักสูตร",
    "email" => "chotimaw@g.swu.ac.th",
    "image" => "https://is.hu.swu.ac.th/wp-content/uploads/2025/11/Chotima.jpg"
  ],
  [
    "name_th" => "ผู้ช่วยศาสตราจารย์ ดร. ดุษฎี สีวังคำ",
    "name_en" => "Assistant Professor Dussadee Seewungkum, Ph.D.",
    "position" => "อาจารย์ผู้สอน",
    "email" => "dussadee@g.swu.ac.th",
    "image" => "https://is.hu.swu.ac.th/wp-content/uploads/2020/02/Dussadee-683x1024.jpg"
  ],
  [
    "name_th" => "ผู้ช่วยศาสตราจารย์ ดร. ศศิพิมล ประพินพงศกร",
    "name_en" => "Assistant Professor Sasipimol Prapinpongsakorn, Ph.D., FHEA",
    "position" => "อาจารย์ผู้สอน",
    "email" => "sasipimol@g.swu.ac.th",
    "image" => "https://is.hu.swu.ac.th/wp-content/uploads/2020/02/Sasipimol-683x1024.jpg"
  ],
  [
    "name_th" => "อาจารย์ ดร. ศุมรรษตรา แสนวา",
    "name_en" => "Lecturer Sumattra Saenwa, Ph.D., FHEA",
    "position" => "อาจารย์ผู้สอน",
    "email" => "sumattra@g.swu.ac.th",
    "image" => "https://is.hu.swu.ac.th/wp-content/uploads/2020/02/Sumattra-683x1024.jpg"
  ]
];

echo "<div class='grid'>";
foreach ($teachers as $t) {
  echo "
  <div class='cardtc'>
    <img src='{$t['image']}'>
    <div class='info'>
      <div class='name-th'>{$t['name_th']}</div>
      <div class='name-en'>{$t['name_en']}</div>
      <div class='position'>{$t['position']}</div>
      <div class='email'>📧 {$t['email']}</div>
    </div>
  </div>
  ";
}
echo "</div>";
?>

</div>
</div>

<!-- Footer Start -->
<footer class="footer-earth">
    <div class="container-earth">
        <div class="grid-earth">
            <!-- Column 1: About & Logo -->
            <div class="col-earth">
                <h3 class="sub-title-earth">มหาวิทยาลัยศรีนครินทรวิโรฒ</h3>
                <iframe 
                src="https://maps.google.com/maps?q=SWU&t=&z=13&ie=UTF8&iwloc=&output=embed"
                frameborder="0">
            </iframe>
            </div>
            <!-- Column 2: Contact Info -->
            <div class="col-earth">
                <h4 class="sub-title-earth">ช่องทางการติดต่อ</h4>
                <p class="text-earth">
                    <i class="fa fa-map-marker mr-2"></i> 114 สุขุมวิท 23 เขตวัฒนา กรุงเทพฯ 10110<br>
                    <i class="fa fa-phone mr-2"></i> +66 2-649-5000<br>
                    <i class="fa fa-envelope mr-2"></i> is@g.swu.ac.th
                </p>
            </div>
            <!-- Column 3: Social Media -->
            <div class="col-earth">
                <h4 class="sub-title-earth">ช่องทางการติดตาม</h4>
                <div class="icon-group-earth">
                    <a class="btn-social-earth" href="https://www.facebook.com/share/18aNYSbik1/?mibextid=wwXIfr"><i class="fa fa-facebook"> </i></a>
                    <a class="btn-social-earth" href="https://www.instagram.com/is.hmswu?igsh=MXRyc2RoaXVoOGxnbA=="><i class="fa fa-instagram"></i></a>
                    <a class="btn-social-earth" href="https://x.com/is__swu?s=21"><i class="fa fa-twitter"></i></a>
                </div>
            </div>
            </div>
        </div>
        
        <div class="copyright-earth">
            <p>&copy; 2026 Information Studies, SWU. All rights reserved.</p>
        </div>
    </div>
</footer>
<!-- Footer End -->

</body>
</html>