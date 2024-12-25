<?php
session_start(); // Start session
if (!isset($_SESSION['payment_method'])) {
    header("Location: checkout.php");
    exit;
}

$payment_method = $_SESSION['payment_method'];
$total_amount = $_SESSION['total_amount'] ?? 0; // Use null coalescing operator to handle undefined keys
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/payment.css">
    <script src="https://kit.fontawesome.com/85a51766c8.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="payment-container">
        <h1>Payment Details</h1>
        <p>Total Amount: ₹<?php echo number_format($total_amount, 2); ?></p>
        <p>Selected Payment Method: <strong><?php echo htmlspecialchars($payment_method); ?></strong></p>

        <form action="process-payment.php" method="POST" class="payment-form">
            <?php if ($payment_method === 'Credit/Debit Card'): ?>
                <div class="form-group">
                    <label for="card-number">Card Number</label>
                    <input type="text" id="card-number" name="card_number" placeholder="Enter your card number" required>
                </div>
                <div class="form-group">
                    <label for="expiry-date">Expiry Date</label>
                    <input type="text" id="expiry-date" name="expiry_date" placeholder="MM/YY" required>
                </div>
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="password" id="cvv" name="cvv" placeholder="Enter CVV" required>
                </div>
            <?php elseif ($payment_method === 'Paytm'): ?>
                <div class="form-group">
                    <label for="paytm-number">Paytm Number</label>
                    <input type="text" id="paytm-number" name="paytm_number" placeholder="Enter your Paytm number" required>
                </div>
            <?php elseif ($payment_method === 'Google Pay'): ?>
                <div class="form-group">
                    <label for="gpay-number">Google Pay Number</label>
                    <input type="text" id="gpay-number" name="gpay_number" placeholder="Enter your Google Pay number" required>
                </div>
            <?php elseif ($payment_method === 'Net Banking'): ?>
                <div class="form-group">
                    <label for="bank-name">Bank Name</label>
                    <input type="text" id="bank-name" name="bank_name" placeholder="Enter your bank name" required>
                </div>
                <div class="form-group">
                    <label for="account-number">Account Number</label>
                    <input type="text" id="account-number" name="account_number" placeholder="Enter your account number" required>
                </div>
            <?php endif; ?>

            <button type="submit" class="submit-button">Proceed to Pay</button>
        </form>
    </div>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .payment-container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
            color: #333;
        }

        p {
            font-size: 1.2rem;
            color: #666;
        }

        .payment-form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 1rem;
            color: #333;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .submit-button {
            width: 100%;
            padding: 12px;
            font-size: 1.2rem;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-button:hover {
            background: #0056b3;
        }

        @media (max-width: 768px) {
            .payment-container {
                margin: 20px;
                padding: 15px;
            }

            h1 {
                font-size: 2rem;
            }

            p {
                font-size: 1rem;
            }

            .form-group input {
                font-size: 0.9rem;
            }

            .submit-button {
                font-size: 1rem;
                padding: 10px;
            }
        }
    </style>

    <?php include('footer.php');?>
</body>
</html>
