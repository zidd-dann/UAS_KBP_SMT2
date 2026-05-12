<?php
class Database {
    private $hostname;
    private $username;
    private $password;
    private $database;
    public $conn;

    public function __construct() {
        $this->hostname = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->database = "uas";
        $this->conn = mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
    }

    public function enum($query) {
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);

        $enum_values = $row['Type'];

        preg_match_all("/'([^']+)'/", $enum_values, $matches);
        $enum_values = $matches[1];

        return $enum_values;
    }

    public function query($query) {
        $result = mysqli_query($this->conn, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function checkLogin($role){
        if(!isset($_SESSION["login"])){
            
            echo "<script>alert('Anda Belum Login! Silahkan Login dahulu!'); document.location.href = '../process/login.php';</script>";
            
            exit;
        }
        if($_SESSION["role"] != $role){
            echo "<script>alert('Anda tidak memiliki akses terhadap $role'); document.location.href = '../index.php';</script>";
        }
    }

    public function set($dataPost) {
        $resiko = htmlspecialchars($dataPost["resiko"]);
        $divisi = htmlspecialchars($dataPost["divisi"]);
        $tingkat_resiko = htmlspecialchars($dataPost["tingkat"]);
        $penyebab = htmlspecialchars($dataPost["penyebab"]);
        $sumber  = htmlspecialchars($dataPost["sumber"]);

        $query = "INSERT INTO resiko (resiko, divisi, tingkat, penyebab, sumber, status) VALUES ('$resiko', '$divisi', '$tingkat_resiko', '$penyebab', '$sumber', 'pending')";
        mysqli_query($this->conn, $query);
        return mysqli_affected_rows($this->conn);
    }

    public function approval($id, $status) {
        $query = "UPDATE resiko SET status = '$status' WHERE id = '$id'";
        mysqli_query($this->conn, $query);
        return mysqli_affected_rows($this->conn);
    }
    public function setMitigasiSolusi($id, $mitigasi, $solusi) {
        $mitigasi = htmlspecialchars($mitigasi);
        $solusi = htmlspecialchars($solusi);
        $query = "UPDATE resiko SET mitigasi = '$mitigasi', solusi = '$solusi' WHERE id = '$id'";
        mysqli_query($this->conn, $query);
        return mysqli_affected_rows($this->conn);
    }
    public function sethapus($id) {
        $query = "DELETE FROM resiko WHERE id = '$id'";
        mysqli_query($this->conn, $query);
        return mysqli_affected_rows($this->conn);
    }
    public function setupdate($dataPost) {
        $id = htmlspecialchars($dataPost["id"]);
        $resiko = htmlspecialchars($dataPost["resiko"]);
        $divisi = htmlspecialchars($dataPost["divisi"]);
        $tingkat_resiko = htmlspecialchars($dataPost["tingkat"]);
        $penyebab = htmlspecialchars($dataPost["penyebab"]);
        $sumber  = htmlspecialchars($dataPost["sumber"]);
        $mitigasi = htmlspecialchars($dataPost["mitigasi"]);
        $solusi = htmlspecialchars($dataPost["solusi"]);
        $status = htmlspecialchars($dataPost['status']);

        $query = "UPDATE resiko SET
                    resiko = '$resiko',
                    divisi = '$divisi',
                    tingkat = '$tingkat_resiko',
                    penyebab = '$penyebab',
                    sumber = '$sumber',
                    mitigasi = '$mitigasi',
                    solusi = '$solusi',
                    status = '$status'
                WHERE id = '$id'";
        mysqli_query($this->conn, $query);
        return mysqli_affected_rows($this->conn);
    }
    public function getdata() {
    $query = "SELECT * FROM resiko"; 
    $result = mysqli_query($this->conn, $query);
    $rows = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = [
                'id'        => $row['id'],
                'resiko'    => htmlspecialchars($row['resiko']),
                'divisi'    => htmlspecialchars($row['divisi']),
                'tingkat'   => htmlspecialchars($row['tingkat']),
                'penyebab'  => htmlspecialchars($row['penyebab']),
                'sumber'    => htmlspecialchars($row['sumber']),
                'mitigasi'  => htmlspecialchars($row['mitigasi']),
                'solusi'    => htmlspecialchars($row['solusi']),
                'status'    => htmlspecialchars($row['status'])
            ];
        }
    }

    return $rows;
    }

    public function getPendingData() {
    $query = "SELECT * FROM resiko WHERE status = 'pending'"; 
    $result = mysqli_query($this->conn, $query);
    $rows = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = [
                'id'        => $row['id'],
                'resiko'    => htmlspecialchars($row['resiko']),
                'divisi'    => htmlspecialchars($row['divisi']),
                'tingkat'   => htmlspecialchars($row['tingkat']),
                'penyebab'  => htmlspecialchars($row['penyebab']),
                'sumber'    => htmlspecialchars($row['sumber']),
                'mitigasi'  => htmlspecialchars($row['mitigasi']),
                'solusi'    => htmlspecialchars($row['solusi']),
                'status'    => htmlspecialchars($row['status'])
            ];
        }
    }

    return $rows;
    }
    
}
class user extends Database {
        public function getdatauser(){
             $query = "SELECT * FROM resiko WHERE status = 'pending'"; 
    $result = mysqli_query($this->conn, $query);
    $rows = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = [
                'id'        => $row['id'],
                'resiko'    => htmlspecialchars($row['resiko']),
                'divisi'    => htmlspecialchars($row['divisi']),
                'tingkat'   => htmlspecialchars($row['tingkat']),
                'penyebab'  => htmlspecialchars($row['penyebab']),
                'sumber'    => htmlspecialchars($row['sumber']),
                'mitigasi'  => htmlspecialchars($row['mitigasi']),
                'solusi'    => htmlspecialchars($row['solusi']),
                'status'    => htmlspecialchars($row['status'])
            ];
        }
    }

    return $rows;

        }
    }

?>