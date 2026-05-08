<?php

$conn = mysqli_connect("localhost","root","","midc_db");
if(!$conn) {
    die("koneksi database gagal". mysqli_connect_error());
}