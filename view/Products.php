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

<<<<<<< Updated upstream
    // Mapping product IDs to their respective images and descriptions
    $imageMap = [
        "P002" => "../assets/images/fudgy_brownies.jpg",
        "P003" => "../assets/images/cookie_monster.jpg",
        "P001" => "../assets/images/cupcake.jpg"
    ];
=======
// Mapping product IDs to their respective images and descriptions
$imageMap = [
    "P001" => "../assets/images/fudgy_brownies.jpg",
    "P002" => "../assets/images/cookie_monster.jpg",
    "P003" => "../assets/images/cupcake.jpg"
];
>>>>>>> Stashed changes

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
    <link rel="stylesheet" href="../assets/css/MimosamiStyle.css?v1.0">
    <title>Products</title>
</head>

<body class="products">

<<<<<<< Updated upstream

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
   
<main>   
    <div>
        <h2>Products</h2>

        <div class="grid-container">
            <?php foreach ($products as $product): 
                $productID = $product['productID'];
                $productName = $product['productName'];
                $price = $product['price'];
                $image = $imageMap[$productID];
                $description = $descriptionMap[$productID];
            ?>
                <div class="grid-container-2-columns" id="card">
                    <!-- Product Image -->
                    <div class="product-grid-item">
                        <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($productName); ?>">
=======
    <main>
        <div class="banner">
            <nav class="nav-links">
                <button class="nav-button"><a href="checkout.php">Basket</a></button>
            </nav>
            <header class="scrolled">
                <a href="Homepage.html">
                    <h1>Mimosami</h1>
                </a>
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
                    $productID = $product['productID'];
                    $productName = $product['productName'];
                    $price = $product['price'];
                    $image = $imageMap[$productID];
                    $description = $descriptionMap[$productID];
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
                                <input type="hidden" name="productID" value="<?php echo htmlspecialchars($productID); ?>">
                                <input type="hidden" name="productName" value="<?php echo htmlspecialchars($productName); ?>">
                                <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">
                                <label for="quantity-<?php echo htmlspecialchars($productID); ?>">Quantity:</label>
                                <input
                                    type="number"
                                    name="quantity"
                                    id="quantity-<?php echo htmlspecialchars($productID); ?>"
                                    min="1"
                                    placeholder="Enter quantity"
                                    required>
                                <button type="submit" class="custom-button">Add to basket</button>
                            </form>
                        </div>
>>>>>>> Stashed changes
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

<<<<<<< Updated upstream
                    <!-- Product Details -->
                    <div class="product-grid-item">
                        <h2 id="productName"><?php echo htmlspecialchars($productName); ?></h2>
                        <p><?php echo htmlspecialchars($description); ?></p>
                        <h3 id="price">$<?php echo htmlspecialchars($price); ?></h3>
                        
                        <!-- Add to Basket Form -->
                        <form id="addToBasket" method="POST" action="../actions/basket.php">
                            <input type="hidden" name="productID" value="<?php echo htmlspecialchars($productID); ?>">
                            <input type="hidden" name="productName" value="<?php echo htmlspecialchars($productName); ?>">
                            <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">
                            <label style="text-align:10px">Enter the quantity:</label>
                            <input type="text" name="quantity" id="quantity"><br>
                            <button type="submit" class="custom-button">Add to basket</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

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


</body>
<script>
const form = document.getElementById("addToBasket");

form.addEventListener('submit', function(event) {
    event.preventDefault();

    const quantity = document.getElementById('quantity').value;  

    if (isNaN(quantity) || quantity <= 0) {
        alert('Please enter a quantity greater than 0');
        return;  
    }

    form.submit();
});
</script>
</html>



=======
        <footer id="footer">
            <div class="footer-content">
                <p class="follow-text">Connect</p>
                <img src="../assets/images/insta.png" alt="Instagram Logo" class="social-logo">
            </div>
            <div class="footer-content">
                <p class="footer-note">© 2024 All rights reserved <br>
                    <a href="#">Privacy Policy</a> | <a href="#">Terms and Conditions</a> <br>
                    Powered by Power
                </p>
            </div>
        </footer>
    </main>

</body>
>>>>>>> Stashed changes

</html>