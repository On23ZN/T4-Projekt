<?php
// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "todo_app";


$conn = new mysqli($servername, $username, $password, $dbname);

 // Verbindung überprüfen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Eingabedaten aus der Anfrage holen
$title = $_POST['title'] ?? '';
?>