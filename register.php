<?php
// Start output buffering at the very beginning
ob_start();
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// If user is already logged in, redirect to home page
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Get and sanitize input
        $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $address = mysqli_real_escape_string($con, $_POST['address']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate input
        $errors = array();

        // Validate full name
        if (empty($full_name)) {
            $errors[] = "Full name is required";
        }

        // Validate email
        if (empty($email)) {
            $errors[] = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }

        // Validate phone (10 digits)
        if (empty($phone)) {
            $errors[] = "Phone number is required";
        } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
            $errors[] = "Phone number must be 10 digits";
        }

        // Validate address
        if (empty($address)) {
            $errors[] = "Address is required";
        }

        // Validate password
        if (empty($password)) {
            $errors[] = "Password is required";
        } elseif (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters";
        }

        // Validate password confirmation
        if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match";
        }

        // If no errors, proceed with registration
        if (empty($errors)) {
            // Check if email already exists
            $stmt = $con->prepare("SELECT id FROM register WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Email already registered";
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Begin transaction
                $con->begin_transaction();

                try {
                    // Insert new user
                    $stmt = $con->prepare("INSERT INTO register (full_name, email, phone, address, password) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssss", $full_name, $email, $phone, $address, $hashed_password);

                    if ($stmt->execute()) {
                        // Commit transaction
                        $con->commit();
                        
                        // Clean all output buffers
                        while (ob_get_level()) {
                            ob_end_clean();
                        }
                        
                        // Set success message and redirect
                        $_SESSION['registration_success'] = true;
                        header("Location: Login-Register.php?registered=1");
                        exit;
                    } else {
                        throw new Exception("Failed to insert user data");
                    }
                } catch (Exception $e) {
                    // Rollback on error
                    $con->rollback();
                    $error = "Registration failed. Please try again.";
                    error_log("Registration error: " . $e->getMessage());
                }
            }
        } else {
            $error = implode("<br>", $errors);
        }
    } catch (Exception $e) {
        $error = "An error occurred. Please try again later.";
        error_log("Registration error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Neutralise Naturals</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include('header.php')?>

    <main class="register-container">
        <div class="register-box">
            <h1>Create Account</h1>
            
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="register-form">
                <div class="form-group">
                    <label for="full_name">Full Name*</label>
                    <input type="text" id="full_name" name="full_name" required value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number*</label>
                    <input type="tel" id="phone" name="phone" required pattern="[0-9]{10}" title="Please enter a valid 10-digit phone number" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="address">Address*</label>
                    <textarea id="address" name="address" required rows="3"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="password">Password*</label>
                    <input type="password" id="password" name="password" required minlength="6">
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password*</label>
                    <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
                </div>

                <button type="submit" class="register-button">Create Account</button>
            </form>

            <div class="login-link">
                Already have an account? <a href="Login-Register.php">Login here</a>
            </div>
        </div>
    </main>

    <?php include('footer.php')?>

<style>
.register-container {
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    background-color: #f8f9fa;
}

.register-box {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
}

.register-box h1 {
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

.register-form {
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

.form-group input,
.form-group textarea {
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: var(--green-bg-color);
    outline: none;
}

.register-button {
    background-color: var(--green-bg-color);
    color: white;
    padding: 0.75rem;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.register-button:hover {
    background-color: var(--dark-green-color);
}

.login-link {
    text-align: center;
    margin-top: 1.5rem;
    color: #666;
}

.login-link a {
    color: var(--green-bg-color);
    text-decoration: none;
    font-weight: 500;
}

.login-link a:hover {
    text-decoration: underline;
}

@media (max-width: 480px) {
    .register-box {
        padding: 1.5rem;
    }

    .register-box h1 {
        font-size: 1.5rem;
    }

    .form-group input,
    .form-group textarea {
        padding: 0.6rem;
    }
}
</style>

</body>
</html>