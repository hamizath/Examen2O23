<?php 
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nomMarche'];
    $desc = $_POST['description'] ?? '';
    $cap = $_POST['capacite'];
    $adr = $_POST['adresse'] ?? '';
    $tel = $_POST['telephone'] ?? '';
    $ville = $_POST['idVille'];
    
    // Gestion de l'image
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
    exit(); // Bonne pratique après une redirection
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Marché</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">Marchés du Bénin</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h3 class="mb-0">Ajouter un Nouveau Marché</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nom du Marché</label>
                                <input type="text" name="nomMarche" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Capacité (places)</label>
                                <input type="number" name="capacite" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ville</label>
                                <select name="idVille" class="form-control">
                                    <?php
                                    $villes = $pdo->query("SELECT * FROM Ville");
                                    while($v = $villes->fetch()) {
                                        echo "<option value='{$v['idVille']}'>{$v['nomVille']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image du marché</label>
                                <input type="file" name="image" class="form-control" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">Enregistrer le Marché</button>
                                <a href="index.php" class="btn btn-outline-secondary">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>