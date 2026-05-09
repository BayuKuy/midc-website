<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

include '../config/koneksi.php';

/*
|--------------------------------------------------------------------------
| TOTAL DATA
|--------------------------------------------------------------------------
*/

$total_berita = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM berita"));

$total_event = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM event"));

$total_program = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM program_kerja"));

$total_pengurus = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pengurus"));

$total_divisi = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM divisi"));

/*
|--------------------------------------------------------------------------
| DATA TERBARU
|--------------------------------------------------------------------------
*/

$berita_terbaru = mysqli_query(
    $conn,
    "SELECT * FROM berita ORDER BY id_berita DESC LIMIT 3"
);

$event_terbaru = mysqli_query(
    $conn,
    "SELECT * FROM event ORDER BY id_event DESC LIMIT 3"
);

$divisi = mysqli_query(
    $conn,
    "SELECT * FROM divisi ORDER BY id_divisi DESC LIMIT 4"
);

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard MIDC</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/admin.css">

    <style>

        body{
            background:#f8fafc;
        }

        .dashboard-wrapper{
            padding:30px;
        }

        /* HERO */

        .hero-dashboard{
            background:linear-gradient(135deg,#2563eb,#4f46e5);
            border-radius:34px;
            padding:40px;
            color:white;
            position:relative;
            overflow:hidden;
            margin-bottom:30px;
        }

        .hero-dashboard::before{
            content:'';
            position:absolute;
            width:350px;
            height:350px;
            border-radius:50%;
            background:rgba(255,255,255,0.08);
            top:-150px;
            right:-100px;
        }

        .hero-content{
            position:relative;
            z-index:2;
        }

        .hero-title{
            font-size:38px;
            font-weight:700;
            margin-bottom:10px;
        }

        .hero-subtitle{
            opacity:0.95;
            line-height:1.8;
            max-width:700px;
        }

        .hero-date{
            margin-top:25px;
            display:inline-flex;
            align-items:center;
            gap:10px;
            background:rgba(255,255,255,0.12);
            padding:12px 18px;
            border-radius:16px;
            font-size:14px;
        }

        /* Analytics */

        .analytics-card{
            background:white;
            border-radius:28px;
            padding:28px;
            box-shadow:0 5px 20px rgba(0,0,0,0.04);
            height:100%;
            transition:0.3s;
        }

        .analytics-card:hover{
            transform:translateY(-4px);
        }

        .analytics-top{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:25px;
        }

        .analytics-icon{
            width:65px;
            height:65px;
            border-radius:20px;
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:26px;
        }

        .analytics-title{
            color:#64748b;
            margin-bottom:10px;
        }

        .analytics-value{
            font-size:36px;
            font-weight:700;
            color:#0f172a;
        }

        /* Section */

        .section-card{
            background:white;
            border-radius:28px;
            padding:28px;
            box-shadow:0 5px 20px rgba(0,0,0,0.04);
            margin-top:30px;
        }

        .section-title{
            font-size:24px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:25px;
        }

        /* Timeline */

        .timeline-item{
            display:flex;
            gap:18px;
            margin-bottom:25px;
        }

        .timeline-dot{
            width:14px;
            height:14px;
            border-radius:50%;
            background:#2563eb;
            margin-top:8px;
        }

        .timeline-title{
            font-weight:700;
            color:#0f172a;
            margin-bottom:6px;
        }

        .timeline-date{
            color:#64748b;
            font-size:14px;
        }

        /* Quick Action */

        .quick-grid{
            display:grid;
            grid-template-columns:repeat(2,1fr);
            gap:18px;
        }

        .quick-btn{
            background:#f8fafc;
            border-radius:22px;
            padding:24px;
            text-decoration:none;
            transition:0.3s;
            color:#0f172a;
        }

        .quick-btn:hover{
            transform:translateY(-3px);
            background:#eff6ff;
        }

        .quick-icon{
            width:55px;
            height:55px;
            border-radius:18px;
            background:#dbeafe;
            color:#2563eb;
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:22px;
            margin-bottom:18px;
        }

        .quick-title{
            font-weight:700;
            margin-bottom:8px;
        }

        .quick-text{
            font-size:14px;
            color:#64748b;
        }

        /* Division */

        .division-item{
            background:#f8fafc;
            border-radius:22px;
            padding:22px;
            margin-bottom:18px;
        }

        .division-name{
            font-size:20px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:10px;
        }

        .division-meta{
            display:flex;
            gap:15px;
            flex-wrap:wrap;
            margin-top:15px;
        }

        .division-badge{
            background:white;
            border-radius:999px;
            padding:8px 14px;
            font-size:13px;
            color:#475569;
        }

        /* Responsive */

        @media(max-width:768px){

            .hero-title{
                font-size:28px;
            }

            .quick-grid{
                grid-template-columns:1fr;
            }

        }

    </style>

</head>
<body>

<?php include '../includes/sidebar.php'; ?>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="main-content">

<?php include '../includes/navbar_admin.php'; ?>

<div class="dashboard-wrapper">

    <!-- HERO -->

    <div class="hero-dashboard">

        <div class="hero-content">

            <div class="hero-title">

                Selamat Datang,
                <?= $_SESSION['nama']; ?> 👋

            </div>

            <div class="hero-subtitle">

                Sistem informasi organisasi MIDC berjalan dengan baik hari ini.
                Kelola berita, event, pengurus, program kerja, dan arsip organisasi dalam satu dashboard terintegrasi.

            </div>

            <div class="hero-date">

                <i class="fa-regular fa-calendar"></i>

                <?= date('d F Y'); ?>

            </div>

        </div>

    </div>

    <!-- ANALYTICS -->

    <div class="row">

        <!-- BERITA -->

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="analytics-card">

                <div class="analytics-top">

                    <div>

                        <div class="analytics-title">
                            Total Berita
                        </div>

                        <div class="analytics-value">

                            <?= $total_berita; ?>

                        </div>

                    </div>

                    <div 
                        class="analytics-icon"
                        style="background:#dbeafe;color:#2563eb"
                    >

                        <i class="fa-solid fa-newspaper"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- EVENT -->

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="analytics-card">

                <div class="analytics-top">

                    <div>

                        <div class="analytics-title">
                            Total Event
                        </div>

                        <div class="analytics-value">

                            <?= $total_event; ?>

                        </div>

                    </div>

                    <div 
                        class="analytics-icon"
                        style="background:#dcfce7;color:#16a34a"
                    >

                        <i class="fa-solid fa-calendar-days"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- PROGRAM -->

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="analytics-card">

                <div class="analytics-top">

                    <div>

                        <div class="analytics-title">
                            Program Kerja
                        </div>

                        <div class="analytics-value">

                            <?= $total_program; ?>

                        </div>

                    </div>

                    <div 
                        class="analytics-icon"
                        style="background:#ede9fe;color:#7c3aed"
                    >

                        <i class="fa-solid fa-layer-group"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- PENGURUS -->

        <div class="col-lg-6 mb-4">

            <div class="analytics-card">

                <div class="analytics-top">

                    <div>

                        <div class="analytics-title">
                            Total Pengurus
                        </div>

                        <div class="analytics-value">

                            <?= $total_pengurus; ?>

                        </div>

                    </div>

                    <div 
                        class="analytics-icon"
                        style="background:#fee2e2;color:#dc2626"
                    >

                        <i class="fa-solid fa-users"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- DIVISI -->

        <div class="col-lg-6 mb-4">

            <div class="analytics-card">

                <div class="analytics-top">

                    <div>

                        <div class="analytics-title">
                            Total Divisi
                        </div>

                        <div class="analytics-value">

                            <?= $total_divisi; ?>

                        </div>

                    </div>

                    <div 
                        class="analytics-icon"
                        style="background:#fef3c7;color:#d97706"
                    >

                        <i class="fa-solid fa-building"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <!-- AKTIVITAS -->

        <div class="col-lg-7">

            <div class="section-card">

                <div class="section-title">
                    Aktivitas Terbaru
                </div>

                <!-- BERITA -->

                <?php while($b = mysqli_fetch_assoc($berita_terbaru)) : ?>

                    <div class="timeline-item">

                        <div class="timeline-dot"></div>

                        <div>

                            <div class="timeline-title">

                                Berita:
                                <?= $b['judul']; ?>

                            </div>

                            <div class="timeline-date">

                                <?= date('d F Y', strtotime($b['tanggal'])); ?>

                            </div>

                        </div>

                    </div>

                <?php endwhile; ?>

                <!-- EVENT -->

                <?php while($e = mysqli_fetch_assoc($event_terbaru)) : ?>

                    <div class="timeline-item">

                        <div 
                            class="timeline-dot"
                            style="background:#16a34a"
                        ></div>

                        <div>

                            <div class="timeline-title">

                                Event:
                                <?= $e['nama_event']; ?>

                            </div>

                            <div class="timeline-date">

                                <?= date('d F Y', strtotime($e['tanggal'])); ?>

                            </div>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

        </div>

        <!-- QUICK ACCESS -->

        <div class="col-lg-5">

            <div class="section-card">

                <div class="section-title">
                    Quick Access
                </div>

                <div class="quick-grid">

                    <a href="berita/tambah.php" class="quick-btn">

                        <div class="quick-icon">

                            <i class="fa-solid fa-newspaper"></i>

                        </div>

                        <div class="quick-title">
                            Tambah Berita
                        </div>

                        <div class="quick-text">
                            Publikasikan berita terbaru MIDC
                        </div>

                    </a>

                    <a href="event/tambah.php" class="quick-btn">

                        <div class="quick-icon">

                            <i class="fa-solid fa-calendar"></i>

                        </div>

                        <div class="quick-title">
                            Tambah Event
                        </div>

                        <div class="quick-text">
                            Kelola kegiatan organisasi
                        </div>

                    </a>

                    <a href="pengurus/tambah.php" class="quick-btn">

                        <div class="quick-icon">

                            <i class="fa-solid fa-users"></i>

                        </div>

                        <div class="quick-title">
                            Tambah Pengurus
                        </div>

                        <div class="quick-text">
                            Kelola anggota organisasi
                        </div>

                    </a>

                    <a href="divisi/tambah.php" class="quick-btn">

                        <div class="quick-icon">

                            <i class="fa-solid fa-building"></i>

                        </div>

                        <div class="quick-title">
                            Tambah Divisi
                        </div>

                        <div class="quick-text">
                            Bangun struktur organisasi
                        </div>

                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- DIVISI -->

    <div class="section-card">

        <div class="section-title">
            Department Performance
        </div>

        <?php while($d = mysqli_fetch_assoc($divisi)) : ?>

            <?php

            $nama_divisi = $d['nama_divisi'];

            $anggota = mysqli_num_rows(mysqli_query(
                $conn,
                "SELECT * FROM pengurus WHERE divisi='$nama_divisi'"
            ));

            $program = mysqli_num_rows(mysqli_query(
                $conn,
                "SELECT * FROM program_kerja WHERE divisi='$nama_divisi'"
            ));

            ?>

            <div class="division-item">

                <div class="division-name">

                    <?= $d['nama_divisi']; ?>

                </div>

                <div class="text-secondary">

                    <?= $d['fokus_divisi']; ?>

                </div>

                <div class="division-meta">

                    <div class="division-badge">

                        👥 <?= $anggota; ?> Pengurus

                    </div>

                    <div class="division-badge">

                        📁 <?= $program; ?> Program

                    </div>

                    <div class="division-badge">

                        👑 <?= $d['ketua_divisi']; ?>

                    </div>

                </div>

            </div>

        <?php endwhile; ?>

    </div>

</div>

</div>

<!-- JS -->
<script src="../assets/js/admin.js"></script>

</body>
</html>