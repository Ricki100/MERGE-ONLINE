<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy | Font Merge Web App</title>
    <meta name="description" content="Review our privacy policy and how your uploaded files and session data are handled securely by the Font Merge platform.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #64748b;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background-color: #ffffff;
        }

        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: var(--text-primary) !important;
            margin: 0 0.5rem;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
        }

        .page-header h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        /* Content Section */
        .content-section {
            padding: 5rem 0;
        }

        .content-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 3rem;
            margin-bottom: 2rem;
        }

        .content-card h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .content-card p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }

        .policy-item {
            background: var(--light-bg);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary-color);
        }

        .policy-item h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .policy-item p {
            color: var(--text-secondary);
            margin-bottom: 0;
        }

        .contact-info {
            background: var(--success-color);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            margin-top: 2rem;
        }

        .contact-info h3 {
            color: white;
            margin-bottom: 1rem;
        }

        .contact-info a {
            color: white;
            text-decoration: underline;
        }

        .contact-info a:hover {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Footer */
        .footer {
            background: var(--text-primary);
            color: white;
            padding: 3rem 0 1rem;
        }

        .footer h5 {
            color: white;
            margin-bottom: 1rem;
        }

        .footer a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid #374151;
            padding-top: 1rem;
            margin-top: 2rem;
            text-align: center;
            color: #9ca3af;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2.5rem;
            }
            
            .content-card {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-layer-group me-2"></i>Font Merge
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://fontmerge.online/blog/">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/privacy">Privacy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white px-3 ms-2" href="/app">Try Now</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Privacy Policy</h1>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="content-card">
                        <p class="lead">
                            At Font Merge, your privacy and data security are critical.
                        </p>

                        <div class="policy-item">
                            <h3><i class="fas fa-clock me-2"></i>1. Temporary File Handling</h3>
                            <p>Uploaded files (images and Excel/CSV data) are stored in isolated folders and deleted automatically after 24 hours.</p>
                        </div>

                        <div class="policy-item">
                            <h3><i class="fas fa-database me-2"></i>2. Minimal Data Storage</h3>
                            <p>We don't collect or retain user-identifying information unless explicitly provided by the user for support or contact.</p>
                        </div>

                        <div class="policy-item">
                            <h3><i class="fas fa-shield-alt me-2"></i>3. No Third-Party Trackers</h3>
                            <p>No cookies, analytics, or advertising trackers are embedded on the image generation interface.</p>
                        </div>

                        <div class="policy-item">
                            <h3><i class="fas fa-lock me-2"></i>4. Secure Sessions</h3>
                            <p>Your sessions are stored temporarily for preview generation and are cleared after downloads are completed.</p>
                        </div>

                        <div class="policy-item">
                            <h3><i class="fas fa-question-circle me-2"></i>5. Questions & Compliance</h3>
                            <p>Email us at privacy@datamerge.app for any questions or data removal requests.</p>
                        </div>

                        <div class="contact-info">
                            <h3><i class="fas fa-envelope me-2"></i>Questions About Privacy?</h3>
                            <p>We're committed to transparency and protecting your data. If you have any questions about our privacy practices, please don't hesitate to reach out.</p>
                            <a href="mailto:privacy@datamerge.app">privacy@datamerge.app</a>
                        </div>

                        <div class="text-center mt-4">
                                            <a href="/app" class="btn btn-primary btn-lg">
                    <i class="fas fa-rocket me-2"></i>Start Using Font Merge
                </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5><i class="fas fa-layer-group me-2"></i>Font Merge</h5>
                    <p class="text-muted">
                        Transform your data into stunning images instantly. 
                        No coding required, no software to install.
                    </p>
                </div>
                <div class="col-lg-2 mb-4">
                    <h5>Product</h5>
                    <ul class="list-unstyled">
                        <li><a href="/services">Services</a></li>
                        <li><a href="/app">Try Now</a></li>
                        <li><a href="/about">About</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 mb-4">
                    <h5>Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="/contact">Contact</a></li>
                        <li><a href="/privacy">Privacy</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Connect</h5>
                    <p class="text-muted">
                        Have questions? We're here to help you create amazing images from your data.
                    </p>
                    <a href="contact.php" class="btn btn-outline-light">Get in Touch</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Font Merge. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 