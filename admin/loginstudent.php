<?php
    include ("studentdatabase.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="../css/loginstudent.css">
</head>
<body>

<h2>Register</h2>

<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Register</button>
</form>

</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if username or password is empty
    if (empty($username) || empty($password)) {
        echo "You must enter both username and password before registering.";
    } else {
        try {
            // Insert user into database
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $username, $password);
            mysqli_stmt_execute($stmt);

            echo "Registration Successful!";
        } 
        catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
    mysqli_close($conn);
?>