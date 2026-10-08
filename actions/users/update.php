<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['name'], $_POST['email'], $_POST['role'])) {
    echo "<h3>Data pengguna berhasil diterima (diubah):</h3>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
} else {
    echo "Data tidak diterima.";
}
?>
<p><a href="../../pages/users/index.php">Kembali ke daftar pengguna</a></p>
