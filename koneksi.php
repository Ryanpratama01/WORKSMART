<?php
echo"<title>Koneksi</title>"
$koneksi = mysqli_connect('localhost', 'root', '','workssmart');
if ($koneksi)
{
    echo"Koneksi Berhasil";
}
else {
    echo "Koneksi tidak Berhasil"
}
?>