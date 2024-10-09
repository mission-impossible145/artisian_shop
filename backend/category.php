<?php
session_start();
include 'db_connection.php';

// Fetch categories from the database
$sql = "SELECT category_id, category_name FROM categories"; // Fetching category ID and name
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Categories</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Hero section */
        .categories-hero {
            background-color: #8e44ad; /* Purple background */
            color: white;
            text-align: center;
            padding: 50px 20px;
            width: 100%;
        }

        /* Section title styling */
        .categories-hero h2 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .categories-hero p {
            font-size: 18px;
            margin-top: 0;
        }

        /* Categories listing */
        .categories-listing {
            width: 100%;
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .categories-listing h3 {
            font-size: 28px;
            margin-bottom: 30px;
            text-align: center;
        }

        .categories-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        /* Individual category item */
        .category-item {
            background-color: white;
            margin: 15px;
            padding: 20px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            width: 220px;
            height: 150px;
        }

        .category-item:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
        }

        /* Category links */
        .category-item a {
            text-decoration: none;
            color: #333;
        }

        .category-item h4 {
            font-size: 20px;
            margin: 0;
            color: #8e44ad; /* Purple color for category title */
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .category-item {
                width: 45%;
            }
        }

        @media (max-width: 480px) {
            .category-item {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <section class="categories-hero">
        <h2>Explore Our Categories</h2>
        <p>Find the perfect handcrafted items from talented artisans.</p>
    </section>

    <!-- Categories Section -->
    <section class="categories-listing">
        <h3>Categories</h3>
        <div class="categories-container">
            <?php while ($category = $result->fetch_assoc()): ?>
                <div class="category-item">
                    <a href="products.php?category_id=<?= $category['category_id'] ?>"> <!-- Use category ID for the link -->
                        <h4><?= htmlspecialchars($category['category_name']) ?></h4> <!-- Display category name -->
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

</body>
</html>
