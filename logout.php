<?php
    session_start();
    session_destroy();
    echo "<script>
        alert('Berhasil Logout!');
        document.location.href = 'login.php';
    </script>";
    exit;
?>