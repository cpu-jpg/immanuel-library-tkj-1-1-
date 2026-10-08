<?php

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    echo "Kategori dengan id " . $id . " berhasil dihapus (simulasi).";
} else {
    echo "Id kategori tidak ditemukan.";
}
?>
<p><a href="../../pages/categories/index.php">Kembali ke daftar kategori</a></p>
