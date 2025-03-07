<?php 
session_start();
try {
    $connect = new PDO("mysql:host=localhost;dbname=solirestaurant", "root", "");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


$selectedCuisine = isset($_POST['TypeCuisine']) ? $_POST['TypeCuisine'] : "";
$selectedCategory = isset($_POST['categoriePlat']) ? $_POST['categoriePlat'] : "";


$query = "SELECT * FROM plat";
$params = [];

if ($selectedCuisine || $selectedCategory) {
    $query .= " WHERE";
    if ($selectedCuisine) {
        $query .= " TypeCuisine = ?";
        $params[] = $selectedCuisine;
    }
    if ($selectedCategory) {
        if ($selectedCuisine) {
            $query .= " AND";
        }
        $query .= " categoriePlat = ?";
        $params[] = $selectedCategory;
    }
}

$stmt = $connect->prepare($query);
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['add_to_cart'])) {
    $idPlat = $_POST['idPlat'];
    $nomPlat = $_POST['nomPlat'];
    $prix = $_POST['prix'];

    if (!isset($_SESSION['cart'][$idPlat])) {
        $_SESSION['cart'][$idPlat] = ['nomPlat' => $nomPlat, 'prix' => $prix, 'quantity' => 1];
    } else {
        $_SESSION['cart'][$idPlat]['quantity']++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="index.css">
</head>

<header>
    <div class="header-container">
        <h3>Solirestaurant</h3>
        <nav class="header-nav">
            <a href="index.php">Home</a>
            <a href="cart.php">Cart</a>
        </nav>
    </div>
</header>


<div class="filter-container">
    <form method="post">
        <label for="TypeCuisine">Filter by Cuisine: </label>
        <select name="TypeCuisine" id="TypeCuisine" onchange="this.form.submit()">
            <option value="">All</option>
            <?php 
            $cuisineQuery = $connect->query("SELECT DISTINCT TypeCuisine FROM plat");
            $cuisines = $cuisineQuery->fetchAll(PDO::FETCH_ASSOC);

            foreach ($cuisines as $cuisine): ?>
                <option value="<?= $cuisine['TypeCuisine'] ?>" <?= ($selectedCuisine == $cuisine['TypeCuisine']) ? 'selected' : '' ?>>
                    <?= $cuisine['TypeCuisine'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="categoriePlat">Filter by Category: </label>
        <select name="categoriePlat" id="categoriePlat" onchange="this.form.submit()">
            <option value="">All</option>
            <?php
            $categoriePlatQuery = $connect->query("SELECT DISTINCT categoriePlat FROM plat");
            $categoriePlats = $categoriePlatQuery->fetchAll(PDO::FETCH_ASSOC);

            foreach ($categoriePlats as $categoriePlat): ?>
                <option value="<?= $categoriePlat['categoriePlat'] ?>" <?= ($selectedCategory == $categoriePlat['categoriePlat']) ? 'selected' : '' ?>>
                    <?= $categoriePlat['categoriePlat'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
</div>

<body>
    <?php foreach ($rows as $row): ?>
        <div class="card">
            <h3><?= $row['nomPlat'] ?></h3>
            <p>Category: <?= $row['categoriePlat'] ?></p>
            <p>Price: <?= $row['prix'] ?> DH</p>
            <p>TypeCuisine: <?= $row['TypeCuisine'] ?></p>
            <?php if (!empty($row['image'])): ?>
                <img src="<?= $row['image'] ?>" alt="<?= $row['nomPlat'] ?>">
            <?php endif; ?>
            <form method="post">
                <input type="hidden" name="idPlat" value="<?= $row['idPlat'] ?>">
                <input type="hidden" name="nomPlat" value="<?= $row['nomPlat'] ?>">
                <input type="hidden" name="prix" value="<?= $row['prix'] ?>">
                <input type="submit" name="add_to_cart" value="Add to Cart" class="add_to_cart">
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>
