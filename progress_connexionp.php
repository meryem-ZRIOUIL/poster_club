<?php
include 'connexionp.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $birthdate = $_POST['birthdate'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirm_password = $_POST['confirm_password'];

    if ($mot_de_passe !== $confirm_password) {
        echo "Les mots de passe ne correspondent pas.";
        exit();
    }

    $mot_de_passe_hashed = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    $sql = $conn->prepare("INSERT INTO Utilisateur (nom, prenom, email, mot_de_passe, phone, birthdate, confirm_password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("sssssss", $nom, $prenom, $email, $mot_de_passe_hashed, $phone, $birthdate, $confirm_password);

    if ($sql->execute()) {
        echo "Nouvel enregistrement créé avec succès";
    } else {
        echo "Erreur : " . $sql->error;
    }

    $sql->close();
} else {
    echo "Méthode non autorisée."; 
}

$conn->close();
?>
