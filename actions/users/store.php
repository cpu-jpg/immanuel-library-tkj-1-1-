<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role'])) {
    echo "<h3>Data pengguna berhasil diterima (ditambahkan):</h3>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
} else {
    echo "Data tidak diterima.";
}
?>
<p><a href="../../pages/users/index.php">Kembali ke daftar pengguna</a></p>
