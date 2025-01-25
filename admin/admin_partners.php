<?php
include 'db_connection.php';
include 'header.php';

// Handle delete request
if (isset($_GET['delete'])) {
    $idToDelete = intval($_GET['delete']);
    $deleteQuery = "DELETE FROM partners WHERE id = $idToDelete";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>alert('Partner deleted successfully!');</script>";
        echo "<script>window.location.href='admin_partners.php';</script>";
    } else {
        echo "<p class='text-danger'>Error deleting partner: " . mysqli_error($conn) . "</p>";
    }
}

// Handle edit form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $editId = intval($_POST['edit_id']);
    $editName = mysqli_real_escape_string($conn, $_POST['name']);
    $editRole = mysqli_real_escape_string($conn, $_POST['role']);
    $editDescription = mysqli_real_escape_string($conn, $_POST['description']);
    $editImageUrl = mysqli_real_escape_string($conn, $_POST['image_url']);
    $editSection = mysqli_real_escape_string($conn, $_POST['section']);

    $updateQuery = "UPDATE partners SET 
                    name = '$editName', 
                    role = '$editRole', 
                    description = '$editDescription', 
                    image_url = '$editImageUrl', 
                    section = '$editSection' 
                    WHERE id = $editId";
    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Partner updated successfully!');</script>";
        echo "<script>window.location.href='admin_partners.php';</script>";
    } else {
        echo "<p class='text-danger'>Error updating partner: " . mysqli_error($conn) . "</p>";
    }
}
?>

