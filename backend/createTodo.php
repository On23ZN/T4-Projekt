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
$title = $_POST['title'] ?? ''; 
$user_id = $_POST['user_id'] ?? $_SESSION['user_id'] ?? null; 

// Aufgabe zur Datenbank hinzufügen
if ($title && $user_id) {
    $stmt = $conn->prepare("INSERT INTO todos (title, completed, user_id) VALUES (?, 0, ?)");
    $stmt->bind_param("si", $title, $user_id);
    if ($stmt->execute()) {
        $todo_id = $conn->insert_id; // Die ID des neuen ToDos erhalten
        echo json_encode(["message" => "Aufgabe hinzugefügt", "todo_id" => $todo_id]);
    } else {
        echo json_encode(["error" => "Fehler beim Hinzufügen der Aufgabe"]);
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "Titel oder Benutzer-ID darf nicht leer sein"]);
}

$conn->close();
?>