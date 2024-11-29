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
$id = $_POST['id'] ?? '';
$completed = $_POST['completed'] ?? '';

// Debugging: Ausgabe der empfangenen Daten 
error_log("Empfangene ID: " . $id); 
error_log("Empfangener Status: " . $completed);

if (!empty($id)) {
    $stmt = $conn->prepare("UPDATE todos SET completed = ? WHERE id = ?");
    $stmt->bind_param("ii", $completed, $id);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Aufgabe aktualisiert"]);
    } else {
        echo json_encode(["error" => "Fehler beim Aktualisieren der Aufgabe"]);
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "Ungültige ID"]);
}

$conn->close();

?>
