<?php

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    echo "Pengguna dengan id " . $id . " berhasil dihapus (simulasi).";
} else {
    echo "Id pengguna tidak ditemukan.";
}
?>
<p><a href="../../pages/users/index.php">Kembali ke daftar pengguna</a></p>
