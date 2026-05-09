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
| AMBIL DATA EVENT
|--------------------------------------------------------------------------
*/

$query = mysqli_query($conn, "SELECT * FROM event WHERE id_event='$id'");

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

/*
|--------------------------------------------------------------------------
| UPDATE EVENT
|--------------------------------------------------------------------------
*/

if(isset($_POST['update'])){

    $nama_event = mysqli_real_escape_string($conn, $_POST['nama_event']);

    $tanggal = $_POST['tanggal'];

    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);

    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $status = $_POST['status'];

    /*
    |--------------------------------------------------------------------------
    | CEK POSTER BARU
    |--------------------------------------------------------------------------
    */

    if($_FILES['poster']['name'] != ""){

        // HAPUS POSTER LAMA

        $poster_lama = "../../assets/uploads/event/" . $data['poster'];

        if(file_exists($poster_lama)){

            unlink($poster_lama);

        }

        // UPLOAD POSTER BARU

        $poster = $_FILES['poster']['name'];

        $tmp = $_FILES['poster']['tmp_name'];

        $nama_poster = time() . '-' . $poster;

        move_uploaded_file($tmp, "../../assets/uploads/event/" . $nama_poster);

    }else{

        // PAKAI POSTER LAMA

        $nama_poster = $data['poster'];

    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATABASE
    |--------------------------------------------------------------------------
    */

    $update = mysqli_query($conn, "UPDATE event SET

        nama_event = '$nama_event',
        tanggal = '$tanggal',
        lokasi = '$lokasi',
        deskripsi = '$deskripsi',
        poster = '$nama_poster',
        status = '$status'

        WHERE id_event = '$id'

    ");

    /*
    |--------------------------------------------------------------------------
    | FLASH MESSAGE
    |--------------------------------------------------------------------------
    */

    if($update){

        $_SESSION['success'] = "Event berhasil diperbarui!";

    }else{

        $_SESSION['error'] = "Event gagal diperbarui!";

    }

    header("Location: index.php");

    exit;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">

    <style>

        .event-wrapper{
            padding:30px;
        }

        .page-title h3{
            font-weight:700;
            color:#0f172a;
        }

        .page-title p{
            color:#64748b;
        }

        .event-card{
            background:white;
            border-radius:24px;
            padding:25px;
            box-shadow:0 5px 20px rgba(0,0,0,0.04);
            margin-bottom:25px;
        }

        .form-label{
            font-weight:600;
            color:#334155;
            margin-bottom:10px;
        }

        .form-control,
        .form-select{
            border:1px solid #e2e8f0;
            border-radius:14px;
            padding:14px;
            box-shadow:none;
        }

        .form-control:focus,
        .form-select:focus{
            border-color:#2563eb;
            box-shadow:0 0 0 4px rgba(37,99,235,0.1);
        }

        textarea{
            min-height:220px;
            resize:none;
        }

        /* Upload */

        .upload-box{
            border:2px dashed #cbd5e1;
            border-radius:20px;
            padding:25px;
            text-align:center;
            transition:0.3s;
            cursor:pointer;
        }

        .upload-box:hover{
            border-color:#2563eb;
            background:#f8fafc;
        }

        .preview-image{
            width:100%;
            border-radius:18px;
            margin-top:20px;
            max-height:250px;
            object-fit:cover;
        }

        .btn-update{
            width:100%;
            border:none;
            border-radius:14px;
            padding:14px;
            background:linear-gradient(135deg,#2563eb,#4f46e5);
            color:white;
            font-weight:600;
            transition:0.3s;
        }

        .btn-update:hover{
            transform:translateY(-2px);
            box-shadow:0 10px 20px rgba(37,99,235,0.2);
        }

    </style>

</head>
<body>

<?php include '../../includes/sidebar.php'; ?>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="main-content">

<?php include '../../includes/navbar_admin.php'; ?>

<div class="event-wrapper">

    <!-- TITLE -->

    <div class="page-title mb-4">

        <h3>Edit Event</h3>

        <p>
            Perbarui informasi kegiatan MIDC
        </p>

    </div>

    <!-- FORM -->

    <form action="" method="POST" enctype="multipart/form-data">

        <div class="row">

            <!-- LEFT -->

            <div class="col-lg-8">

                <div class="event-card">

                    <!-- NAMA EVENT -->

                    <div class="mb-4">

                        <label class="form-label">
                            Nama Event
                        </label>

                        <input 
                            type="text"
                            name="nama_event"
                            class="form-control"
                            value="<?= $data['nama_event']; ?>"
                            required
                        >

                    </div>

                    <!-- LOKASI -->

                    <div class="mb-4">

                        <label class="form-label">
                            Lokasi Event
                        </label>

                        <input 
                            type="text"
                            name="lokasi"
                            class="form-control"
                            value="<?= $data['lokasi']; ?>"
                            required
                        >

                    </div>

                    <!-- DESKRIPSI -->

                    <div>

                        <label class="form-label">
                            Deskripsi Event
                        </label>

                        <textarea 
                            name="deskripsi"
                            class="form-control"
                            required
                        ><?= $data['deskripsi']; ?></textarea>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="col-lg-4">

                <!-- POSTER -->

                <div class="event-card">

                    <label class="form-label mb-3">
                        Poster Event
                    </label>

                    <label class="upload-box">

                        <input 
                            type="file"
                            name="poster"
                            hidden
                            accept="image/*"
                            onchange="previewImage(event)"
                        >

                        <h6 class="fw-bold">
                            Ganti Poster
                        </h6>

                        <p class="text-secondary small mb-0">
                            PNG, JPG atau JPEG
                        </p>

                        <!-- PREVIEW -->

                        <img 
                            src="../../assets/uploads/event/<?= $data['poster']; ?>"
                            id="previewImg"
                            class="preview-image"
                        >

                    </label>

                </div>

                <!-- SETTING -->

                <div class="event-card">

                    <!-- TANGGAL -->

                    <div class="mb-4">

                        <label class="form-label">
                            Tanggal Event
                        </label>

                        <input 
                            type="date"
                            name="tanggal"
                            class="form-control"
                            value="<?= $data['tanggal']; ?>"
                            required
                        >

                    </div>

                    <!-- STATUS -->

                    <div class="mb-4">

                        <label class="form-label">
                            Status Event
                        </label>

                        <select 
                            name="status"
                            class="form-select"
                        >

                            <option 
                                value="Upcoming"
                                <?= $data['status'] == 'Upcoming' ? 'selected' : ''; ?>
                            >
                                Upcoming
                            </option>

                            <option 
                                value="Selesai"
                                <?= $data['status'] == 'Selesai' ? 'selected' : ''; ?>
                            >
                                Selesai
                            </option>

                        </select>

                    </div>

                    <!-- BUTTON -->

                    <button 
                        type="submit"
                        name="update"
                        class="btn-update"
                    >

                        <i class="fa-solid fa-floppy-disk"></i>

                        Update Event

                    </button>

                </div>

            </div>

        </div>

    </form>

</div>

</div>

<!-- JS -->
<script src="../../assets/js/admin.js"></script>

<script>

function previewImage(event){

    const image = document.getElementById('previewImg');

    image.src = URL.createObjectURL(event.target.files[0]);

}

</script>

</body>
</html>