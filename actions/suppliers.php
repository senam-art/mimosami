<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "../db/onlineconfig.php";
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Get single supplier
            $id = $_GET['id'];
            $stmt = $conn->prepare("SELECT * FROM mimosami_supplier WHERE SupplierID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            echo json_encode($result->fetch_assoc());
        } else {
            // Get all suppliers
            $result = $conn->query("SELECT * FROM mimosami_supplier");
            $suppliers = [];
            while ($row = $result->fetch_assoc()) {
                $suppliers[] = $row;
            }
            echo json_encode($suppliers);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        
        // Get the next ID
        $result = $conn->query("SELECT MAX(SupplierID) as max_id FROM mimosami_supplier");
        $row = $result->fetch_assoc();
        $newId = $row['max_id'] + 1;

        $stmt = $conn->prepare("INSERT INTO mimosami_supplier (SupplierID, SupplierName, Email, Address, PhoneNumber, Status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $newId, $data['name'], $data['email'], $data['address'], $data['phone'], $data['status']);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Supplier added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error adding supplier']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        
        $stmt = $conn->prepare("UPDATE mimosami_supplier SET SupplierName=?, Email=?, Address=?, PhoneNumber=?, Status=? WHERE SupplierID=?");
        $stmt->bind_param("sssssi", $data['name'], $data['email'], $data['address'], $data['phone'], $data['status'], $data['id']);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Supplier updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating supplier']);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $stmt = $conn->prepare("DELETE FROM mimosami_supplier WHERE SupplierID=?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Supplier deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting supplier']);
        }
        break;
}

$conn->close();