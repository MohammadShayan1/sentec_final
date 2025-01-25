<?php
include 'header.php';
?>
<?php
include 'db_connection.php'; // Include your database connection file

// Fetch distinct categories
$category_query = "SELECT DISTINCT category FROM team_members ORDER BY FIELD(category, 'Executive Committee', 'Directors', 'Co-Directors')";
$category_result = $conn->query($category_query);
?>
<link rel="stylesheet" href="./css/team.css">

<div class="container my-4 p-3">
    <?php while ($category_row = $category_result->fetch_assoc()): 
        $category = $category_row['category'];
        
        // Fetch team members for this category
        $query = "SELECT * FROM team_members WHERE category = ? ORDER BY id ASC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();
    ?>

        <h2 class="mt-4"><?= htmlspecialchars($category) ?></h2> <!-- Category Heading -->
        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-lg-4">
                    <div class="card p-0">
                        <div class="card-image">
                            <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="w-100">
                        </div>
                        <div class="card-content d-flex flex-column align-items-center">
                            <h4 class="pt-2"><?= htmlspecialchars($row['name']) ?></h4>
                            <h5><?= htmlspecialchars($row['designation']) ?></h5>

                            <?php if ($row['linkedin']): ?>
                                <a href="<?= htmlspecialchars($row['linkedin']) ?>" class="btn btn-primary mt-3">LinkedIn</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endwhile; ?>
</div>

<?php $conn->close(); ?>
<?php 
include 'footer.php';
?>
