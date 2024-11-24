$basketItems = [];
$basketQuant=[];

$sql = "SELECT productID, quantity FROM mimosami_basket";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $basketItems[] = $row['productID']; // Add product ID to basketItems array
        $basketQuant[] = intval($row['quantity']); // Add quantity to basketQuant array
    }

$tableName = "mimosami_orders";

if (!empty($basketItems) && !empty($basketQuant)) {
    $stmt = $conn->prepare("INSERT INTO $tableName (productID, quantity) VALUES (?, ?)");

    // Loop through arrays and insert data
    for ($i = 0; $i < count($basketItems); $i++) {
        $stmt->bind_param("si", $basketItems[$i], $basketQuant[$i]);
        $stmt->execute();
    }