<?php
// Starte die Session
session_start();

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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Bereite die SQL-Anweisung vor, um den Benutzer zu authentifizieren
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    // Überprüfe das Passwort und starte die Session
    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        echo json_encode(["message" => "Login erfolgreich"]);
    } else {
        echo json_encode(["error" => "Ungültige Anmeldedaten"]);
    }

    // Schließe die Datenbankverbindung
    $stmt->close();
    $conn->close();

}
?>
