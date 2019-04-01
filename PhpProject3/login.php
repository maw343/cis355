<?php
session_start();
require_once 'database.php';
require "customer.class.php";
$cust = new Customer();

if($_GET) $errorMessage = $_GET['errorMessage'];
else $errorMessage = '';
if($_POST['signin']) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $pdo = Database::connect();
    $sql= "SELECT * FROM customers WHERE email = '$username' AND password_hash = '$password' LIMIT 1";
    $q = $pdo->prepare($sql);
    $q->execute(array());
    $data = $q->fetch(PDO::FETCH_ASSOC);
    
    if($data) {
        $_SESSION["username"] = $username;
        header("Location: customers.php?id=$username ");
    }
    else {
        header("Location: login.php?errorMessage=Invalid");
        exit();
    }
} elseif($_POST['join']) {
    $_SESSION["username"] = "Join";
    header("Location: customers.php?fun=display_join_screen");
}

?>
<h1>Log in</h1>
<form class="form-horizontal" action="login.php" method="post">

    <input name="username" type="text" placeholder="me@email.com" required>
    <input name="password" type="password" required>
    <input type="submit" class="btn btn-success" name="signin">Sign In</input>
    <input type="submit" class="btn btn-success" name="join">Sign Up</input>
    
    <p style='color: red;'><?php echo $errorMessage; ?></p>
    
</form>