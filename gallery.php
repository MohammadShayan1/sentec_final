<?php
include 'header.php';
include 'db_connection.php'; // Replace with your DB connection file

// Get the selected group title for filtering
$selected_group = isset($_GET['group']) ? $_GET['group'] : '';

// Fetch distinct group titles for filtering
$groups_query = "SELECT DISTINCT group_title FROM gallery";
$groups_result = $conn->query($groups_query);

// Fetch gallery groups and their images
if ($selected_group) {
    $query = "SELECT * FROM gallery WHERE group_title = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $selected_group);
} else {
    $query = "SELECT * FROM gallery";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();

// Group data by title
$gallery_data = [];
while ($row = $result->fetch_assoc()) {
    $gallery_data[$row['group_title']]['description'] = $row['description'];
    $gallery_data[$row['group_title']]['main_image'] = str_replace('../', './', $row['main_image_url']);
    $additional_images = explode(',', $row['additional_image_url']);
$trimmed_images = array_map(function ($url) {
    return htmlspecialchars(str_replace('../', './', trim($url)));
}, $additional_images);

$gallery_data[$row['group_title']]['additional_images'] = $trimmed_images;
   
}
?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center text-center mb-2 mb-lg-4">
            <div class="col-12 col-lg-8 col-xxl-7 text-center mx-auto">
                <span class="text-muted">Showcase</span>
                <h2 class="display-5 fw-bold">Our Gallery</h2>
                <p class="lead">Browse our collection grouped by Events.</p>
            </div>
        </div>

        <!-- Filter -->
        <form method="GET" class="mb-4 text-center">
            <select name="group" class="form-select w-50 mx-auto" onchange="this.form.submit()">
                <option value="">All Events</option>
                <?php while ($group = $groups_result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($group['group_title']) ?>" <?= $selected_group == $group['group_title'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($group['group_title']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </form>

        <?php foreach ($gallery_data as $title => $data): ?>
            <div class="row py-3 align-items-center">
                <!-- Main Image and Description -->
                <div class="col-md-6 mt-md-0 mt-4">
    <div class="mb-5 mb-lg-3">
        <a href="<?= htmlspecialchars($data['main_image']) ?>" data-lightbox="<?= htmlspecialchars($title) ?>" data-title="<?= htmlspecialchars($data['description']) ?>">
            <img class="img-fluid" src="<?= htmlspecialchars($data['main_image']) ?>" alt="<?= htmlspecialchars($title) ?>">
        </a>
    </div>
</div>

                <div class="col-md-6 ps-md-5">
                    <div class="mb-5 mb-lg-3">
                        <h4><?= htmlspecialchars($title) ?></h4>
                        <p><?= htmlspecialchars($data['description']) ?></p>
                    </div>
                </div>
            </div>

            <!-- Additional Images -->
            <div class="row mt-2">
    <?php foreach ($data['additional_images'] as $image_url): ?>
        <div class="col-lg-3 col-md-6">
            <div class="mb-3 mb-lg-0">
                <a href="<?= htmlspecialchars($image_url) ?>" data-lightbox="<?= htmlspecialchars($title) ?>">
                    <img alt="" class="img-fluid" src="<?= htmlspecialchars($image_url) ?>">
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

        <?php endforeach; ?>
    </div>
</section>

<?php
include 'footer.php';
?>
