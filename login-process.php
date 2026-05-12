<?php
    require '../resources/functions.php';
    $db = new Database();
    session_start();

    if(isset($_POST["login"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $query = "SELECT password, role FROM users WHERE username = ?";
        $stmt = $db->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($row = $result->fetch_assoc()){
            if(password_verify($password, $row["password"])){
                
                $_SESSION['login'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $row['role'];
                if($row["role"] == "Admin"){
                    echo "<script>
                        alert('Selamat datang, admin $username !');
                        document.location.href = '../admin/admindashboard.php';
                    </script>";
                    exit;
                }elseif($row["role"] == "User"){
                    echo "<script>
                        alert('Selamat datang, $username !');
                        document.location.href = '../user/usermain.php';
                    </script>";
                    exit;
                }
            }else {
                echo "<script>alert('password salah!'); document.location.href = 'login.php';</script>";
            }
        }else {
            echo "<script>alert('username tidak ditemukan!'); document.location.href = 'login.php';</script>";
        }
        $stmt->close();
    }else {
        echo "<script>alert('Tidak ada data login!'); document.location.href = 'login.php';</script>";
    }
?>