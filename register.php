<?php

include "db.php";

$message = "";

if (isset($_POST["register"])) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash(
        $_POST["password"],
        PASSWORD_DEFAULT
    );

    $sql = "INSERT INTO users
            (name, email, password)
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $name,
        $email,
        $password
    );

    if (mysqli_stmt_execute($stmt)) {

        header("Location: login.php");
        exit();

    } else {

        $message = "Email already exists.";

    }
}

?>

<!DOCTYPE html>

<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

<link rel="stylesheet" href="style.css">

</head>

<body>

<div class="form-container">

<h2>Create Account</h2>

<p><?php echo $message; ?></p>

<form method="POST">

<input
type="text"
name="name"
placeholder="Full Name"
required
>

<input
type="email"
name="email"
placeholder="Email"
required
>

<input
type="password"
name="password"
placeholder="Password"
required
>

<button name="register">
Register
</button>

</form>

<p>
Already have an account?
<a href="login.php">Login</a>
</p>

</div>

</body>

</html>