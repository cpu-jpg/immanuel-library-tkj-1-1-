<?php

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    echo "Buku dengan id " . $id . " berhasil dihapus (simulasi).";
} else {
    echo "Id buku tidak ditemukan.";
}
?>
<p><a href="../../pages/books/index.php">Kembali ke daftar buku</a></p>
