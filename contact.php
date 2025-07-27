<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Reach the Font Merge Support Team</title>
    <meta name="description" content="Have questions or suggestions? Contact the Font Merge team directly for help with data-driven image generation.">
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

        /* Contact Section */
        .contact-section {
            padding: 5rem 0;
        }

        .contact-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 3rem;
            margin-bottom: 2rem;
        }

        .contact-info {
            background: var(--light-bg);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .contact-details h4 {
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .contact-details p {
            margin-bottom: 0;
            color: var(--text-secondary);
        }

        .contact-details a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .contact-details a:hover {
            text-decoration: underline;
        }

        .response-time {
            background: var(--success-color);
            color: white;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            margin-top: 2rem;
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

        /* Standardized TRY NOW Button Style */
        .try-now-btn {
            background: #2563eb;
            color: white !important;
            border-radius: 8px;
            padding: 12px 24px;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            display: inline-block;
            text-align: center;
            transition: background-color 0.3s ease;
            box-shadow: none;
        }

        .try-now-btn:hover {
            background: #1d4ed8;
            color: white !important;
            text-decoration: none;
            transform: none;
            box-shadow: none;
        }

        .try-now-btn:active {
            background: #1e40af;
        }

        .navbar-nav .nav-link.btn {
            background: #2563eb;
            color: white !important;
            border-radius: 8px;
            padding: 12px 24px;
            margin-left: 1rem;
            transition: background-color 0.3s ease;
            font-weight: 700;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: none;
            border: none;
        }

        .navbar-nav .nav-link.btn:hover {
            background: #1d4ed8;
            transform: none;
            box-shadow: none;
            border: none;
        }

        .navbar-nav .nav-link.btn:active {
            background: #1e40af;
            transform: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2.5rem;
            }
            
            .contact-card {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="https://fontmerge.online/">
                <i class="fas fa-layer-group me-2"></i>Font Merge
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

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
                        <a class="nav-link active" href="/contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/privacy">Privacy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn try-now-btn" href="/app">TRY NOW</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Contact Us</h1>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-card">
                        <p class="lead text-center mb-4">
                            Need support or looking to partner with us? We'd love to hear from you.
                        </p>

                        <div class="contact-info">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-details">
                                    <h4>📧 Email</h4>
                                    <p><a href="mailto:support@datamerge.app">support@datamerge.app</a></p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="contact-details">
                                    <h4>🕒 Support Hours</h4>
                                    <p>Monday – Saturday | 8 AM – 8 PM</p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div class="contact-details">
                                    <h4>💼 Business Inquiries & Licensing</h4>
                                    <p><a href="mailto:business@datamerge.app">business@datamerge.app</a></p>
                                </div>
                            </div>

                            <div class="response-time">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>We aim to respond within 24 hours</strong>
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="/app" class="try-now-btn me-3">
                                TRY NOW
                            </a>
                            <a href="/services" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-info-circle me-2"></i>Learn More
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
                    <a href="/contact" class="btn btn-outline-light">Get in Touch</a>
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