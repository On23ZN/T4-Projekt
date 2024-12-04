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

$user_id = $_POST['user_id'] ?? $_SESSION['user_id'] ?? null; 

// Aufgaben des angemeldeten Benutzers abrufen
if ($user_id) { 
    $stmt = $conn->prepare("SELECT id, title, completed FROM todos WHERE user_id = ?"); 
    $stmt->bind_param("i", $user_id); 
    $stmt->execute(); 
    $result = $stmt->get_result();
    $todos = $result->fetch_all(MYSQLI_ASSOC);
    

    // JSON-Ausgabe der Aufgaben
    echo json_encode($todos);

    $stmt->close();
} else { 
    echo json_encode(["error" => "Benutzer-ID nicht gefunden"]); 
}
$conn->close();
?>