<?php
// Start output buffering at the very beginning
ob_start();
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// If user is already logged in, redirect to home page
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];

    // Validate input
    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields";
    } else {
        $sql = "SELECT * FROM register WHERE email = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['full_name'];
                error_log("Login successful - Session data: " . print_r($_SESSION, true));
                
                // Clean all output buffers
                while (ob_get_level()) {
                    ob_end_clean();
                }
                
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "Email not found";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Neutralise Naturals</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include('header.php'); ?>

    <main class="login-container">
        <div class="login-box">
            <h1>Login</h1>
            
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['registered']) && $_GET['registered'] == 1): ?>
                <div class="success-message">
                    Registration successful! Please login.
                </div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="login-button">Login</button>
            </form>

            <div class="register-link">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
        </div>
    </main>

    <?php include('footer.php'); ?>

<style>
.login-container {
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    background-color: #f8f9fa;
}

.login-box {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

.login-box h1 {
    text-align: center;
    color: var(--text-color);
    margin-bottom: 1.5rem;
    font-size: 1.8rem;
}

.error-message {
    background-color: #f8d7da;
    color: #721c24;
    padding: 0.75rem;
    border-radius: 4px;
    margin-bottom: 1rem;
    text-align: center;
}

.login-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    color: #666;
    font-size: 0.9rem;
}

.form-group input {
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-group input:focus {
    border-color: var(--green-bg-color);
    outline: none;
}

.login-button {
    background-color: var(--green-bg-color);
    color: white;
    padding: 0.75rem;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.login-button:hover {
    background-color: var(--dark-green-color);
}

.register-link {
    text-align: center;
    margin-top: 1.5rem;
    color: #666;
}

.register-link a {
    color: var(--green-bg-color);
    text-decoration: none;
    font-weight: 500;
}

.register-link a:hover {
    text-decoration: underline;
}

@media (max-width: 480px) {
    .login-box {
        padding: 1.5rem;
    }

    .login-box h1 {
        font-size: 1.5rem;
    }

    .form-group input {
        padding: 0.6rem;
    }
}

.success-message {
    background-color: #d4edda;
    color: #155724;
    padding: 0.75rem;
    border-radius: 4px;
    margin-bottom: 1rem;
    text-align: center;
}
</style>

</body>
</html>