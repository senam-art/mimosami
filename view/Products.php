<?php
    include '../db/onlineconfig.php';

    session_start();

    // Query to fetch all products from the database
    $sql = "SELECT * FROM mimosami_products";
    $result = $conn->query($sql);

    $products = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    // Mapping product IDs to their respective images and descriptions
    $imageMap = [
        "P001" => "../assets/images/fudgy_brownies.jpg",
        "P002" => "../assets/images/cookie_monster.jpg",
        "P003" => "../assets/images/cupcake.jpg"
    ];

    $descriptionMap = [
        "P001" => "Celebrate every occasion with our delightful range of cakes. From velvety layers of moist sponge to creamy, flavorful frostings, our cakes are crafted with love and premium ingredients. Whether it’s a birthday, anniversary, or a simple craving, our cakes make every moment special.",
        "P002" => "Indulge in the ultimate chocolate experience with our fudgy, decadent brownies. Made with rich cocoa and chunks of premium dark chocolate, each bite delivers a luscious melt-in-your-mouth sensation. Perfect for chocolate lovers craving a satisfying treat or a sweet pick-me-up.",
        "P003" => "Savor the timeless comfort of our freshly baked cookies. Crispy on the edges, soft in the center, and generously filled with chocolate chips, nuts, or a variety of flavorful surprises. Perfect with a glass of milk or as a snack anytime you want to treat yourself."
    ];
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
            <button class="nav-button"><a href="checkout.php">Basket</a></button>
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

        <div class="grid-container">
            <?php foreach ($products as $product): 
                $id = $product['productID'] ?? ''; // Updated to match database column
                $productName = $product['productName'] ?? 'Unknown Product';
                $price = $product['price'] ?? '0.00';
                $image = $imageMap[$id] ?? '../assets/images/default.jpg';
                $description = $descriptionMap[$id] ?? 'No description available.';
            ?>
                <div class="grid-container-2-columns" id="card">
                    <!-- Product Image -->
                    <div class="product-grid-item">
                        <img style="width:100px; height:auto" src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($productName); ?>">
                    </div>

                    <!-- Product Details -->
                    <div class="product-grid-item">
                        <h3 id="productName"><?php echo htmlspecialchars($productName); ?></h3>
                        <p><?php echo htmlspecialchars($description); ?></p>
                        <h3 id="price">$<?php echo htmlspecialchars($price); ?></h3>
                        
                        <!-- Add to Basket Form -->
                        <form id="addToBasket" method="POST" action="../actions/basket.php">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($id); ?>">
                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($productName); ?>">
                            <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($price); ?>">
                            <input type="text" name="quantity" id="quantity">
                            <button type="submit" class="custom-button">Add to basket</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer id="footer">
        <div class="footer-content">
            <p class="follow-text">Connect</p>
            <img src="../assets/images/insta.png" alt="Instagram Logo" class="social-logo">
        </div>
        <div class="footer-content">
            <p class="footer-note">© 2024 All rights reserved <br> 
            <a href="#">Privacy Policy</a> | <a href="#">Terms and Conditions</a> <br>
            Powered by Power</p>
        </div>
    </footer>
</main>

</body>
<script>

</script>
</html>




