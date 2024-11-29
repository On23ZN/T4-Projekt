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

// Eingabedaten aus der Anfrage holen
$title = $_POST['title'] ?? '';

// Aufgabe zur Datenbank hinzufügen
if (!empty($title)) {
    $stmt = $conn->prepare("INSERT INTO todos (title, completed) VALUES (?, 0)");
    $stmt->bind_param("s", $title);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Aufgabe hinzugefügt"]);
    } else {
        echo json_encode(["error" => "Fehler beim Hinzufügen der Aufgabe"]);
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "Titel darf nicht leer sein"]);
}

$conn->close();
?>