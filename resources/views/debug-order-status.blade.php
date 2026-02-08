<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Debug</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; }
        .success { color: green; }
        .error { color: red; }
        button { padding: 10px 20px; margin: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Order Status Update Diagnostic</h1>
    
    <div class="test-section">
        <h2>1. Database Test</h2>
        <p>Testing if we can update order status directly in database...</p>
        <button onclick="testDatabase()">Run Database Test</button>
        <div id="db-result"></div>
    </div>
    
    <div class="test-section">
        <h2>2. Current Orders Status</h2>
        <button onclick="showOrders()">Show All Orders</button>
        <div id="orders-list"></div>
    </div>
    
    <div class="test-section">
        <h2>3. Manual Status Update</h2>
        <label>Order ID: <input type="number" id="order-id" value="1"></label><br><br>
        <label>New Status: 
            <select id="new-status">
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </label><br><br>
        <button onclick="updateStatus()">Update Status</button>
        <div id="update-result"></div>
    </div>
    
    <script>
        function testDatabase() {
            document.getElementById('db-result').innerHTML = 'Testing...';
            
            fetch('/api/test-order-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(r => r.json())
            .then(data => {
                document.getElementById('db-result').innerHTML = 
                    `<pre class="${data.success ? 'success' : 'error'}">${JSON.stringify(data, null, 2)}</pre>`;
            })
            .catch(err => {
                document.getElementById('db-result').innerHTML = 
                    `<pre class="error">Error: ${err.message}</pre>`;
            });
        }
        
        function showOrders() {
            document.getElementById('orders-list').innerHTML = 'Loading...';
            
            fetch('/api/orders-status')
            .then(r => r.json())
            .then(data => {
                let html = '<table border="1" cellpadding="5"><tr><th>ID</th><th>Status</th><th>Updated At</th></tr>';
                data.orders.forEach(order => {
                    html += `<tr><td>${order.id}</td><td>${order.status}</td><td>${order.updated_at}</td></tr>`;
                });
                html += '</table>';
                document.getElementById('orders-list').innerHTML = html;
            })
            .catch(err => {
                document.getElementById('orders-list').innerHTML = 
                    `<pre class="error">Error: ${err.message}</pre>`;
            });
        }
        
        function updateStatus() {
            const orderId = document.getElementById('order-id').value;
            const newStatus = document.getElementById('new-status').value;
            
            document.getElementById('update-result').innerHTML = 'Updating...';
            
            fetch(`/api/update-order-status/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(r => r.json())
            .then(data => {
                document.getElementById('update-result').innerHTML = 
                    `<pre class="${data.success ? 'success' : 'error'}">${JSON.stringify(data, null, 2)}</pre>`;
                if (data.success) {
                    showOrders();
                }
            })
            .catch(err => {
                document.getElementById('update-result').innerHTML = 
                    `<pre class="error">Error: ${err.message}</pre>`;
            });
        }
    </script>
</body>
</html>
