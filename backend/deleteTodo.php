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
$id = $_POST['id'] ?? '';

if (!empty($id)) {
    $stmt = $conn->prepare("DELETE FROM todos WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Aufgabe gelöscht"]);
    } else {
        echo json_encode(["error" => "Fehler beim Löschen der Aufgabe"]);
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "Ungültige ID"]);
}

$conn->close();

?>