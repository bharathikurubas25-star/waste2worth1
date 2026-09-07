<?php

session_start();

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}

include "db.php";

$message = "";

if (isset($_POST["add_item"])) {

    $user_id = $_SESSION["user_id"];

    $item_name = $_POST["item_name"];
    $description = $_POST["description"];
    $category = $_POST["category"];
    $condition = $_POST["condition"];
    $location = $_POST["location"];

    // -------------------------
    // IMAGE UPLOAD
    // -------------------------

    $image_name = "";

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

        $image = $_FILES["image"];

        $original_name = $image["name"];
        $tmp_name = $image["tmp_name"];
        $file_size = $image["size"];

        // Get file extension
        $extension = strtolower(
            pathinfo($original_name, PATHINFO_EXTENSION)
        );

        // Allowed file types
        $allowed_types = ["jpg", "jpeg", "png", "webp"];

        // Maximum size = 5 MB
        $max_size = 5 * 1024 * 1024;

        if (!in_array($extension, $allowed_types)) {

            $message = "Only JPG, JPEG, PNG and WEBP images are allowed.";

        } elseif ($file_size > $max_size) {

            $message = "Image size must be less than 5 MB.";

        } else {

            // Create unique image name
            $image_name = uniqid("item_", true) . "." . $extension;

            // Upload location
            $upload_path = "uploads/" . $image_name;

            if (move_uploaded_file($tmp_name, $upload_path)) {

                // Insert item into database
                $sql = "INSERT INTO items
                        (user_id, item_name, description,
                         category, condition_status, location, image)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";

                $stmt = mysqli_prepare($conn, $sql);

                mysqli_stmt_bind_param(
                    $stmt,
                    "issssss",
                    $user_id,
                    $item_name,
                    $description,
                    $category,
                    $condition,
                    $location,
                    $image_name
                );

                if (mysqli_stmt_execute($stmt)) {

                    header("Location: my_items.php");
                    exit();

                } else {

                    $message = "Database error. Item could not be added.";

                }

            } else {

                $message = "Image upload failed.";

            }
        }

    } else {

        $message = "Please select a product image.";

    }

}

?>

<!DOCTYPE html>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Item - Waste2Worth</title>

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


<div class="form-container">

<h2>📦 List an Item</h2>

<p><?php echo htmlspecialchars($message); ?></p>

<form method="POST" enctype="multipart/form-data">

<input
type="text"
name="item_name"
placeholder="Item Name"
required
>

<textarea
name="description"
placeholder="Description"
rows="4"
></textarea>

<select name="category">

<option value="Books">Books</option>

<option value="Electronics">Electronics</option>

<option value="Clothing">Clothing</option>

<option value="Furniture">Furniture</option>

<option value="Stationery">Stationery</option>

<option value="Other">Other</option>

</select>

<select name="condition">

<option value="Excellent">Excellent</option>

<option value="Good">Good</option>

<option value="Fair">Fair</option>

</select>

<input
type="text"
name="location"
placeholder="Location"
required
>

<label>
<strong>Product Photo</strong>
</label>

<input
type="file"
name="image"
accept=".jpg,.jpeg,.png,.webp"
required
>

<p>
Small note: JPG, JPEG, PNG or WEBP — Maximum 5 MB
</p>

<button type="submit" name="add_item">
📤 List Item
</button>

</form>

</div>

</body>

</html>