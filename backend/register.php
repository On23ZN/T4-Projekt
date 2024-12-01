<?php
// Header für den Content-Type
header('Content-Type: application/json');

// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todo_app";

$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfe die Verbindung zur Datenbank
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Hole die Benutzereingaben aus der Anfrage
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$first_name = $_POST['first_name'] ?? ''; 
$last_name = $_POST['last_name'] ?? '';

// Überprüfe, ob der Benutzername bereits existiert 
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?"); 
$stmt->bind_param("s", $username); 
$stmt->execute(); 
$stmt->store_result();

if ($stmt->num_rows > 0) { 
    echo json_encode(["error" => "Benutzername bereits vergeben"]); 
    $stmt->close(); 
    $conn->close(); 
    exit; 
}

// Bereite die SQL-Anweisung vor, um den Benutzer zu registrieren
$stmt = $conn->prepare("INSERT INTO users (username, password, first_name, last_name) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $password, $first_name, $last_name);

// Führe die SQL-Anweisung aus und überprüfe das Ergebnis
if ($stmt->execute()) {
    echo json_encode(["message" => "Benutzer registriert"]);
} else {
    echo json_encode(["error" => "Fehler bei der Registrierung"]);
}

// Schließe die Datenbankverbindung
$stmt->close();
$conn->close();
?>
