<?php

session_start();

include "db.php";

$sql = "SELECT items.*, users.name
        FROM items
        JOIN users
        ON items.user_id = users.id
        WHERE items.status = 'Available'
        ORDER BY items.id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>

<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Browse Items - Waste2Worth</title>

<link rel="stylesheet" href="style.css">

</head>

<body>

<nav>

<h2>♻️ Waste2Worth</h2>

<div>

<a href="index.php">Home</a>

<a href="dashboard.php">Dashboard</a>

<a href="my_items.php">My Items</a>

<a href="logout.php">Logout</a>

</div>

</nav>


<section class="items-container">

<h1>Available Items</h1>

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
<strong>Owner:</strong>
<?php echo htmlspecialchars($item["name"]); ?>
</p>


<?php if (isset($_SESSION["user_id"])): ?>

<a
href="request.php?id=<?php echo $item["id"]; ?>"
class="button"
>
Request Item
</a>

<?php endif; ?>

</div>

<?php endwhile; ?>

</div>

</section>

</body>

</html>