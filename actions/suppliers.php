<?php

error_reporting(E_ALL); // Report all errors and warnings
ini_set('display_errors', 1); // Display errors on the page

include '../db/onlineconfig.php';

header("Content-Type: application/json");

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == 'GET') {
    // Fetch all suppliers
    $query = "SELECT * FROM mimosami_supplier";
    $result = $conn->query($query);

    $suppliers = [];
    while ($row = $result->fetch_assoc()) {
        $suppliers[] = $row;
    }

    echo json_encode($suppliers);
} elseif ($requestMethod == 'POST') {

    // Save a new supplier
    $data = json_decode(file_get_contents("php://input"), true);

    $name = $data['name'];
    $email = $data['email'];
    $address = $data['address'];
    $phone = $data['phone'];
    $status = $data['status'];

   // Check if the email already exists
   $checkEmailQuery = "SELECT * FROM mimosami_supplier WHERE Email = ?";
   $stmt = $conn->prepare($checkEmailQuery);
   $stmt->bind_param("s", $email); // "s" stands for string
   $stmt->execute();
   $result = $stmt->get_result();

   if ($result->num_rows > 0) {
       // If the email exists, return an error message
       echo json_encode(["error" => "Email already exists"]);
   } else {
       // If the email doesn't exist, proceed to insert the new supplier

        // Extracting the last supplier id
        $query = "SELECT MAX(SupplierID) AS last_id FROM mimosami_supplier";
        $result = $conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            $last_id = $row['last_id'];

            // Increment the last ID by 1
            $new_id = $last_id + 1;

            // Use prepared statements to prevent SQL injection
            $query = $conn->prepare("INSERT INTO mimosami_supplier (SupplierID, SupplierName, Email, Address, PhoneNumber, Status) 
                                    VALUES (?, ?, ?, ?, ?, ?)");

            // Bind parameters, including the new SupplierID
            $query->bind_param("isssss", $new_id, $name, $email, $address, $phone, $status);

            if ($query->execute()) {
                echo json_encode(["success" => true, "message" => "Supplier added successfully"]);
            } else {
                echo json_encode(["success" => false, "error" => "Failed to insert supplier: " . $conn->error]);
            }
        } else {
            echo json_encode(["error" => "Failed to fetch last SupplierID"]);
        }
    }

} elseif ($requestMethod == 'PUT') {
    // Update an existing supplier
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id'], $data['name'], $data['email'], $data['phone'], $data['address'], $data['status'])) {
        echo json_encode(["error" => "Invalid input data"]);
        exit;
    }

    $id = $data['id'];
    $name = $data['name'];
    $email = $data['email'];
    $address = $data['address'];
    $phone = $data['phone'];
    $status = $data['status'];

    // Validate input data
    if (empty($name) || empty($email) || empty($phone) || empty($address)|| empty($status)) {
        echo json_encode(["error" => "All fields are required"]);
        exit;
    }

    // Check if the supplier exists before updating
    $checkSupplierQuery = "SELECT * FROM mimosami_supplier WHERE SupplierID = ?";
    $stmt = $conn->prepare($checkSupplierQuery);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["error" => "Supplier not found"]);
    } else {
        // Use prepared statements for safe updates
        $query = $conn->prepare("UPDATE mimosami_supplier SET SupplierName = ?, Email = ?, PhoneNumber = ?, Status = ? WHERE SupplierID = ?");
        $query->bind_param("ssssi", $name, $email, $phone, $status, $id);

        if ($query->execute()) {
            echo json_encode(["message" => "Supplier updated successfully"]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
    }
}elseif ($requestMethod == 'DELETE') {
    // Delete a supplier
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $query = $conn->prepare("DELETE FROM mimosami_supplier WHERE SupplierID=?");
        $query->bind_param("i", $id);

        if ($query->execute()) {
            echo json_encode(["message" => "Supplier deleted successfully"]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
    } else {
        echo json_encode(["error" => "Supplier ID is required"]);
    }
} else {
    // Unsupported request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Method not allowed"]);
}

