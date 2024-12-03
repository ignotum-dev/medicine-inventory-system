<!-- resources/views/emails/low_stock.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Stock Alert</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #dddddd;
        }
        .header {
            background-image: linear-gradient(to right, #ff6f61, #ff8364);
            color: #ffffff;
            text-align: center;
            padding: 30px;
        }
        .header h2 {
            font-size: 28px;
            margin: 0;
            letter-spacing: 1px;
        }
        .content {
            padding: 30px;
            text-align: left;
            line-height: 1.8;
        }
        .content p {
            margin: 10px 0;
        }
        .highlight {
            font-weight: bold;
            color: #ff6f61;
        }
        .cta {
            text-align: center;
            margin-top: 20px;
        }
        .cta a {
            display: inline-block;
            background-color: #ff6f61;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .cta a:hover {
            background-color: #ff4b4b;
        }
        .footer {
            background-color: #f8f8f8;
            color: #666666;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            border-top: 1px solid #eeeeee;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>Low Stock Alert</h2>
        </div>
        <div class="content">
            <p>Dear Admin,</p>
            <p>We’ve noticed that the stock for <span class="highlight">{{ $generic_name }}</span> 
                (Brand: <span class="highlight">{{ $brand_name }}</span>) is critically low.</p>
            <p>Current stock quantity: <span class="highlight">{{ $quantity }}</span></p>
            <p>Please prioritize restocking this item as soon as possible to maintain availability.</p>
            <div class="cta">
                <a href="https://sample.com/medicines/{{ $id }}">View Stock Details</a>
            </div>
        </div>
        <div class="footer">
            <p>Need assistance? Contact us at <a href="mailto:flores.geraldivan@gmail.com">ignotum-dev</a></p>
            <p>&copy; {{ date('Y') }} ignotum-dev. All rights reserved.</p>
        </div>
    </div>
</body>
</html>