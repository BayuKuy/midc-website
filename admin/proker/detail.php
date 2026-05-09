<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login.php");
    exit;
}

include '../../config/koneksi.php';

/*
|--------------------------------------------------------------------------
| VALIDASI ID
|--------------------------------------------------------------------------
*/

if(!isset($_GET['id'])){

    header("Location: index.php");

    exit;

}

$id = $_GET['id'];

/*
|--------------------------------------------------------------------------
| AMBIL DATA PROGRAM
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn, "SELECT * FROM program_kerja WHERE id_program='$id'");

$data = mysqli_fetch_assoc($query);

/*
|--------------------------------------------------------------------------
| JIKA DATA TIDAK ADA
|--------------------------------------------------------------------------
*/

if(!$data){

    header("Location: index.php");

    exit;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Program Kerja</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">

    <style>

        .detail-wrapper{
            padding:30px;
        }

        /* Hero */

        .hero-card{
            position:relative;
            border-radius:28px;
            overflow:hidden;
            margin-bottom:30px;
            height:350px;
        }

        .hero-image{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .hero-overlay{
            position:absolute;
            inset:0;
            background:linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        }

        .hero-content{
            position:absolute;
            bottom:30px;
            left:30px;
            color:white;
            z-index:2;
        }

        .hero-division{
            font-size:14px;
            font-weight:600;
            opacity:0.9;
            margin-bottom:10px;
        }

        .hero-title{
            font-size:36px;
            font-weight:700;
            margin-bottom:15px;
        }

        .status-badge{
            display:inline-block;
            padding:8px 16px;
            border-radius:999px;
            font-size:13px;
            font-weight:600;
        }

        .planning{
            background:#fef3c7;
            color:#d97706;
        }

        .running{
            background:#dbeafe;
            color:#2563eb;
        }

        .done{
            background:#dcfce7;
            color:#16a34a;
        }

        /* Card */

        .detail-card{
            background:white;
            border-radius:24px;
            padding:25px;
            box-shadow:0 5px 20px rgba(0,0,0,0.04);
            margin-bottom:25px;
        }

        .card-title{
            font-size:20px;
            font-weight:700;
            margin-bottom:20px;
            color:#0f172a;
        }

        /* Progress */

        .progress-label{
            display:flex;
            justify-content:space-between;
            margin-bottom:10px;
        }

        .progress{
            height:14px;
            border-radius:999px;
        }

        .progress-bar{
            font-weight:600;
        }

        /* Timeline */

        .timeline-item{
            display:flex;
            gap:15px;
            margin-bottom:25px;
        }

        .timeline-dot{
            width:16px;
            height:16px;
            background:#2563eb;
            border-radius:50%;
            margin-top:6px;
        }

        .timeline-content h6{
            font-weight:700;
            margin-bottom:5px;
        }

        .timeline-content p{
            margin:0;
            color:#64748b;
            font-size:14px;
        }

        /* Info */

        .info-item{
            display:flex;
            justify-content:space-between;
            margin-bottom:18px;
            font-size:15px;
        }

        .info-item span{
            color:#64748b;
        }

        .info-item strong{
            color:#0f172a;
        }

    </style>

</head>
<body>

<?php include '../../includes/sidebar.php'; ?>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="main-content">

<?php include '../../includes/navbar_admin.php'; ?>

<div class="detail-wrapper">

    <!-- HERO -->

    <div class="hero-card">

        <img 
            src="../../assets/uploads/program/<?= $data['thumbnail']; ?>"
            class="hero-image"
        >

        <div class="hero-overlay"></div>

        <div class="hero-content">

            <div class="hero-division">

                <?= $data['divisi']; ?>

            </div>

            <div class="hero-title">

                <?= $data['nama_program']; ?>

            </div>

            <!-- STATUS -->

            <?php if($data['status'] == 'Perencanaan') : ?>

                <span class="status-badge planning">
                    Perencanaan
                </span>

            <?php elseif($data['status'] == 'Berjalan') : ?>

                <span class="status-badge running">
                    Berjalan
                </span>

            <?php else : ?>

                <span class="status-badge done">
                    Selesai
                </span>

            <?php endif; ?>

        </div>

    </div>

    <div class="row">

        <!-- LEFT -->

        <div class="col-lg-8">

            <!-- PROGRESS -->

            <div class="detail-card">

                <div class="card-title">
                    Progress Program
                </div>

                <div class="progress-label">

                    <span>Status Progress</span>

                    <strong><?= $data['progress']; ?>%</strong>

                </div>

                <div class="progress">

                    <div 
                        class="progress-bar"
                        style="width: <?= $data['progress']; ?>%"
                    >

                        <?= $data['progress']; ?>%

                    </div>

                </div>

            </div>

            <!-- TUJUAN -->

            <div class="detail-card">

                <div class="card-title">
                    Tujuan Program
                </div>

                <p class="text-secondary lh-lg">

                    <?= $data['tujuan']; ?>

                </p>

            </div>

            <!-- TIMELINE -->

            <div class="detail-card">

                <div class="card-title">
                    Timeline Program
                </div>

                <div class="timeline-item">

                    <div class="timeline-dot"></div>

                    <div class="timeline-content">

                        <h6>Perencanaan</h6>

                        <p>
                            Penyusunan konsep dan strategi program kerja.
                        </p>

                    </div>

                </div>

                <div class="timeline-item">

                    <div class="timeline-dot"></div>

                    <div class="timeline-content">

                        <h6>Pelaksanaan</h6>

                        <p>
                            Program mulai dijalankan oleh divisi terkait.
                        </p>

                    </div>

                </div>

                <div class="timeline-item">

                    <div class="timeline-dot"></div>

                    <div class="timeline-content">

                        <h6>Evaluasi</h6>

                        <p>
                            Evaluasi hasil program dan dokumentasi kegiatan.
                        </p>

                    </div>

                </div>

            </div>

        </div>

        <!-- RIGHT -->

        <div class="col-lg-4">

            <!-- INFO -->

            <div class="detail-card">

                <div class="card-title">
                    Informasi Program
                </div>

                <div class="info-item">

                    <span>Divisi</span>

                    <strong><?= $data['divisi']; ?></strong>

                </div>

                <div class="info-item">

                    <span>Timeline</span>

                    <strong><?= $data['timeline']; ?></strong>

                </div>

                <div class="info-item">

                    <span>Target</span>

                    <strong><?= $data['target_program']; ?></strong>

                </div>

                <div class="info-item">

                    <span>Status</span>

                    <strong><?= $data['status']; ?></strong>

                </div>

                <div class="info-item">

                    <span>Dibuat</span>

                    <strong>

                        <?= date('d M Y', strtotime($data['created_at'])); ?>

                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

<!-- JS -->
<script src="../../assets/js/admin.js"></script>

</body>
</html>