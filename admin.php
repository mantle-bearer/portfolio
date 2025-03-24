<?php
session_start();
require 'db.php';

// Redirect to login page if not logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit;
}

// Handle CRUD Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Update Home Section
    if ($action === 'update_home') {
        $stmt = $pdo->prepare("UPDATE home SET title = ?, subtitle = ?, resume_url = ?, linkedin_url = ?, github_url = ?, whatsapp_url = ?, email = ? WHERE id = 1");
        $stmt->execute([$_POST['title'], $_POST['subtitle'], $_POST['resume_url'], $_POST['linkedin_url'], $_POST['github_url'], $_POST['whatsapp_url'], $_POST['email']]);
    }

    // Update About Me Section
    if ($action === 'update_about') {
        $stmt = $pdo->prepare("UPDATE about_me SET description = ?, experience_years = ?, clients_served = ?, projects_completed = ?, awards_won = ? WHERE id = 1");
        $stmt->execute([$_POST['description'], $_POST['experience_years'], $_POST['clients_served'], $_POST['projects_completed'], $_POST['awards_won']]);
    }

    // Add, Edit, Delete Services
    if ($action === 'delete_service') {
        $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
        $stmt->execute([$_POST['id']]);
    }
    if ($action === 'add_service') {
        $stmt = $pdo->prepare("INSERT INTO services (name, description) VALUES (?, ?)");
        $stmt->execute([$_POST['name'], $_POST['description']]);
    }

    // Add, Edit, Delete Portfolio
    if ($action === 'delete_portfolio') {
        $stmt = $pdo->prepare("DELETE FROM portfolio WHERE id = ?");
        $stmt->execute([$_POST['id']]);
    }
    if ($action === 'add_portfolio') {
        $stmt = $pdo->prepare("INSERT INTO portfolio (project_name, project_image_url, project_link) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['project_name'], $_POST['project_image_url'], $_POST['project_link']]);
    }

    // Add, Edit, Delete Blog Posts
    if ($action === 'delete_blog') {
        $stmt = $pdo->prepare("DELETE FROM blog WHERE id = ?");
        $stmt->execute([$_POST['id']]);
    }
    if ($action === 'add_blog') {
        $stmt = $pdo->prepare("INSERT INTO blog (title, content, image_url, blog_link) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['title'], $_POST['content'], $_POST['image_url'], $_POST['blog_link']]);
    }

    // Delete Contact Messages
    if ($action === 'delete_message') {
        $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
        $stmt->execute([$_POST['id']]);
    }

    header('Location: admin.php');
    exit();
}

// Fetch data from database
$home = $pdo->query("SELECT * FROM home LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$about = $pdo->query("SELECT * FROM about_me LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$services = $pdo->query("SELECT * FROM services")->fetchAll(PDO::FETCH_ASSOC);
$portfolio = $pdo->query("SELECT * FROM portfolio")->fetchAll(PDO::FETCH_ASSOC);
$blogs = $pdo->query("SELECT * FROM blog ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
$messages = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 900px; margin: auto; background: white; padding: 20px; border-radius: 5px; }
        h2 { text-align: center; }
        form { margin-bottom: 20px; }
        label { display: block; margin-top: 10px; }
        input, textarea { width: 100%; padding: 8px; margin-top: 5px; }
        button { background: blue; color: white; padding: 10px; border: none; cursor: pointer; }
        .delete-btn { background: red; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background: #f4f4f4; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <a href="logout.php">Logout</a>

        <h3>Edit Home Section</h3>
        <form method="post">
            <input type="hidden" name="action" value="update_home">
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($home['title']); ?>">
            <label>Subtitle:</label>
            <input type="text" name="subtitle" value="<?php echo htmlspecialchars($home['subtitle']); ?>">
            <button type="submit">Update Home</button>
        </form>

        <h3>Manage Portfolio</h3>
        <table class="table">
            <tr><th>Project Name</th><th>Image</th><th>Action</th></tr>
            <?php foreach ($portfolio as $project): ?>
                <tr>
                    <td><?php echo htmlspecialchars($project['project_name']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($project['project_image_url']); ?>" width="50"></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="action" value="delete_portfolio">
                            <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h3>Add Portfolio Project</h3>
        <form method="post">
            <input type="hidden" name="action" value="add_portfolio">
            <label>Project Name:</label>
            <input type="text" name="project_name">
            <label>Image URL:</label>
            <input type="text" name="project_image_url">
            <label>Project Link:</label>
            <input type="text" name="project_link">
            <button type="submit">Add Project</button>
        </form>

        <h3>View Messages</h3>
        <table class="table">
            <tr><th>Name</th><th>Email</th><th>Message</th><th>Action</th></tr>
            <?php foreach ($messages as $message): ?>
                <tr>
                    <td><?php echo htmlspecialchars($message['name']); ?></td>
                    <td><?php echo htmlspecialchars($message['email']); ?></td>
                    <td><?php echo htmlspecialchars($message['message']); ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="action" value="delete_message">
                            <input type="hidden" name="id" value="<?php echo $message['id']; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
