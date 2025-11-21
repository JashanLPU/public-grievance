<?php
session_start();

$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$username = $is_logged_in ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - CivicPulse</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="about.css">
</head>
<body>

    <header class="main-header">
        <div class="header-content">
            <a href="home.php" class="logo-link"><h1 class="logo">CivicPulse</h1></a>
            <nav class="main-nav">
                <a href="home.php">Home</a>
                <a href="about.php" class="active">About Us</a>
                <a href="grievances.php">Live Grievances</a>
                <a href="archive.php">Resolved Grievances</a>
                <a href="contact.php">Contact</a>
            </nav>
            <div class="user-actions">
                <?php if ($is_logged_in): ?>
                    <span class="welcome-user">Welcome, <?php echo htmlspecialchars($username); ?>!</span>
                    <a href="index.html" class="logout-btn-header">Logout</a>
                <?php else: ?>
                    <a href="index.html" class="login-btn">Login / Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="about-main">
        <section class="page-title-section">
            <div class="page-title-content">
                <h2>Our Mission: A More Responsive City</h2>
                <p>CivicPulse was born from a simple idea: every citizen's voice matters. We believe that technology, when applied correctly, can bridge the gap between residents and city officials, creating a more transparent, efficient, and collaborative community.</p>
            </div>
        </section>

        <section class="commitment-section">
            <h3 class="section-title">Our Commitment to You</h3>
            <div class="steps-container">
                <div class="step-card animate-on-scroll">
                    <div class="step-icon"><i class="fa-solid fa-scale-balanced"></i></div>
                    <h4>Fairness</h4>
                    <p>Every report is handled in the order it's received. There's no skipping the line. Your voice is logged and addressed with the fairness it deserves.</p>
                </div>
                <div class="step-card animate-on-scroll delay-1">
                    <div class="step-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <h4>Priority</h4>
                    <p>Our intelligent system automatically identifies the most critical issues. Urgent problems get the immediate attention they need, ensuring safety and well-being.</p>
                </div>
                <div class="step-card animate-on-scroll delay-2">
                    <div class="step-icon"><i class="fa-solid fa-eye"></i></div>
                    <h4>Transparency</h4>
                    <p>You can track the progress of any grievance, from submission to resolution. We provide a clear and open record of all actions taken by city officials.</p>
                </div>
            </div>
        </section>

        <section class="story-section">
            <div class="story-container">
                <div class="story-image animate-on-scroll">
                    <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=2070&auto=format&fit=crop" alt="Team working together">
                </div>
                <div class="story-content animate-on-scroll delay-1">
                    <h3 class="section-title-alt">Our Story</h3>
                    <p>CivicPulse started as a competition project with a bold goal: to empower citizens and improve civic engagement through technology. We saw a need for a platform that was not only functional but also fair and transparent.</p>
                    <p>Built on a foundation of robust data structures and user-centric design, our platform is more than just a tool—it's a commitment to our community. We are dedicated to continuous improvement and to fostering a stronger connection between the people and the administration that serves them.</p>
                </div>
            </div>
        </section>

        <section class="team-section">
            <h3 class="section-title">Meet the Team</h3>
            <div class="team-container">
                <div class="team-member-card animate-on-scroll">
                    <img src="https://placehold.co/400x400/7c3aed/ffffff?text=JS" alt="Jashandeep Singh">
                    <h4>Jashandeep Singh</h4>
                    <p>Project Lead & Backend Developer</p>
                    <p class="description">Managed the project, designed the database, and built the entire backend functionality with PHP and MySQL.</p>
                </div>
                
                <div class="team-member-card animate-on-scroll delay-1">
                    <img src="https://placehold.co/400x400/27272a/ffffff?text=J" alt="Jaspreet">
                    <h4>Jaspreet</h4>
                    <p>Frontend Developer</p>
                    <p class="description">Crafted the user interface and site responsiveness using HTML, CSS, and JavaScript.</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="main-footer">
        <p>&copy; 2025 CivicPulse. A project for our community. All rights reserved.</p>
        <div class="footer-links">
            <a href="about.php">About Us</a> | 
            <a href="contact.php">Contact</a> | 
            <a href="#">Privacy Policy</a>
        </div>
    </footer>
    
    <div id="chatbot-container">
        <button id="chatbot-toggle-btn" class="chatbot-btn">
            <i class="fa-solid fa-headset icon-closed"></i>
            <i class="fa-solid fa-times icon-open"></i>
        </button>
        <div id="chatbot-window" class="chatbot-window">
            <div class="chatbot-header">
                <h3>CivicPulse AI Assistant</h3>
                <p>Ask me anything about our platform!</p>
            </div>
            <div id="chatbot-messages" class="chatbot-messages">
                <div class="chat-message bot-message">
                    <p>Hello! How can I help you today?</p>
                </div>
            </div>
            <div class="chatbot-input-form">
                <input type="text" id="chatbot-input" placeholder="Type your question...">
                <button id="chatbot-send-btn">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <script src="about.js"></script>

</body>
</html>