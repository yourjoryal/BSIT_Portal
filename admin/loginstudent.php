<?php
    include ("studentdatabase.php");
?>

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
