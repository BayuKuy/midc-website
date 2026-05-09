<?php
session_start();
if(!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}
require '../../config/koneksi.php';
if(!isset($_GET['id'])) {
    header("Location: index.php");
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM berita WHERE id_berita = '$id'");
$data = mysqli_fetch_assoc($query);
/*
|--------------------------------------------------------------------------
| UPDATE BERITA
|--------------------------------------------------------------------------
*/

if(isset($_POST['update'])){

    $judul = mysqli_real_escape_string($conn, $_POST['judul']);

    $isi = mysqli_real_escape_string($conn, $_POST['isi']);

    // Cek apakah upload gambar baru

    if($_FILES['gambar']['name'] != ""){

        // Hapus gambar lama

        $gambar_lama = "../../assets/uploads/berita/" . $data['gambar'];

        if(file_exists($gambar_lama)){

            unlink($gambar_lama);

        }

        // Upload gambar baru

        $gambar = $_FILES['gambar']['name'];

        $tmp = $_FILES['gambar']['tmp_name'];

        $nama_gambar = time() . '-' . $gambar;

        move_uploaded_file($tmp, "../../assets/uploads/berita/" . $nama_gambar);

    }else{

        // Pakai gambar lama

        $nama_gambar = $data['gambar'];

    }

    // Update database

    $update = mysqli_query($conn, "UPDATE berita SET

        judul = '$judul',
        isi = '$isi',
        gambar = '$nama_gambar'

        WHERE id_berita = '$id'

    ");

    // Cek berhasil

    if($update){

        $_SESSION['success'] = "Berita berhasil diperbarui!";

        header("Location: index.php");

        exit;

    }else{

        $_SESSION['error'] = "Berita gagal diperbarui!";

    }

}
if(!$data) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../assets/css/admin.css">

    <style>

        .editor-wrapper{
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

        .editor-card{
            background:white;
            border-radius:24px;
            padding:25px;
            box-shadow:0 5px 20px rgba(0,0,0,0.04);
            margin-bottom:25px;
        }

        /* Input */

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
            min-height:300px;
            resize:none;
        }

        /* Upload */

        .upload-box{
            border:2px dashed #cbd5e1;
            border-radius:18px;
            padding:25px;
            text-align:center;
            cursor:pointer;
            transition:0.3s;
        }

        .upload-box:hover{
            border-color:#2563eb;
            background:#f8fafc;
        }

        .upload-icon{
            font-size:40px;
            color:#2563eb;
            margin-bottom:10px;
        }

        .preview-image{
            width:100%;
            border-radius:18px;
            margin-top:20px;
            object-fit:cover;
            max-height:220px;
        }

        /* Button */

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

        .publish-info{
            display:flex;
            justify-content:space-between;
            margin-bottom:15px;
            font-size:14px;
            color:#64748b;
        }

    </style>

</head>
<body>

    <?php include '../../includes/sidebar.php'; ?>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="main-content">

        <?php include '../../includes/navbar_admin.php'; ?>

        <div class="editor-wrapper">

            <!-- TITLE -->

            <div class="page-title mb-4">

                <h3>Edit Berita</h3>

                <p>
                    Perbarui berita dan informasi terbaru MIDC
                </p>

            </div>

            <!-- FORM -->

            <form action="" method="POST" enctype="multipart/form-data">

                <div class="row">

                    <!-- LEFT -->

                    <div class="col-lg-8">

                        <!-- JUDUL -->

                        <div class="editor-card">

                            <label class="form-label">
                                Judul Berita
                            </label>

                            <input 
                                type="text"
                                name="judul"
                                class="form-control"
                                value="<?= $data['judul']; ?>"
                                required
                            >

                        </div>

                        <!-- ISI -->

                        <div class="editor-card">

                            <label class="form-label">
                                Isi Berita
                            </label>

                            <textarea 
                                name="isi"
                                class="form-control"
                                placeholder="Tulis isi berita..."
                                required
                            ><?= $data['isi']; ?></textarea>

                        </div>

                    </div>

                    <!-- RIGHT -->

                    <div class="col-lg-4">

                        <!-- THUMBNAIL -->

                        <div class="editor-card">

                            <label class="form-label mb-3">
                                Thumbnail Berita
                            </label>

                            <label class="upload-box">

                                <input 
                                    type="file"
                                    name="gambar"
                                    hidden
                                    accept="image/*"
                                    onchange="previewImage(event)"
                                >

                                <div class="upload-icon">
                                    <i class="fa-solid fa-image"></i>
                                </div>

                                <h6 class="fw-bold">
                                    Ganti Thumbnail
                                </h6>

                                <p class="text-secondary small mb-0">
                                    PNG, JPG atau JPEG
                                </p>

                                <!-- Preview Lama -->

                                <img 
                                    src="../../assets/uploads/berita/<?= $data['gambar']; ?>"
                                    id="previewImg"
                                    class="preview-image"
                                >

                            </label>

                        </div>

                        <!-- UPDATE -->

                        <div class="editor-card">

                            <h5 class="fw-bold mb-4">
                                Informasi
                            </h5>

                            <div class="publish-info">

                                <span>Penulis</span>

                                <strong>
                                    <?= $data['penulis']; ?>
                                </strong>

                            </div>

                            <div class="publish-info">

                                <span>Tanggal</span>

                                <strong>
                                    <?= date('d M Y', strtotime($data['tanggal'])); ?>
                                </strong>

                            </div>

                            <button 
                                type="submit"
                                name="update"
                                class="btn-update"
                            >

                                <i class="fa-solid fa-floppy-disk"></i>

                                Update Berita

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