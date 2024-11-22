<?php
    include '../db/config.php';

    session_start();

    // Query to fetch all products from the database
    $sql = "SELECT * FROM mimosami_basket";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $productName = $row['productName'];
      $price = $row['price'];
      $quantity=$_POST['quantity'];
      $item_total = $quantity * $price;
      $total += $item_total;
    }

?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - Daily UI - Credit card checkout</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/MimosamiStyleLogin.css">

</head>
<body>

    <header class="scrolled banner">
        <a href="Homepage.html"><h1>Mimosami</h1></a>
    </header>

<main>
<h2>Basket</h2>
<div class="grid-container">
      <div class="grid-container-2-columns" id="card">
          <!-- Items -->
           <table>
              <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Item Total</th>
              </tr>
                <td><?php echo htmlspecialchars($producID); ?></td>
                <td><?php echo htmlspecialchars($productName);?></td>
                <td><?php echo htmlspecialchars($quantity);?></td>
                <td><?php echo htmlspecialchars($price);?></td>
                <td><?php echo htmlspecialchars($itemTotal);?></td>
           </table>

           <h3>Total</h3>
           <p><?php echo htmlspecialchars($total);?></p>

</div>

<h2>Checkout</h2>
<form id="checkout" class="card" method="POST">
     <label for="cn">CARD NUMBER</label>
      <input id="cn" type="text" />
      <br>
      <label for="cna">NAME </label>
      <input id="cna" type="text" />
      <br>
      <label for="adsress">ADDRESS</label>
      <input id="address" type="text" />
      <br>
      <label for="cvc">CVC</label>
      <input id="cvc" type="text" />
      <br>
      <button type="submit" class="purchase-button" data-content="PURCHASE">PURCHASE</button>
</form>
</main>
  
<footer>
  <div class="footer-content">
      <p class="follow-text">Connect</p>
      <img src="../assets/images/insta.png" alt="Instagram Logo" class="social-logo">
  </div>
  <p class="footer-note">© 2024 All rights reserved <br> 
  <a href="#">Privacy Policy</a> | <a href="#">Terms and Conditions</a> <br>
  Powered by Power</p>
</footer>
  
</body>
</html>
