<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $checkEmailQuery = "SELECT id FROM users WHERE email = '$email'";
    $checkResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "Email already exists!";
    } else {
        
        $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$passwordHash')";
        if (mysqli_query($conn, $query)) {
            echo "success";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
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
    <h2 id="formTitle">Register</h2>
    
    <!-- Register Form -->
    <form id="registerForm">
        <div class="mb-3">
            <input type="text" id="name" class="form-control" placeholder="Full Name" required>
        </div>
        <div class="mb-3">
            <input type="email" id="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <input type="password" id="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>

    <p class="switch-link" id="toggleForm">Already have an account? Login</p>
</div>

<script>
    $(document).ready(function() {
        // Register User
        $("#registerForm").submit(function(e) {
            e.preventDefault();
            let name = $("#name").val();
            let email = $("#email").val();
            let password = $("#password").val();

            $.ajax({
                url: "register.php",
                type: "POST",
                data: { name, email, password },
                success: function(response) {
                    
                        
                            window.location.href ="login.php";  
                
                    
                }
            });
        });

        
        $("#toggleForm").click(function() {
            window.location.href = "login.php";
        });
    });
</script>

</body>
</html>
