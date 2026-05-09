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
| CEK DATA ADA
|--------------------------------------------------------------------------
*/

if($data){

    // PATH POSTER

    $poster = "../../assets/uploads/event/" . $data['poster'];

    // HAPUS FILE POSTER

    if(!empty($data['poster']) && file_exists($poster)){

        unlink($poster);

    }

    // HAPUS DATABASE

    $delete = mysqli_query($conn, "DELETE FROM event WHERE id_event='$id'");

    if($delete){

        $_SESSION['success'] = "Event berhasil dihapus!";

    }else{

        $_SESSION['error'] = "Event gagal dihapus!";

    }

}else{

    $_SESSION['error'] = "Data event tidak ditemukan!";

}

/*
|--------------------------------------------------------------------------
| REDIRECT
|--------------------------------------------------------------------------
*/

header("Location: index.php");

exit;

?>