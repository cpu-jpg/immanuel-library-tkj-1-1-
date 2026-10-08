<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['bio'])) {
    echo "<h3>Data penulis berhasil diterima (ditambahkan):</h3>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
} else {
    echo "Data tidak diterima.";
}
?>
<p><a href="../../pages/authors/index.php">Kembali ke daftar penulis</a></p>
