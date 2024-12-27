<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1, h2 {
            color: #333;
        }
        .api-section {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        pre {
            background-color: #f1f1f1;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<h1>API Documentation</h1>

<div class="api-section">
    <h2>1. Transfer Funds API</h2>
    <p>This API is used to transfer an amount from one card to another.</p>
    <p><strong>URL:</strong> <code>POST http://127.0.0.1:8035/api/transactions/transfer</code></p>
    <p><strong>Parameters:</strong></p>
    <ul>
        <li><strong>source_card_id:</strong> The source card number (e.g., <code>5022-2921-2456-3430</code>)</li>
        <li><strong>destination_card_id:</strong> The destination card number (e.g., <code>5022-2994-3473-0761</code>)</li>
        <li><strong>amount:</strong> The transfer amount (e.g., <code>1000</code>)</li>
    </ul>
    <p><strong>Headers:</strong></p>
    <pre>Accept: application/json</pre>
</div>

<div class="api-section">
    <h2>2. Top Users API</h2>
    <p>This API retrieves the top users based on their transactions.</p>
    <p><strong>URL:</strong> <code>GET http://127.0.0.1:8035/api/transactions/top-users</code></p>
    <p><strong>Headers:</strong></p>
    <pre>Accept: application/json</pre>
</div>

</body>
</html>
