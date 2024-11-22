<?php
session_start();

    include '../db/config.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productId = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);
    
        $stmt = $pdo->prepare("SELECT * FROM mimosami_products WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($product) {
                if (!isset($_SESSION['basket'])) {
                $_SESSION['basket'] = [];
            }
    
            // Add or update product in the basket
            if (isset($_SESSION['basket'][$productId])) {
                $_SESSION['basket'][$productId]['quantity'] += $quantity;
            } else {
                $_SESSION['basket'][$productId] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity,
                ];
            }
    
            header('Location: basket.php'); // Redirect to basket page
            exit;
        } else {
            echo "Product not found.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="image/x-icon" href="xxx">
	<link rel="stylesheet" href="../assets/css/MimosamiStyle.css">
    <title>Products</title>
</head>
<body class="products">

<main>
    <div class="banner">
        <nav class="nav-links">
                <button class="nav-button"><a href="checkout.html">Basket</a></button>
        </nav>
    
        <header class="scrolled">
            <a href="Homepage.html"><h1>Mimosami</h1></a>
        </header>
    </div>

    <div class="homepageVideo">
        <video autoplay loop muted>
            <source src="../assets/videos/mimovid2.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    
    <div>
        <h2>Products</h2>

        <div class="grid-container-2-columns" id="card">
            <div class="product-grid-item">
                <img style="width:100px; height:auto" src="../assets/images/fudgy_brownies.jpg">
            </div>

            <div class="product-grid-item" id="">
                <h3 id="productName">Brownies</h3>
                <p>Fudgy, rich brownies with chunks of dark chocolate for cocoa lovers.</p>
                <h3 id="price">$20</h3>
                <form id="addToBasket" method="POST">
                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                    <div>
                        <button class="plus-btn" type="button" name="button">+</button>
                        <input type="text" name="quantity" id="brownie-quantity" value="1">
                        <button class="minus-btn" type="button" name="button">-</button>
                    </div>
                    <button type="submit" class="custom-button">Add to basket</button>
                </form>
            </div>  
        </div>

        <div class="grid-container-2-columns" id="card">
            <div class="product-grid-item">
                <img style="width:100px; height:auto" src="../assets/images/fudgy_brownies.jpg">
            </div>

            <div class="product-grid-item">
                <h3 id="productName">Cookies</h3>
                <p>Fudgy, rich brownies with chunks of dark chocolate for cocoa lovers.</p>
                <h3 id="price">$20</h3>
                <form id="addToBasket" method="POST">
                    <input type="hidden" name="product_id">
                    <div>
                        <button class="plus-btn" type="button" name="button">+</button>
                        <input type="text" name="quantity" id="cookie-quantity" value="1">
                        <button class="minus-btn" type="button" name="button">-</button>
                    </div>
                    <button type="submit" class="custom-button">Add to basket</button>
                </form>
            </div>  
        </div>

        <div class="grid-container-2-columns" id="card">
            <div class="product-grid-item">
                <img style="width:100px; height:auto" src="../assets/images/fudgy_brownies.jpg">
            </div>

            <div class="product-grid-item">
                <h3 id="productName">Cakes</h3>
                <p>Fudgy, rich brownies with chunks of dark chocolate for cocoa lovers.</p>
                <h3 id="price">$20</h3>
                <form id="addToBasket" method="POST">
                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                    <div>
                        <button class="plus-btn" type="button" name="button">+</button>
                        <input type="text" name="quantity" id="cake-quantity" value="1">
                        <button class="minus-btn" type="button" name="button">-</button>
                    </div>
                    <button type="submit" class="custom-button">Add to basket</button>
                </form>
            </div>  
        </div>

    </div>
    
    <footer>
        <div class="footer-content">
            <p class="follow-text">Connect</p>
            <img src="../assets/images/insta.png" alt="Instagram Logo" class="social-logo">
        </div>
        <p class="footer-note">© 2024 All rights reserved <br> 
        <a href="#">Privacy Policy</a> | <a href="#">Terms and Conditions</a> <br>
        Powered by Power</p>
    </footer>

</main>

</body>

<script>
    $(document).ready(function () {
        $('.minus-btn').on('click', function (e) {
            e.preventDefault();
            // Select the corresponding input field
            const $input = $(this).siblings('#quantity');
            let value = parseInt($input.val());

            if (value > 1) {
                value = value - 1;
            } else {
                value = 1; // Minimum quantity is 1
            }

            $input.val(value);
        });

        $('.plus-btn').on('click', function (e) {
            e.preventDefault();
            // Select the corresponding input field
            const $input = $(this).siblings('#quantity');
            let value = parseInt($input.val());

            if (value < 100) {
                value = value + 1;
            } else {
                value = 100; // Maximum quantity is 100
            }

            $input.val(value);
        });
    });
</script>

</html>


