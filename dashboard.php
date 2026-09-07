<?php

session_start();

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}

?>

<!DOCTYPE html>

<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>

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


<section class="dashboard">

<h1>
Welcome, <?php echo $_SESSION["user_name"]; ?> 👋
</h1>


<div class="dashboard-cards">

<div class="dashboard-card">

<h3>📦 List Item</h3>

<p>
Share something you don't need.
</p>

<br>

<a href="add_item.php" class="button">
Add Item
</a>

</div>


<div class="dashboard-card">

<h3>🔍 Browse</h3>

<p>
Find items shared by others.
</p>

<br>

<a href="browse.php" class="button">
Browse
</a>

</div>


<div class="dashboard-card">

<h3>📋 My Items</h3>

<p>
View your listed items.
</p>

<br>

<a href="my_items.php" class="button">
My Items
</a>

</div>

</div>

</section>

</body>

</html>