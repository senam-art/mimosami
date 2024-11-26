<?php
require_once '../db/onlineconfig.php';

class SupplierManager {
    private $conn;

    public function __construct() {
        $this->conn = getDatabaseConnection();
    }

    // Sanitize input to prevent XSS
    private function sanitizeInput($input) {
        return htmlspecialchars(strip_tags(trim($input)));
    }

    // Generate next supplier ID
    private function generateSupplierID() {
        $query = "SELECT MAX(SupplierID) as max_id FROM mimosami_supplier";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['max_id'] ? $row['max_id'] + 1 : 101;
    }

    // Check if supplier already exists
    private function supplierExists($supplierName, $phoneNumber) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM mimosami_supplier WHERE SupplierName = ? OR PhoneNumber = ?");
        $stmt->bind_param("ss", $supplierName, $phoneNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['count'] > 0;
    }

    // Add new supplier
    public function addSupplier($supplierName, $phoneNumber, $address) {
        // Sanitize inputs
        $supplierName = $this->sanitizeInput($supplierName);
        $phoneNumber = $this->sanitizeInput($phoneNumber);
        $address = $this->sanitizeInput($address);

        // Check for duplicate
        if ($this->supplierExists($supplierName, $phoneNumber)) {
            return [
                'status' => 'error', 
                'message' => 'Supplier with this name or phone number already exists'
            ];
        }

        // Generate new supplier ID
        $supplierID = $this->generateSupplierID();

        // Prepare and execute insert
        $stmt = $this->conn->prepare("INSERT INTO mimosami_supplier (SupplierID, SupplierName, PhoneNumber, Address, IsActive) VALUES (?, ?, ?, ?, 1)");
        $stmt->bind_param("isss", $supplierID, $supplierName, $phoneNumber, $address);
        
        if ($stmt->execute()) {
            $stmt->close();
            return [
                'status' => 'success', 
                'message' => 'Supplier added successfully',
                'supplierId' => $supplierID
            ];
        } else {
            return [
                'status' => 'error', 
                'message' => 'Failed to add supplier: ' . $stmt->error
            ];
        }
    }

    // Update existing supplier
    public function updateSupplier($supplierID, $supplierName, $phoneNumber, $address, $isActive) {
        // Sanitize inputs
        $supplierName = $this->sanitizeInput($supplierName);
        $phoneNumber = $this->sanitizeInput($phoneNumber);
        $address = $this->sanitizeInput($address);
        $isActive = $isActive ? 1 : 0;

        // Prepare and execute update
        $stmt = $this->conn->prepare("UPDATE mimosami_supplier SET SupplierName = ?, PhoneNumber = ?, Address = ?, IsActive = ? WHERE SupplierID = ?");
        $stmt->bind_param("sssii", $supplierName, $phoneNumber, $address, $isActive, $supplierID);
        
        if ($stmt->execute()) {
            $stmt->close();
            return [
                'status' => 'success', 
                'message' => 'Supplier updated successfully'
            ];
        } else {
            return [
                'status' => 'error', 
                'message' => 'Failed to update supplier: ' . $stmt->error
            ];
        }
    }

    // Get suppliers with search and pagination
    public function getSuppliers($search = '', $page = 1, $perPage = 10) {
        // Sanitize search input
        $search = $this->sanitizeInput($search);
        
        // Calculate offset
        $offset = ($page - 1) * $perPage;

        // Prepare base query
        $baseQuery = "FROM mimosami_supplier 
                      WHERE (SupplierName LIKE ? OR PhoneNumber LIKE ? OR Address LIKE ?)";
        
        // Prepare search parameters
        $searchParam = "%{$search}%";

        // Count total results
        $countStmt = $this->conn->prepare("SELECT COUNT(*) as total " . $baseQuery);
        $countStmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
        $countStmt->execute();
        $countResult = $countStmt->get_result();
        $totalCount = $countResult->fetch_assoc()['total'];
        $countStmt->close();

        // Get suppliers with pagination
        $stmt = $this->conn->prepare("SELECT * " . $baseQuery . " LIMIT ? OFFSET ?");
        $stmt->bind_param("sssii", $searchParam, $searchParam, $searchParam, $perPage, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch results
        $suppliers = [];
        while ($row = $result->fetch_assoc()) {
            $suppliers[] = $row;
        }
        $stmt->close();

        // Calculate total pages
        $totalPages = ceil($totalCount / $perPage);

        return [
            'suppliers' => $suppliers,
            'total' => $totalCount,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => $totalPages
        ];
    }

    // Get supplier statistics
    public function getSupplierStatistics() {
        $stmt = $this->conn->prepare("
            SELECT 
                COUNT(*) as total_suppliers, 
                SUM(CASE WHEN IsActive = 1 THEN 1 ELSE 0 END) as active_suppliers
            FROM mimosami_supplier
        ");
        $stmt->execute();
        $result = $stmt->get_result();
        $stats = $result->fetch_assoc();
        $stmt->close();

        return [
            'total_suppliers' => $stats['total_suppliers'],
            'active_suppliers' => $stats['active_suppliers']
        ];
    }

    // Close connection
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
