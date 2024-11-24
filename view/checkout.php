<?php
include '../db/onlineconfig.php';
session_start();

$total = 0; 

$basketItems = [];
$sql = "SELECT * FROM mimosami_basket";
$result = $conn->query($sql);

//insert into table
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $basketID = $row['basketID'] ?? 'N/A';
        $productID = $row['productID'] ?? 'N/A';
        $productName = $row['productName'] ?? 'N/A';
        $quantity = $row['quantity'];
        $price = $row['price'];
        $itemTotal = $quantity * $price;
        $total += $itemTotal;
        $_SESSION['total'] = $total;

        $basketItems[] = $row;
    }
}

//update cart
if (isset($_POST['addItem'])) {
    $basketID = $_POST['basketID']; 
    $sql = "SELECT quantity FROM mimosami_basket WHERE basketID='$basketID'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $quantity = $row['quantity'] + 1;  
        $updateSQL = "UPDATE mimosami_basket SET quantity='$quantity' WHERE basketID='$basketID'";
        $conn->query($updateSQL);
        header("Location: ../view/checkout.php");
    }
}

if (isset($_POST['removeItem'])) {
    $basketID = $_POST['basketID'];  
    $sql = "SELECT quantity FROM mimosami_basket WHERE basketID='$basketID'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $quantity = max($row['quantity'] - 1, 1); 
        $updateSQL = "UPDATE mimosami_basket SET quantity='$quantity' WHERE basketID='$basketID'";
        $conn->query($updateSQL);
        header("Location: ../view/checkout.php");
    }
}

if (isset($_POST['delete'])) {
    $basketID = $_POST['basketID'];  
    $sql = "DELETE FROM mimosami_basket WHERE basketID='$basketID'";
    $conn->query($sql);
    header("Location: ../view/checkout.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Basket</title>
	<link rel="icon" type="image/x-icon" href="../assets/favicon/mimosamifav.ico">
	<link rel="stylesheet" href="../assets/css/MimosamiStyleLogin.css?v=1.0">
</head>

<body>
  <header class="scrolled banner">
      <a href="Homepage.html"><h1>Mimosami</h1></a>
  </header>

  <main>
  <form id="checkout" method="POST" action="../actions/uploadorder.php">
      <h2>Basket</h2>
      <div class="grid-container card">
          <table class="table">
              <tr class="headings">
                  <th>Product ID</th>
                  <th>Product Name</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Item Total</th>
                  <th>Actions</th>
              </tr>
              <?php if (!empty($basketItems)): ?>
              <?php foreach ($basketItems as $item): ?>
                  <tr>
                      <td><?php echo htmlspecialchars($item['productID']); ?></td>
                      <td><?php echo htmlspecialchars($item['productName']); ?></td>
                      <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                      <td><?php echo htmlspecialchars($item['price'], 2); ?></td>
                      <td><?php echo htmlspecialchars($item['itemTotal'],2 ); ?></td>
                      <td>
                        <form method="POST" action="">
                            <input type="hidden" name="basketID" value="<?php echo htmlspecialchars($item['basketID']); ?>" />
                            <button class="smallButton addItem" type="submit" name="addItem">Add Item</button>
                            <button class="smallButton removeItem" type="submit" name="removeItem">Remove Item</button>
                            <button class="smallButton delete" type="submit" name="delete">Delete</button>
                        </form>
                      </td>
                  </tr>
              <?php endforeach; ?>
              <?php else: ?>
                          <tr>
                              <td colspan="5">No items in the basket.</td>
                          </tr>
                      <?php endif; ?>
          </table>

          <h3>Total: <?php echo htmlspecialchars($total); ?></h3>
          <a href="../view/Products.php"><button id="action-button" class="custom-button">Continue Shopping</button></a>
      </div>

      <div class="card" style="text-align:left">
        <h2>Checkout</h2>
        <p>Please enter your details below</p>
          <h2>Delivery</h2>
            <label for="address">Address</label>
            <input id="address" name="address" type="text" required >
            <br>

            <label for="phoneNumber">Phone Number</label>
            <input id="phoneNumber" name="phoneNumber" type="text" required >
            <br>


          <h2>Payment</h2>
            <label for="cardNumber">Card Number</label>
            <input id="cardNumber" name="card_number" type="text" required>
            <br>

            <label for="cardName">Name</label>
            <input id="cardName" name="cardName" type="text" required>
            <br>

            <label for="expiry">Expiry Date</label>
            <input id="expiry" name="expiry" type="date" required>
            <br>

            <label for="cvc">CVC</label>
            <input id="cvc" name="cvc" type="text" required>
            <br>

            <button type="submit" name="purchase">PURCHASE</button>
            </div>    
        </form>
      
  </main>

  <footer>
      <div class="footer-content">
          <p class="follow-text">Connect</p>
          <img src="../assets/images/insta.png" alt="Instagram Logo" class="social-logo">
      </div>
    
      <p class="footer-note">© 2024 All rights reserved <br>
          <a href="#">Privacy Policy</a> | <a href="#">Terms and Conditions</a> <br>
          Powered by Power
      </p>
  </footer>

</body>

</html>

