<?php
session_start(); // Start the session
require_once('Connection.php'); // Include the database connection file

$error_message = ""; // Initialize error message variable

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['Password'];

    // Prepare the SQL statement to check user credentials
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND Password = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // User credentials are valid, perform any desired action
        $_SESSION['loggedin'] = true; // Set a session variable to indicate that the user is logged in
        // Add additional code or redirect to the desired page
        header("Location: AdminDash.php");
        exit();
    } else {
        // Invalid credentials, set the error message
        $error_message = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/stylez.css">
    <script>
        function displayMessage(message, isSuccess) {
            var messageBox = document.getElementById("message-box");
            messageBox.textContent = message;
            messageBox.style.display = "block";
            if (isSuccess) {
                messageBox.style.backgroundColor = "green";
            } else {
                messageBox.style.backgroundColor = "red";
            }
            setTimeout(function () {
                messageBox.style.display = "none";
            }, 3000); // Hide the message after 3 seconds
        }
    </script>
    <style>
        body {
            background-image: url('image/photo\ 3.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .header {
            background-color: rgba(0, 0, 255, 0.7);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 0 0 15px 15px;
        }

        .header-text {
            text-align: center;
            font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }

        .header-text h2 {
            padding-bottom: 0;
            font-size: 20px;
        }

        .header-text p {
            margin-bottom: 0;
            font-size: 20px;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo-container img {
            max-width: 100%;
            height: auto;
            max-height: 100%;
            border-radius: 100%; /* Make it circular */
    width: 100px; /* Adjust the width as needed */
    height: 100px; /* Adjust the height as needed */
    object-fit: cover; /* Ensure the image covers the circular container */
        }

        .login-form {
    max-width: 400px;
    margin: 50px auto; /* Center the form vertically and add top margin */
    padding: 20px;
    background-color: #f8f9fa; /* Light gray background */
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.login-form img {
    display: block;
    margin: 0 auto 20px; /* Center the logo */
    max-width: 100%;
    height: auto;
    max-height: 60px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    font-weight: bold;
    color: black; /* Dark gray text color */
}

.form-control {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ced4da; /* Light gray border */
    border-radius: 4px;
}

.form-control:focus {
    border-color: #007bff; /* Focus color */
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Focus shadow */
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border-radius: 4px;
    display: block;
    margin: 0 auto; /* Center the button */
    transition: background-color 0.3s ease; /* Smooth transition */
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

/* Responsive adjustment for smaller screens */
@media (max-width: 576px) {
    .login-form {
        max-width: 100%;
    }
}


    </style>
</head>

<body>
    <div class="header">
        <div class="logo-container">
            <img src="image/Coat of arms of Tanzania.jpeg" alt="Left Logo" class="brand-photo img-fluid">
        </div>
        <div class="header-text">
            <h2>President's Office,<br>Regional Administration and Local Government</h2>
            <p>Lindi municipal markets management system</p>
        </div>
        <div class="logo-container">
            <img src="image/lindi-municipal.jpg" alt="Right Logo" class="brand-photo img-fluid">
        </div>
    </div>

    <!-- Login Form -->
    <div class="container">
        <div class="login-form">
            <img src="image/Market.png" alt="Login Logo" class="img-fluid">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="email" name="email" class="form-control" id="username"
                        placeholder="Enter your email" required>
                </div><br>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="Password" class="form-control" id="password"
                        placeholder="Enter your password" required>
                </div><br>
                <button type="submit" name="login" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>
    <?php
    // Display the error message using PHP
    if (!empty($error_message)) {
        echo '<script>
                displayMessage("' . $error_message . '", false);
              </script>';
    }
    ?>
</body>

</html>
