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

// Eingabedaten aus der Anfrage holen
$id = $_POST['id'] ?? '';
$completed = $_POST['completed'] ?? '';
$user_id = $_SESSION['user_id'];

// Debugging: Ausgabe der empfangenen Daten 
error_log("Empfangene ID: " . $id); 
error_log("Empfangener Status: " . $completed);

// Aufgabe in der Datenbank aktualisieren
if (!empty($id) && ($completed === '0' || $completed === '1') && !empty($user_id)) {
    $stmt = $conn->prepare("UPDATE todos SET completed = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("iii", $completed, $id, $user_id);
    if ($stmt->execute()) {
        echo json_encode(["message" => "Aufgabe aktualisiert"]);
    } else {
        echo json_encode(["error" => "Fehler beim Aktualisieren der Aufgabe"]);
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "Ungültige ID, Status oder Benutzer-ID"]);
}

$conn->close();

?>
