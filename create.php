<?php 
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nomMarche'];
    $desc = $_POST['description'];
    $cap = $_POST['capacite'];
    $adr = $_POST['adresse'];
    $tel = $_POST['telephone'];
    $ville = $_POST['idVille'];
    
    // Gestion simple de l'image
    $imgName = $_FILES['image']['name'];
    $targetDir = "images/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $imgName);

    $sql = "INSERT INTO Marche (nomMarche, description, capacite, adresse, telephone, image, idVille) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $desc, $cap, $adr, $tel, $imgName, $ville]);
    
    header("Location: index.php");
}
?>

<div class="container mt-5 col-md-6">
    <h3>Ajouter un Nouveau Marché</h3>
    <form method="POST" enctype="multipart/form-data" class="card p-4">
        <div class="mb-3">
            <label>Nom du Marché</label>
            <input type="text" name="nomMarche" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Capacité</label>
            <input type="number" name="capacite" class="form-control">
        </div>
        <div class="mb-3">
            <label>Ville</label>
            <select name="idVille" class="form-control">
                <?php
                $villes = $pdo->query("SELECT * FROM Ville");
                while($v = $villes->fetch()) echo "<option value='{$v['idVille']}'>{$v['nomVille']}</option>";
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-success w-100">Enregistrer</button>
    </form>
</div>