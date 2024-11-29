<?php
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

// Alle Aufgaben abrufen
$sql = "SELECT * FROM todos";
$result = $conn->query($sql);

$todos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $todos[] = $row;
    }
}

// JSON-Ausgabe der Aufgaben
echo json_encode($todos);

$conn->close();

?>