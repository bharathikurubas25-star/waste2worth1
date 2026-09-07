<?php

session_start();

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}

include "db.php";

$item_id = $_GET["id"];

$requester_id = $_SESSION["user_id"];


$sql = "INSERT INTO requests
        (item_id, requester_id)
        VALUES (?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $item_id,
    $requester_id
);

mysqli_stmt_execute($stmt);


echo "<h2>Item requested successfully! ✅</h2>";

echo "<a href='browse.php'>Back to Browse</a>";

?>