<?php

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    echo "Penulis dengan id " . $id . " berhasil dihapus (simulasi).";
} else {
    echo "Id penulis tidak ditemukan.";
}
?>
<p><a href="../../pages/authors/index.php">Kembali ke daftar penulis</a></p>
