<?php
header('Content-Type: application/json');
require_once 'supplier_actions.php';

// Initialize supplier manager
$supplierManager = new SupplierManager();

// Handle different actions based on POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'add_supplier':
            // Validate required fields
            $requiredFields = ['supplierName', 'phoneNumber', 'address'];
            $missingFields = [];
            
            foreach ($requiredFields as $field) {
                if (!isset($_POST[$field]) || empty($_POST[$field])) {
                    $missingFields[] = $field;
                }
            }

            if (!empty($missingFields)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Missing required fields: ' . implode(', ', $missingFields)
                ]);
                exit;
            }

            // Add supplier
            $result = $supplierManager->addSupplier(
                $_POST['supplierName'], 
                $_POST['phoneNumber'], 
                $_POST['address']
            );
            echo json_encode($result);
            break;

        case 'update_supplier':
            // Validate required fields
            if (!isset($_POST['supplierID']) || !isset($_POST['supplierName']) || 
                !isset($_POST['phoneNumber']) || !isset($_POST['address'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Missing required fields'
                ]);
                exit;
            }

            // Update supplier
            $result = $supplierManager->updateSupplier(
                intval($_POST['supplierID']), 
                $_POST['supplierName'], 
                $_POST['phoneNumber'], 
                $_POST['address'],
                isset($_POST['isActive']) ? $_POST['isActive'] : 1
            );
            echo json_encode($result);
            break;

        case 'get_suppliers':
            // Get suppliers with optional search and pagination
            $search = $_POST['search'] ?? '';
            $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
            $perPage = isset($_POST['perPage']) ? intval($_POST['perPage']) : 10;

            $result = $supplierManager->getSuppliers($search, $page, $perPage);
            echo json_encode($result);
            break;

        case 'get_supplier_stats':
            // Get supplier statistics
            $result = $supplierManager->getSupplierStatistics();
            echo json_encode($result);
            break;

        default:
            echo json_encode([
                'status' => 'error', 
                'message' => 'Invalid action'
            ]);
    }
} else {
    echo json_encode([
        'status' => 'error', 
        'message' => 'Invalid request method'
    ]);
}