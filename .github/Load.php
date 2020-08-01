<?php
$servername = “localhost”;
$username = “username”;
$password = “password”;
// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
   die(“Koneksi gagal: ” . $conn->connect_error);
} 
// Create database
$sql = “CREATE DATABASE myDB”;
if ($conn->query($sql) === TRUE) {
   echo “Database berhasil dibuat!”;
} else {
   echo “Error membuat database: ” . $conn->error;
}
$conn->close();
?>
