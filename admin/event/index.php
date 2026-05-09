<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login.php");
    exit;
}

include '../../config/koneksi.php';

/*
|--------------------------------------------------------------------------
| FLASH MESSAGE
|--------------------------------------------------------------------------
*/

$success = "";

$error = "";

if(isset($_SESSION['success'])){

    $success = $_SESSION['success'];

    unset($_SESSION['success']);

}

if(isset($_SESSION['error'])){

    $error = $_SESSION['error'];

    unset($_SESSION['error']);

}

/*
|--------------------------------------------------------------------------
| AMBIL DATA EVENT
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn, "SELECT * FROM event ORDER BY id_event DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Event</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>

        .page-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
            flex-wrap:wrap;
            gap:15px;
        }

        .btn-add{
            background:#2563eb;
            color:white;
            border:none;
            padding:12px 18px;
            border-radius:12px;
            text-decoration:none;
            transition:0.3s;
        }

        .btn-add:hover{
            background:#1d4ed8;
            color:white;
        }

        /* Card */

        .event-card{
            background:white;
            border-radius:24px;
            overflow:hidden;
            box-shadow:0 5px 20px rgba(0,0,0,0.04);
            transition:0.3s;
            height:100%;
        }

        .event-card:hover{
            transform:translateY(-5px);
        }

        .event-image{
            width:100%;
            height:230px;
            object-fit:cover;
        }

        .event-content{
            padding:20px;
        }

        .event-date{
            font-size:14px;
            color:#64748b;
            margin-bottom:10px;
        }

        .event-title{
            font-size:20px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:12px;
        }

        .event-location{
            font-size:14px;
            color:#475569;
            margin-bottom:15px;
        }

        /* Status Badge */

        .badge-status{
            display:inline-block;
            padding:8px 14px;
            border-radius:999px;
            font-size:13px;
            font-weight:600;
            margin-bottom:20px;
        }

        .upcoming{
            background:#dbeafe;
            color:#2563eb;
        }

        .selesai{
            background:#dcfce7;
            color:#16a34a;
        }

        /* Footer */

        .event-footer{
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .action-btn{
            display:flex;
            gap:10px;
        }

        .btn-edit,
        .btn-delete{
            width:38px;
            height:38px;
            border:none;
            border-radius:10px;
            display:flex;
            justify-content:center;
            align-items:center;
            text-decoration:none;
        }

        .btn-edit{
            background:#dbeafe;
            color:#2563eb;
        }

        .btn-delete{
            background:#fee2e2;
            color:#dc2626;
        }

    </style>

</head>
<body>

    <?php include '../../includes/sidebar.php'; ?>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="main-content">

        <?php include '../../includes/navbar_admin.php'; ?>

        <div class="container-fluid p-4">

            <!-- HEADER -->

            <div class="page-header">

                <div>

                    <h3 class="fw-bold mb-1">
                        Kelola Event
                    </h3>

                    <p class="text-secondary">
                        Manajemen kegiatan dan event MIDC
                    </p>

                </div>

                <a href="tambah.php" class="btn-add">

                    <i class="fa-solid fa-plus"></i>

                    Tambah Event

                </a>

            </div>

            <!-- EVENT CARD -->

            <div class="row">

                <?php while($data = mysqli_fetch_assoc($query)) : ?>

                    <div class="col-lg-4 col-md-6 mb-4">

                        <div class="event-card">

                            <!-- POSTER -->

                            <img 
                                src="../../assets/uploads/event/<?= $data['poster']; ?>"
                                class="event-image"
                            >

                            <div class="event-content">

                                <!-- DATE -->

                                <div class="event-date">

                                    <i class="fa-regular fa-calendar"></i>

                                    <?= date('d F Y', strtotime($data['tanggal'])); ?>

                                </div>

                                <!-- TITLE -->

                                <div class="event-title">

                                    <?= $data['nama_event']; ?>

                                </div>

                                <!-- LOCATION -->

                                <div class="event-location">

                                    <i class="fa-solid fa-location-dot"></i>

                                    <?= $data['lokasi']; ?>

                                </div>

                                <!-- STATUS -->

                                <?php if($data['status'] == 'Upcoming') : ?>

                                    <span class="badge-status upcoming">

                                        Upcoming

                                    </span>

                                <?php else : ?>

                                    <span class="badge-status selesai">

                                        Selesai

                                    </span>

                                <?php endif; ?>

                                <!-- FOOTER -->

                                <div class="event-footer">

                                    <small class="text-secondary">
                                        MIDC Event
                                    </small>

                                    <div class="action-btn">

                                        <!-- EDIT -->

                                        <a href="edit.php?id=<?= $data['id_event']; ?>" class="btn-edit">

                                            <i class="fa-solid fa-pen"></i>

                                        </a>

                                        <!-- DELETE -->

                                        <a 
                                            href="#"
                                            class="btn-delete"
                                            onclick="confirmDelete(<?= $data['id_event']; ?>)"
                                        >

                                            <i class="fa-solid fa-trash"></i>

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

        </div>

    </div>

    <!-- JS -->
    <script src="../../assets/js/admin.js"></script>

    <!-- DELETE -->

    <script>

        function confirmDelete(id){

            Swal.fire({

                title: 'Hapus event?',

                text: 'Event yang dihapus tidak bisa dikembalikan!',

                icon: 'warning',

                showCancelButton: true,

                confirmButtonColor: '#dc2626',

                cancelButtonColor: '#64748b',

                confirmButtonText: 'Ya, hapus!',

                cancelButtonText: 'Batal'

            }).then((result) => {

                if(result.isConfirmed){

                    window.location.href = 'hapus.php?id=' + id;

                }

            });

        }

    </script>

    <!-- SUCCESS -->

    <?php if($success != "") : ?>

    <script>

        Swal.fire({

            icon: 'success',

            title: 'Berhasil!',

            text: '<?= $success; ?>',

            confirmButtonColor: '#2563eb'

        });

    </script>

    <?php endif; ?>

    <!-- ERROR -->

    <?php if($error != "") : ?>

    <script>

        Swal.fire({

            icon: 'error',

            title: 'Oops...',

            text: '<?= $error; ?>',

            confirmButtonColor: '#dc2626'

        });

    </script>

    <?php endif; ?>

</body>
</html>