<?php include 'includes/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
        <?php include 'includes/head.php'; ?>
    </head>

<body>
    <?php include 'includes/sidebar.php'; ?>
    <div class="content">
        <?php include 'includes/topbar.php'; ?>
        <div>
            <h1>Welcome, <?= $_SESSION['name']; ?></h1>
            <p>This is your responsive dashboard with centralized components.</p>
        </div>
    </div>

   

    <?php include 'includes/footer.php'; ?>
</body>
</html>
