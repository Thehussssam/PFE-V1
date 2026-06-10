<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<?php
// db connection
require '../config/database.php';

// get jobs count per category
$sql = "SELECT categorie, COUNT(id_job) AS total FROM jobs GROUP BY categorie";
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// map results into array
$job_counts = [];
foreach ($results as $row) {
    $job_counts[$row['categorie']] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>JobConnect - Categories</title>

  <link rel="stylesheet" href="../assets/css/categorie.css">
</head>

<body>

<!-- hero section -->
<section class="hero">
  <span class="badge">Discover your next career move</span>

  <h1>Explore by Category</h1>

  <p>
    Browse through thousands of job opportunities organized by industry and specialization.
    Find the role that matches your expertise and passion.
  </p>
</section>

<!-- categories grid -->
<section class="grid">

  <div class="card">
    <i class="fa-solid fa-code"></i>
    <h3>Web Development</h3>
    <p>Build the future of the web with modern frameworks and cutting-edge tech.</p>
    <span><?php echo (int)($job_counts['Web Development'] ?? 0); ?> Jobs</span>
  </div>

  <div class="card">
    <i class="fa-solid fa-palette"></i>
    <h3>Design</h3>
    <p>Craft beautiful interfaces and seamless user experiences.</p>
    <span><?php echo (int)($job_counts['Design'] ?? 0); ?> Jobs</span>
  </div>

  <div class="card">
    <i class="fa-solid fa-shield-halved"></i>
    <h3>Cybersecurity</h3>
    <p>Protect critical data and systems from digital threats.</p>
    <span><?php echo (int)($job_counts['Cybersecurity'] ?? 0); ?> Jobs</span>
  </div>

  <div class="card">
    <i class="fa-solid fa-bullhorn"></i>
    <h3>Marketing</h3>
    <p>Drive growth through creative storytelling and data strategies.</p>
    <span><?php echo (int)($job_counts['Marketing'] ?? 0); ?> Jobs</span>
  </div>

  <div class="card">
    <i class="fa-solid fa-mobile-screen"></i>
    <h3>Mobile Development</h3>
    <p>Build apps for Android and iOS platforms.</p>
    <span><?php echo (int)($job_counts['Mobile Development'] ?? 0); ?> Jobs</span>
  </div>

  <div class="card">
    <i class="fa-solid fa-chart-line"></i>
    <h3>Data Science</h3>
    <p>Extract insights using advanced analytics models.</p>
    <span><?php echo (int)($job_counts['Data Science'] ?? 0); ?> Jobs</span>
  </div>

  <div class="card">
    <i class="fa-solid fa-globe"></i>
    <h3>Remote Jobs</h3>
    <p>Work from anywhere in the world.</p>
    <span><?php echo (int)($job_counts['Remote Jobs'] ?? 0); ?> Jobs</span>
  </div>

  <div class="card">
    <i class="fa-solid fa-rocket"></i>
    <h3>Product Management</h3>
    <p>Lead product teams and define roadmaps.</p>
    <span><?php echo (int)($job_counts['Product Management'] ?? 0); ?> Jobs</span>
  </div>

</section>

</body>
</html>

<?php include '../includes/footer.php'; ?>