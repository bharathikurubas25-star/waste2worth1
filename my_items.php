<?php

session_start();

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}

include "db.php";

$user_id = $_SESSION["user_id"];

$sql = "SELECT *
        FROM items
        WHERE user_id = ?
        ORDER BY id DESC";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $user_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>

<html>

<head>

<title>My Items - Waste2Worth</title>

<link rel="stylesheet" href="style.css">

</head>

<body>

<nav>

<h2>♻️ Waste2Worth</h2>

<div>

<a href="dashboard.php">Dashboard</a>

<a href="browse.php">Browse</a>

<a href="my_items.php">My Items</a>

<a href="logout.php">Logout</a>

</div>

</nav>


<section class="items-container">

<h1>📋 My Items</h1>

<a href="add_item.php" class="button">
+ Add Item
</a>


<div class="item-grid">

<?php while ($item = mysqli_fetch_assoc($result)): ?>

<div class="item-card">

<!-- PRODUCT IMAGE -->

<?php if (!empty($item["image"])): ?>

<img
src="uploads/<?php echo htmlspecialchars($item["image"]); ?>"
alt="<?php echo htmlspecialchars($item["item_name"]); ?>"
class="item-image"
>

<?php else: ?>

<div class="no-image">
📷 No Image
</div>

<?php endif; ?>


<h3>
<?php echo htmlspecialchars($item["item_name"]); ?>
</h3>

<p>
<?php echo htmlspecialchars($item["description"]); ?>
</p>

<p>
<strong>Category:</strong>
<?php echo htmlspecialchars($item["category"]); ?>
</p>

<p>
<strong>Condition:</strong>
<?php echo htmlspecialchars($item["condition_status"]); ?>
</p>

<p>
<strong>Location:</strong>
<?php echo htmlspecialchars($item["location"]); ?>
</p>

<p>
<strong>Status:</strong>

<strong class="status">
<?php echo htmlspecialchars($item["status"]); ?>
</strong>

</p>

</div>

<?php endwhile; ?>

</div>

</section>

</body>

</html>