<?php
session_start();

// Check if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin_dashboard.php");
    exit;
}

// Initialize error variable
$error = '';

// Process login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Check credentials (you should use more secure authentication in production)
    if ($username === 'neutralise.in' && $password === 'Skin@88227') {
        $_SESSION['admin_logged_in'] = true;
        
        // Debug logging
        error_log("Admin login successful. Redirecting to dashboard...");
        
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = 'Invalid username or password';
        
        // Debug logging
        error_log("Admin login failed. Username: $username");
    }
}

// Debug logging
error_log("Admin login page loaded");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Neutralise Naturals</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-login-container">
        <div class="login-box">
            <div class="login-header">
                <h1>Admin Login</h1>
                <p>Please enter your credentials to continue</p>
            </div>

            <?php if ($error): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" id="username" name="username" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" required>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    <span>Login</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <div class="back-to-site">
                <a href="index.php">
                    <i class="fas fa-arrow-left"></i>
                    Back to Website
                </a>
            </div>
        </div>
    </div>

    <style>
    .admin-login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--main-bg-color) 0%, #ffffff 100%);
        padding: 20px;
    }

    .login-box {
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .login-header h1 {
        font-family: var(--font-heading);
        font-size: 2rem;
        color: var(--text-color);
        margin-bottom: 10px;
    }

    .login-header p {
        color: #666;
        font-size: 0.9rem;
    }

    .error-message {
        background: #f8d7da;
        color: #721c24;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #444;
        font-weight: 500;
    }

    .input-group {
        position: relative;
    }

    .input-group i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }

    .input-group input {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .input-group input:focus {
        outline: none;
        border-color: var(--green-bg-color);
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .login-btn {
        width: 100%;
        padding: 12px;
        background: var(--green-bg-color);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
    }

    .login-btn:hover {
        background: var(--hover-color);
        transform: translateY(-2px);
    }

    .back-to-site {
        text-align: center;
        margin-top: 20px;
    }

    .back-to-site a {
        color: #666;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .back-to-site a:hover {
        color: var(--green-bg-color);
    }

    @media (max-width: 480px) {
        .login-box {
            padding: 30px 20px;
        }

        .login-header h1 {
            font-size: 1.8rem;
        }
    }
    </style>
</body>
</html> 