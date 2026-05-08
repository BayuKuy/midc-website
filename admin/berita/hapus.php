<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login.php");
    exit;
}

include '../../config/koneksi.php';

// VALIDASI ID

if(!isset($_GET['id'])){

    header("Location: index.php");
    exit;

}

$id = $_GET['id'];

// AMBIL DATA BERITA

$query = mysqli_query($conn, "SELECT * FROM berita WHERE id_berita='$id'");

$data = mysqli_fetch_assoc($query);

// CEK DATA ADA

if($data){

    // PATH GAMBAR

    $gambar = "../../assets/uploads/berita/" . $data['gambar'];

    // HAPUS FILE JIKA ADA

    if(!empty($data['gambar']) && file_exists($gambar)){

        unlink($gambar);

    }

    // HAPUS DATABASE

    $delete = mysqli_query($conn, "DELETE FROM berita WHERE id_berita='$id'");

}else{

    $delete = false;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hapus Berita</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

<script>

<?php if($delete) : ?>

Swal.fire({

    icon: 'success',

    title: 'Berhasil!',

    text: 'Berita berhasil dihapus.',

    confirmButtonColor: '#2563eb'

}).then(() => {

    window.location.href = 'index.php';

});

<?php else : ?>

Swal.fire({

    icon: 'error',

    title: 'Gagal!',

    text: 'Data berita tidak ditemukan.',

    confirmButtonColor: '#dc2626'

}).then(() => {

    window.location.href = 'index.php';

});

<?php endif; ?>

</script>

</body>
</html>