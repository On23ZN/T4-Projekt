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
     die(json_encode(["error" => "Verbindung fehlgeschlagen: " . $conn->connect_error])); 
    }
    
// Eingabedaten aus der Anfrage holen
$id = $_POST['id'] ?? '';
$user_id = $_SESSION['user_id'];

// Aufgabe aus der Datenbank löschen
if (!empty($id) && !empty($user_id)) {
    $stmt = $conn->prepare("DELETE FROM todos WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Aufgabe gelöscht"]);
    } else {
        echo json_encode(["error" => "Fehler beim Löschen der Aufgabe"]);
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "Ungültige ID oder Benutzer-ID"]);
}

$conn->close();

?>