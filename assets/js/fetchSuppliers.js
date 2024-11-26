function fetchSuppliers() {
    fetch('../actions/suppliers.php')  // Replace with your actual API endpoint
        .then(response => response.json())  // Parse the JSON response
        .then(data => {
            const supplierTableBody = document.querySelector('#supplierTable tbody');
            supplierTableBody.innerHTML = '';  // Clear existing table rows

            if (data.length === 0) {
                supplierTableBody.innerHTML = '<tr><td colspan="5">No suppliers found.</td></tr>';
            } else {
                // Loop through each supplier and create a new table row
                data.forEach(supplier => {
                    const row = document.createElement('tr');
                    
                    row.innerHTML = `
                        <td>${supplier.SupplierID}</td>
                        <td>${supplier.SupplierName}</td>
                        <td>${supplier.Email}</td>
                        <td>${supplier.PhoneNumber}</td>
                        <td>${supplier.Status}</td>
                    `;

                    supplierTableBody.appendChild(row);
                });

        
        })
        .catch(error => {
            console.error('Error fetching supplier data:', error);
            alert('There was an error fetching supplier data.');
        });
}


// Fetch suppliers when the page loads
window.onload = fetchSuppliers;
