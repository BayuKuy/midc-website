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
| AMBIL DATA DIVISI
|--------------------------------------------------------------------------
*/

$query = mysqli_query(
    $conn,
    "SELECT * FROM divisi WHERE id_divisi='$id'"
);

$data = mysqli_fetch_assoc($query);

/*
|--------------------------------------------------------------------------
| JIKA DATA TIDAK ADA
|--------------------------------------------------------------------------
*/

if(!$data){

    $_SESSION['error'] = "Data divisi tidak ditemukan!";

    header("Location: index.php");

    exit;

}

$nama_divisi = $data['nama_divisi'];

/*
|--------------------------------------------------------------------------
| CEK RELASI PENGURUS
|--------------------------------------------------------------------------
*/

$cek_pengurus = mysqli_num_rows(mysqli_query(
    $conn,
    "SELECT * FROM pengurus WHERE divisi='$nama_divisi'"
));

/*
|--------------------------------------------------------------------------
| CEK RELASI PROGRAM
|--------------------------------------------------------------------------
*/

$cek_program = mysqli_num_rows(mysqli_query(
    $conn,
    "SELECT * FROM program_kerja WHERE divisi='$nama_divisi'"
));

/*
|--------------------------------------------------------------------------
| JIKA MASIH DIGUNAKAN
|--------------------------------------------------------------------------
*/

if($cek_pengurus > 0 || $cek_program > 0){

    $_SESSION['error'] = "Divisi tidak bisa dihapus karena masih digunakan!";

    header("Location: index.php");

    exit;

}

/*
|--------------------------------------------------------------------------
| HAPUS DIVISI
|--------------------------------------------------------------------------
*/

$delete = mysqli_query(
    $conn,
    "DELETE FROM divisi WHERE id_divisi='$id'"
);

/*
|--------------------------------------------------------------------------
| FLASH MESSAGE
|--------------------------------------------------------------------------
*/

if($delete){

    $_SESSION['success'] = "Divisi berhasil dihapus!";

}else{

    $_SESSION['error'] = "Divisi gagal dihapus!";

}

header("Location: index.php");

exit;

?>