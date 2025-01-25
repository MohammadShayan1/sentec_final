<?php
include 'db_connection.php';
include 'header.php';
?>

<section class="py-5">
    <div class="container">
        <!-- Current Partners Section -->
        <div class="row justify-content-center text-center mb-2 mb-lg-4">
            <div class="col-12 col-lg-8 col-xxl-7 text-center mx-auto" data-aos="fade-up">
                <span class="text-muted">Current</span>
                <h2 class="display-5 fw-bold">Our Current Partners</h2>
                <p class="lead">Meet the amazing organizations we are currently collaborating with.</p>
            </div>
        </div>
        <div class="row">
            <?php
            // Fetch current partners from the database
            $queryCurrent = "SELECT * FROM partners WHERE section = 'current'";
            $resultCurrent = mysqli_query($conn, $queryCurrent);

            if (!$resultCurrent) {
                echo "<p class='text-danger'>Error: " . mysqli_error($conn) . "</p>";
            } elseif (mysqli_num_rows($resultCurrent) > 0) {
                while ($partner = mysqli_fetch_assoc($resultCurrent)) {
                    echo "
                    <div class='col-md-6 mb-4' data-aos='fade-up'>
                        <div class='card shadow-sm'>
                            <img class='card-img-top' src='" . htmlspecialchars($partner['image_url']) . "' alt='" . htmlspecialchars($partner['name']) . "' style='height: 200px; object-fit: cover;'>
                            <div class='card-body'>
                                <h5 class='card-title'>" . htmlspecialchars($partner['name']) . "</h5>
                                <p class='text-muted'>" . htmlspecialchars($partner['role']) . "</p>
                                <p class='card-text'>" . htmlspecialchars($partner['description']) . "</p>
                            </div>
                        </div>
                    </div>
                    ";
                }
            } else {
                echo "<p class='text-center'>No current partners found.</p>";
            }
            ?>
        </div>

        <!-- Past Partners Section -->
        <div class="row justify-content-center text-center mt-5 mb-2 mb-lg-4">
            <div class="col-12 col-lg-8 col-xxl-7 text-center mx-auto" data-aos="fade-up">
                <span class="text-muted">Past</span>
                <h2 class="display-5 fw-bold">Our Past Partners</h2>
                <p class="lead">Here are the incredible organizations we've worked with in the past.</p>
            </div>
        </div>
        <div class="row">
            <?php
            // Fetch past partners from the database
            $queryPast = "SELECT * FROM partners WHERE section = 'past'";
            $resultPast = mysqli_query($conn, $queryPast);

            if (!$resultPast) {
                echo "<p class='text-danger'>Error: " . mysqli_error($conn) . "</p>";
            } elseif (mysqli_num_rows($resultPast) > 0) {
                while ($partner = mysqli_fetch_assoc($resultPast)) {
                    echo "
                    <div class='col-md-6 mb-4' data-aos='fade-up'>
                        <div class='card shadow-sm'>
                            <img class='card-img-top' src='" . htmlspecialchars($partner['image_url']) . "' alt='" . htmlspecialchars($partner['name']) . "' style='height: 200px; object-fit: cover;'>
                            <div class='card-body'>
                                <h5 class='card-title'>" . htmlspecialchars($partner['name']) . "</h5>
                                <p class='text-muted'>" . htmlspecialchars($partner['role']) . "</p>
                                <p class='card-text'>" . htmlspecialchars($partner['description']) . "</p>
                            </div>
                        </div>
                    </div>
                    ";
                }
            } else {
                echo "<p class='text-center'>No past partners found.</p>";
            }
            ?>
        </div>
    </div>
</section>
<?php
include 'footer.php';
?>
