<?php
session_start(); // Session starten
// Verbindung zur Datenbank herstellen
header('Content-Type: application/json');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todo_app";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung überprüfen
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Aufgaben des angemeldeten Benutzers abrufen
$stmt = $conn->prepare("SELECT * FROM todos WHERE user_id = ?"); 
$stmt->bind_param("i", $user_id); 
$stmt->execute(); 
$result = $stmt->get_result();

$todos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $todos[] = $row;
    }
}

// JSON-Ausgabe der Aufgaben
echo json_encode($todos);

$stmt->close();
$conn->close();

?>