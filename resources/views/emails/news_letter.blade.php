<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Products Newsletter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }
        .header {
            background-color: #333;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .product {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .product:last-child {
            border-bottom: none;
        }
        .product img {
            max-width: 100px;
            margin-right: 20px;
        }
        .product-details {
            flex: 1;
        }
        .product-title {
            font-size: 18px;
            margin: 0 0 10px;
        }
        .product-description {
            margin: 0 0 10px;
            color: #555;
        }
        .product-button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 3px;
            text-align: center;
        }
        .footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="{{ asset('Logo.png') }}" alt="Company Logo">
            <h1>Check Out Our New Products!</h1>
        </div>
        <div class="content">
            @foreach ($products as $product)
            <div class="product">
                @if($product->product_thumbnail)
                <img src="{{ $product->product_thumbnail->file->filename }}" alt="{{ $product->title }}">
                @endif
                <div class="product-details">
                    <h2 class="product-title">{{ $product->title }}</h2>
                    <p class="product-description">{{ $product->description }}</p>
                    <a href="{{ url('/catalog/product/'.$product->id) }}" class="product-button">Shop Now</a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} MK Themed Attractions. All rights reserved.</p>
            <p>Follow us on <a href="#">Facebook</a>, <a href="#">Twitter</a>, and <a href="#">Instagram</a>.</p>
        </div>
    </div>
</body>
</html>