<section class="py-5">
    <div class="container">
        <!-- Current Partners Section -->
        <div class="row justify-content-center text-center mb-2 mb-lg-4">
            <div class="col-12 col-lg-8 col-xxl-7 text-center mx-auto">
                <span class="text-muted">Current</span>
                <h2 class="display-5 fw-bold">Our Current Partners</h2>
                <p class="lead">Meet the amazing organizations we are currently collaborating with.</p>
            </div>
        </div>
        <div class="row">
            <?php
            $queryCurrent = "SELECT * FROM partners WHERE section = 'current'";
            $resultCurrent = mysqli_query($conn, $queryCurrent);

            if (mysqli_num_rows($resultCurrent) > 0) {
                while ($partner = mysqli_fetch_assoc($resultCurrent)) {
                    echo "
                    <div class='col-md-6 mb-4'>
                        <div class='card shadow-sm'>
                            <img class='card-img-top' src='" . htmlspecialchars($partner['image_url']) . "' alt='" . htmlspecialchars($partner['name']) . "' style='height: 200px; object-fit: cover;'>
                            <div class='card-body'>
                                <h5 class='card-title'>" . htmlspecialchars($partner['name']) . "</h5>
                                <p class='text-muted'>" . htmlspecialchars($partner['role']) . "</p>
                                <p class='card-text'>" . htmlspecialchars($partner['description']) . "</p>
                                <a href='?delete=" . $partner['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this partner?\")'>Delete</a>
                                <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $partner['id'] . "'>Edit</button>
                            </div>
                        </div>
                    </div>
                    ";

                    // Edit Modal
                    echo "
                    <div class='modal fade' id='editModal" . $partner['id'] . "' tabindex='-1' aria-labelledby='editModalLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='editModalLabel'>Edit Partner</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>
                                <form method='POST'>
                                    <div class='modal-body'>
                                        <input type='hidden' name='edit_id' value='" . $partner['id'] . "'>
                                        <div class='mb-3'>
                                            <label for='name' class='form-label'>Name</label>
                                            <input type='text' class='form-control' name='name' value='" . htmlspecialchars($partner['name']) . "' required>
                                        </div>
                                        <div class='mb-3'>
                                            <label for='role' class='form-label'>Role</label>
                                            <input type='text' class='form-control' name='role' value='" . htmlspecialchars($partner['role']) . "' required>
                                        </div>
                                        <div class='mb-3'>
                                            <label for='description' class='form-label'>Description</label>
                                            <textarea class='form-control' name='description' required>" . htmlspecialchars($partner['description']) . "</textarea>
                                        </div>
                                        <div class='mb-3'>
                                            <label for='image_url' class='form-label'>Image URL</label>
                                            <input type='text' class='form-control' name='image_url' value='" . htmlspecialchars($partner['image_url']) . "' required>
                                        </div>
                                        <div class='mb-3'>
                                            <label for='section' class='form-label'>Section</label>
                                            <select class='form-select' name='section' required>
                                                <option value='current' " . ($partner['section'] == 'current' ? 'selected' : '') . ">Current</option>
                                                <option value='past' " . ($partner['section'] == 'past' ? 'selected' : '') . ">Past</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                        <button type='submit' class='btn btn-primary'>Save Changes</button>
                                    </div>
                                </form>
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
            <div class="col-12 col-lg-8 col-xxl-7 text-center mx-auto">
                <span class="text-muted">Past</span>
                <h2 class="display-5 fw-bold">Our Past Partners</h2>
                <p class="lead">Here are the incredible organizations we've worked with in the past.</p>
            </div>
        </div>
        <div class="row">
            <?php
            $queryPast = "SELECT * FROM partners WHERE section = 'past'";
            $resultPast = mysqli_query($conn, $queryPast);

            if (mysqli_num_rows($resultPast) > 0) {
                while ($partner = mysqli_fetch_assoc($resultPast)) {
                    echo "
                    <div class='col-md-6 mb-4'>
                        <div class='card shadow-sm'>
                            <img class='card-img-top' src='" . htmlspecialchars($partner['image_url']) . "' alt='" . htmlspecialchars($partner['name']) . "' style='height: 200px; object-fit: cover;'>
                            <div class='card-body'>
                                <h5 class='card-title'>" . htmlspecialchars($partner['name']) . "</h5>
                                <p class='text-muted'>" . htmlspecialchars($partner['role']) . "</p>
                                <p class='card-text'>" . htmlspecialchars($partner['description']) . "</p>
                                <a href='?delete=" . $partner['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this partner?\")'>Delete</a>
                                <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editModal" . $partner['id'] . "'>Edit</button>
                            </div>
                        </div>
                    </div>
                    ";

                    // Edit Modal for Past Partners
                    echo "
                    <div class='modal fade' id='editModal" . $partner['id'] . "' tabindex='-1' aria-labelledby='editModalLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='editModalLabel'>Edit Partner</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>
                                <form method='POST'>
                                    <div class='modal-body'>
                                        <input type='hidden' name='edit_id' value='" . $partner['id'] . "'>
                                        <div class='mb-3'>
                                            <label for='name' class='form-label'>Name</label>
                                            <input type='text' class='form-control' name='name' value='" . htmlspecialchars($partner['name']) . "' required>
                                        </div>
                                        <div class='mb-3'>
                                            <label for='role' class='form-label'>Role</label>
                                            <input type='text' class='form-control' name='role' value='" . htmlspecialchars($partner['role']) . "' required>
                                        </div>
                                        <div class='mb-3'>
                                            <label for='description' class='form-label'>Description</label>
                                            <textarea class='form-control' name='description' required>" . htmlspecialchars($partner['description']) . "</textarea>
                                        </div>
                                        <div class='mb-3'>
                                            <label for='image_url' class='form-label'>Image URL</label>
                                            <input type='text' class='form-control' name='image_url' value='" . htmlspecialchars($partner['image_url']) . "' required>
                                        </div>
                                        <div class='mb-3'>
                                            <label for='section' class='form-label'>Section</label>
                                            <select class='form-select' name='section' required>
                                                <option value='current' " . ($partner['section'] == 'current' ? 'selected' : '') . ">Current</option>
                                                <option value='past' " . ($partner['section'] == 'past' ? 'selected' : '') . ">Past</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                        <button type='submit' class='btn btn-primary'>Save Changes</button>
                                    </div>
                                </form>
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
