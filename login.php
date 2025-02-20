<?php
// login.php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Prevent SQL Injection
    $email = mysqli_real_escape_string($conn, $email);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify password hash
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            echo "success";
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-image: url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS0fXAf2OenPIKti4vL7P5SxwqbMXLo8FxxmQ&s");
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .btn {
            width: 100%;
        }

        .form-control {
            border-radius: 5px;
        }

        .switch-link {
            margin-top: 10px;
            color: #007bff;
            cursor: pointer;
        }

        .switch-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container">
    <h2 id="formTitle">Login</h2>

    <!-- Login Form -->
    <form id="loginForm">
        <div class="mb-3">
            <input type="email" id="loginEmail" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <input type="password" id="loginPassword" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-success">Login</button>
    </form>

    <p class="switch-link" id="toggleForm">Don't have an account? Register</p>
</div>

<script>
    $(document).ready(function () {
        
        $("#loginForm").submit(function (e) {
            e.preventDefault();
            let email = $("#loginEmail").val();
            let password = $("#loginPassword").val();

            $.ajax({
                url: "login.php",
                type: "POST",
                data: {email, password},
                success: function (response) {
                    
                        Swal.fire("Success!", "Login successful!", "success").then(() => {
                            window.location.href = "index.php";  
                        });
                    
                },
                error: function () {
                    Swal.fire("Error!", "Something went wrong. Try again.", "error");
                }
            });
        });

        $("#toggleForm").click(function () {
            window.location.href = "register.php";  
        });
    });
</script>

</body>

</html>
