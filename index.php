<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Marchés du Bénin</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Liste des Marchés du Bénin</h1>
        <div class="row">
            <?php
            $query = $pdo->query("SELECT * FROM Marche");
            while ($marche = $query->fetch()):
            ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="images/<?php echo $marche['image']; ?>" class="card-img-top" alt="Photo du marché" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $marche['nomMarche']; ?></h5>
                        <p class="card-text text-muted">Capacité : <?php echo $marche['capacite']; ?> places</p>
                        <p class="card-text"><?php echo substr($marche['description'], 0, 100); ?>...</p>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
