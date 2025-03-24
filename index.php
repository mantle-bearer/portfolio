<?php
// Database connection
require 'db.php';

// Fetch data from the database
$query = $pdo->query("SELECT * FROM home LIMIT 1");
$home = $query->fetch(PDO::FETCH_ASSOC);

$query = $pdo->query("SELECT * FROM about_me LIMIT 1");
$about = $query->fetch(PDO::FETCH_ASSOC);

// Fetch skills from the database
$query = $pdo->query("SELECT * FROM skills_progress ORDER BY id ASC");
$skills = $query->fetchAll(PDO::FETCH_ASSOC);

// Group skills into sets of three for row display
$skills_chunk = array_chunk($skills, 3);

$query = $pdo->query("SELECT * FROM services");
$services = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $pdo->query("SELECT * FROM portfolio");
$projects = $query->fetchAll(PDO::FETCH_ASSOC);

// Fetch blog posts from the database
$query = $pdo->query("SELECT * FROM blog ORDER BY created_at DESC");
$blogs = $query->fetchAll(PDO::FETCH_ASSOC);

// Handle contact form submission
$response = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contact_form'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        $response = "All fields except subject are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = "Invalid email format.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':subject' => $subject,
                ':message' => $message
            ]);

            $response = "Your message has been sent successfully!";
        } catch (PDOException $e) {
            $response = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en"><script src="https://github.com/mantle-bearer/portfolio/blob/main/other_files/main.js"></script>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($home['title'] ?? 'Goodluck Igbokwe | Portfolio'); ?></title>

    <!-- Font Awesome CDN -->
    <script src="https://kit.fontawesome.com/baa502a757.js" crossorigin="anonymous"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./other_files/style.css">
</head>
<body class="active">
    
    <!-- Header Section -->
    <header class="header">
        <div class="user">
            <img src="<?php echo htmlspecialchars($home['user_image'] ?? './other_files/user-img.jpg'); ?>" alt="Profile Picture">
            <h3><?php echo htmlspecialchars($home['name'] ?? 'Goodluck Igbokwe'); ?></h3>
            <p><?php echo htmlspecialchars($home['role'] ?? 'FullStack Developer'); ?></p>
        </div>

        <nav class="navbar">
            <a href="#home">Home</a>
            <a href="#about">About</a>
            <a href="#services">Services</a>
            <a href="#portfolio">Portfolio</a>
            <a href="#blog">Blog</a>
            <a href="#contact">Contact</a>
        </nav>
    </header>

    <div id="menu-btn" class="fas fa-bars"></div>
    <div id="theme-toggler" class="fas fa-moon fa-sun"></div>

    <!-- Home Section -->
    <section class="home" id="home">
        <div class="content">
            <h3><?php echo htmlspecialchars($home['name'] ?? 'Goodluck Igbokwe'); ?></h3>
            <p><?php echo htmlspecialchars($home['subtitle'] ?? 'Junior Software Engineer'); ?></p>
            <a href="<?php echo htmlspecialchars($home['resume_url'] ?? './other_files/Goodluck-Igbokwe-Resume.pdf'); ?>" class="btn">Download CV</a>
        </div>
        <div class="share">
            <?php
            $socialQuery = $pdo->query("SELECT * FROM social_links");
            $social_links = $socialQuery->fetchAll(PDO::FETCH_ASSOC);
            foreach ($social_links as $link): ?>
                <a href="<?php echo htmlspecialchars($link['url']); ?>" class="<?php echo htmlspecialchars($link['icon']); ?>"></a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <h1 class="heading"> <span>About</span> Me </h1>
            <div class="row">
                <div class="box-container">
                    <div class="box">
                        <h3><?php echo nl2br(htmlspecialchars($about['experience_years'] ?? '0')); ?></h3>
                        <p>years of experience</p>
                    </div>
                    <div class="box">
                        <h3><?php echo nl2br(htmlspecialchars($about['clients_served'] ?? '0')); ?></h3>
                        <p>satisfied clients</p>
                    </div>
                    <div class="box">
                        <h3><?php echo nl2br(htmlspecialchars($about['working_hours'] ?? '0')); ?></h3>
                        <p>working hours</p>
                    </div>
                    <div class="box">
                        <h3><?php echo nl2br(htmlspecialchars($about['awards_won'] ?? '0')); ?></h3>
                        <p>awards won</p>
                    </div>

                </div>
            

                <div class="content">
                    <p><?php echo nl2br(htmlspecialchars($about['description'] ?? 'No description available.')); ?></p>
                    <a href="https://wa.link/p9709d" class="btn">contact me +<?php echo nl2br(htmlspecialchars(chunk_split($about['phone_number'], 3, ' ') ?? '234 703 229 8396')); ?></a>
                </div>
            </div>

            <div class="row">

                <?php foreach ($skills_chunk as $group): ?>
                    <div class="progress">
                        <?php foreach ($group as $skill): ?>
                            <h3><?php echo htmlspecialchars($skill['skill_name']); ?> 
                                <span><?php echo htmlspecialchars($skill['proficiency']); ?>%</span>
                            </h3>
                            <div class="bar <?php echo htmlspecialchars($skill['bar_class']); ?>"><span style="width:<?php echo $skill['proficiency']; ?>%"></span></div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

            </div>
    </section>
    
    <!-- Services Section -->
    <section class="services" id="services">
        <h1 class="heading"> My <span>Services</span> </h1>
        <div class="box-container">
            <?php foreach ($services as $service): ?>
                <div class="box">
                    <i class="<?php echo htmlspecialchars($service['icon'] ?? 'fas fa-cog'); ?>"></i>
                    <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    
    <!-- Portfolio Section -->
    <section class="portfolio" id="portfolio">
        <h1 class="heading"> Personal <span>Projects</span> </h1>
        <div class="box-container">
            <?php foreach ($projects as $project): ?>
                <div class="box">
                    <img src="<?php echo htmlspecialchars($project['project_image_url']); ?>" alt="Project">
                    <div class="content">
                        <h3><?php echo htmlspecialchars($project['project_name']); ?></h3>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <!-- Blog section starts -->
    <section class="portfolio" id="blog">
        <h1 class="heading"> Code <span>Chronicles</span> </h1>

        <div class="blog-box-container box-container">
            <?php foreach ($blogs as $blog): ?>
                <a href="<?php echo htmlspecialchars($blog['blog_link'] ?? '/blog'); ?>" target="_blank">
                    <div class="box">
                        <img src="<?php echo htmlspecialchars($blog['image_url'] ?? './other_files/img-0.jpg'); ?>" alt="Blog Image">
                        <div class="content">
                            <h3><?php echo htmlspecialchars($blog['title'] ?? 'Coming soon'); ?></h3>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
    <!-- Blog section ends -->

    
    <!-- Contact Section -->
    <section class="contact" id="contact">
        <h1 class="heading"> <span>Contact</span> Me </h1>

        <?php if (!empty($response)): ?>
            <p class="response-message"><?php echo htmlspecialchars($response); ?></p>
        <?php endif; ?>

        <form action="#contact" method="POST">
            <input type="hidden" name="contact_form" value="1">
            <input type="text" name="name" placeholder="Your Name" class="box" required>
            <input type="email" name="email" placeholder="Your Email" class="box" required>
            <input type="text" name="subject" placeholder="Subject (Optional)" class="box">
            <textarea name="message" class="box" placeholder="Your Message" required></textarea>
            <input type="submit" value="Send Message" class="btn">
        </form>
    </section>
    
    <div class="credits"> Created by <span><?php echo htmlspecialchars($home['name'] ?? 'Goodluck Igbokwe'); ?></span> | All rights reserved </div>
    
    <!-- Custom JS -->
    <script src="./other_files/main.js"></script>
</body>
</html>
