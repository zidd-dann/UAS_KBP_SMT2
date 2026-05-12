<?php
require '../resources/functions.php';
$db = new Database();

$username = $_POST["username"];

$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$role = $_POST["role"];
if(!in_array($role, ['Admin', 'User'])){
    echo "<script>
        alert('Role tidak valid! Silahkan pilih admin atau user!');
        document.location.href = 'register.php';    
    </script>";
    exit;
}

// Query untuk insert data ke database dengan password yang dihash
$query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
$stmt = $db->conn->prepare($query);
$stmt->bind_param("sss", $username, $password, $role);

if ($stmt->execute()) {
    echo "
    <script>
        alert('Akun berhasil didaftarkan!');
        document.location.href = 'login.php';
    </script>
    ";
    exit;
} else {
    echo "Error: " . $db->conn->error;
}
$stmt->close();
$db->conn->close();
?>