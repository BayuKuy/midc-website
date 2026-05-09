<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login.php");
    exit;
}

include '../../config/koneksi.php';

/*
|--------------------------------------------------------------------------
| TAMBAH EVENT
|--------------------------------------------------------------------------
*/

if(isset($_POST['publish'])){

    $nama_event = mysqli_real_escape_string($conn, $_POST['nama_event']);

    $tanggal = $_POST['tanggal'];

    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);

    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $status = $_POST['status'];

    // UPLOAD POSTER

    $poster = $_FILES['poster']['name'];

    $tmp = $_FILES['poster']['tmp_name'];

    $folder = "../../assets/uploads/event/";

    $nama_poster = time() . '-' . $poster;

    move_uploaded_file($tmp, $folder . $nama_poster);

    // INSERT DATABASE

    $query = mysqli_query($conn, "INSERT INTO event
    (nama_event, tanggal, lokasi, deskripsi, poster, status)

    VALUES

    ('$nama_event', '$tanggal', '$lokasi', '$deskripsi', '$nama_poster', '$status')
    ");

    if($query){

        $_SESSION['success'] = "Event berhasil ditambahkan!";

        header("Location: index.php");

        exit;

    }else{

        $_SESSION['error'] = "Event gagal ditambahkan!";

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Event</title>

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

        /* Card */

        .event-card{
            background:white;
            border-radius:24px;
            padding:25px;
            box-shadow:0 5px 20px rgba(0,0,0,0.04);
            margin-bottom:25px;
        }

        /* Form */

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

        .upload-icon{
            font-size:45px;
            color:#2563eb;
            margin-bottom:10px;
        }

        .preview-image{
            width:100%;
            border-radius:18px;
            margin-top:20px;
            max-height:250px;
            object-fit:cover;
            display:none;
        }

        /* Info Box */

        .info-box{
            background:linear-gradient(135deg,#2563eb,#4f46e5);
            border-radius:20px;
            padding:20px;
            color:white;
        }

        .info-box h5{
            font-weight:700;
            margin-bottom:10px;
        }

        .info-box p{
            font-size:14px;
            opacity:0.9;
            margin-bottom:0;
        }

        /* Button */

        .btn-publish{
            width:100%;
            border:none;
            border-radius:14px;
            padding:14px;
            background:linear-gradient(135deg,#2563eb,#4f46e5);
            color:white;
            font-weight:600;
            transition:0.3s;
        }

        .btn-publish:hover{
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

                <h3>Tambah Event</h3>

                <p>
                    Kelola dan publikasikan kegiatan terbaru MIDC
                </p>

            </div>

            <!-- FORM -->

            <form action="" method="POST" enctype="multipart/form-data">

                <div class="row">

                    <!-- LEFT -->

                    <div class="col-lg-8">

                        <!-- INFORMASI EVENT -->

                        <div class="event-card">

                            <h5 class="fw-bold mb-4">
                                Informasi Event
                            </h5>

                            <!-- NAMA EVENT -->

                            <div class="mb-4">

                                <label class="form-label">
                                    Nama Event
                                </label>

                                <input 
                                    type="text"
                                    name="nama_event"
                                    class="form-control"
                                    placeholder="Contoh: Workshop UI/UX"
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
                                    placeholder="Contoh: Aula Kampus"
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
                                    placeholder="Jelaskan detail event..."
                                    required
                                ></textarea>

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
                                    required
                                >

                                <div class="upload-icon">
                                    <i class="fa-solid fa-calendar-days"></i>
                                </div>

                                <h6 class="fw-bold">
                                    Upload Poster
                                </h6>

                                <p class="text-secondary small mb-0">
                                    PNG, JPG atau JPEG
                                </p>

                                <img 
                                    id="previewImg"
                                    class="preview-image"
                                >

                            </label>

                        </div>

                        <!-- SETTING -->

                        <div class="event-card">

                            <h5 class="fw-bold mb-4">
                                Pengaturan Event
                            </h5>

                            <!-- TANGGAL -->

                            <div class="mb-4">

                                <label class="form-label">
                                    Tanggal Event
                                </label>

                                <input 
                                    type="date"
                                    name="tanggal"
                                    class="form-control"
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

                                    <option value="Upcoming">
                                        Upcoming
                                    </option>

                                    <option value="Selesai">
                                        Selesai
                                    </option>

                                </select>

                            </div>

                            <!-- BUTTON -->

                            <button 
                                type="submit"
                                name="publish"
                                class="btn-publish"
                            >

                                <i class="fa-solid fa-paper-plane"></i>

                                Publish Event

                            </button>

                        </div>

                        <!-- INFO -->

                        <div class="info-box">

                            <h5>
                                MIDC Digital Event
                            </h5>

                            <p>
                                Pastikan informasi event sudah benar sebelum dipublikasikan ke website resmi MIDC.
                            </p>

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

            image.style.display = "block";

        }

    </script>

</body>
</html>