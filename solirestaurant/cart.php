<?php 
session_start();
try {
    $connect = new PDO("mysql:host=localhost;dbname=solirestaurant", "root", "");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

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

if (isset($_POST['button'])) {
    $idPlat = $_POST['idPlat'];
    if (isset($_SESSION['cart'][$idPlat])) {
        $_SESSION['cart'][$idPlat]['quantity']++;
    }
}

if (isset($_POST['submit'])) {
    $idPlat = $_POST['idPlat'];
    if (isset($_SESSION['cart'][$idPlat])) {
        if ($_SESSION['cart'][$idPlat]['quantity'] > 1) {
            $_SESSION['cart'][$idPlat]['quantity']--;
        } else {
            unset($_SESSION['cart'][$idPlat]);
        }
    }
}

if (isset($_POST['remove_from_cart'])) {
    $idPlat = $_POST['idPlat'];
    unset($_SESSION['cart'][$idPlat]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <style>
        .cart {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #000;
        }
        .quantity-btn {
            padding: 5px 10px;
            font-size: 16px;
        }
        .remove-btn {
            margin-top: 5px;
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .card {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px;
            display: inline-block;
            width: 200px;
            text-align: center;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            background-color: #333;
            color: white;
        }
        .header-container h3 {
            font-size: 1.8em;
        }
        a {
            text-decoration: none;
            color: white;
            font-family: 'Arial', sans-serif;
            padding: 10px 20px;
        }
        a:hover {
            color: yellow;
        }
    </style>
</head>
<body>
<header>
    <div class="header-container">
        <h3>Restaurant Menu</h3>
        <nav class="header-nav">
            <a href="index.php">Home</a>
            <a href="cart.php">Cart</a>
          
        </nav>
    </div>
</header>


<div class="cart">
    <h3>Your Cart</h3>
    <?php 
    $total = 0;
    if (!empty($_SESSION['cart'])): 
        foreach ($_SESSION['cart'] as $idPlat => $item): 
            $subtotal = $item['prix'] * $item['quantity'];
            $total += $subtotal;
    ?>
        <div class="card">
            <p>Dish:<?= htmlspecialchars($item['nomPlat']) ?></p>
            <p>Quantity: <?= htmlspecialchars($item['quantity']) ?></p>
            <p>prix: <?= htmlspecialchars($item['prix']) ?></p>
          
            <form method="post">
                <input type="hidden" name="idPlat" value="<?= $idPlat ?>">
                <button type="submit" name="submit" class="quantity-btn">-</button>
                <button type="submit" name="button" class="quantity-btn">+</button>
            </form>
            <form method="post">
                <input type="hidden" name="idPlat" value="<?= $idPlat ?>">
                <button type="submit" name="remove_from_cart" class="remove-btn">Remove</button>
            </form>
        </div>
        
    <?php endforeach; ?>
        <h3>Total: <?= $total ?> DH</h3>
    <?php else: ?>
        <p>Your cart is empty!</p>
    <?php endif; ?>
</div>
</body>
</html>
