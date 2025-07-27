<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services | Generate Custom Images from Data with Font Merge</title>
    <meta name="description" content="Discover what you can create with Font Merge — from certificates and ID cards to banners and branded visuals using your spreadsheet data.">
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

        /* Services Section */
        .services-section {
            padding: 5rem 0;
        }

        .service-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 2.5rem;
            margin-bottom: 2rem;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-color);
            color: white;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 2rem;
        }

        .service-card h3 {
            color: var(--text-primary);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .service-card p {
            color: var(--text-secondary);
            line-height: 1.7;
        }

        .use-cases-section {
            background: var(--light-bg);
            padding: 5rem 0;
        }

        .use-case-item {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary-color);
        }

        .use-case-item h4 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .use-case-item p {
            color: var(--text-secondary);
            margin-bottom: 0;
        }

        .white-label-section {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white;
            padding: 5rem 0;
        }

        .white-label-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 3rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .white-label-card h3 {
            color: white;
            margin-bottom: 1.5rem;
        }

        .white-label-card p {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.7;
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
            
            .service-card {
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
                        <a class="nav-link active" href="/services">Services</a>
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
                        <a class="nav-link" href="/privacy">Privacy</a>
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
            <h1>What You Can Do With Font Merge</h1>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section">
        <div class="container">
            <h2 class="text-center mb-5">Services & Use Cases</h2>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h3>🔹 Certificate & Award Generator</h3>
                        <p>Upload your template and a name list to instantly create branded, ready-to-print certificates.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3>🔹 Product Catalog Image Creation</h3>
                        <p>Generate e-commerce visuals, promo images, and banners using pricing and SKU data from Excel or CSV.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <h3>🔹 Student Report Cards & ID Badges</h3>
                        <p>Ideal for schools, colleges, and training centers needing to process high volumes of records.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <h3>🔹 Event Passes & Invitations</h3>
                        <p>Make QR-coded tickets, digital invites, or personalized thank-you cards with logos and dynamic names.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Use Cases Section -->
    <section class="use-cases-section">
        <div class="container">
            <h2 class="text-center mb-5">Perfect For These Industries</h2>
            <div class="row">
                <div class="col-lg-6">
                    <div class="use-case-item">
                        <h4><i class="fas fa-graduation-cap me-2"></i>Education</h4>
                        <p>Create certificates, student IDs, report cards, and graduation materials for schools and universities.</p>
                    </div>
                    <div class="use-case-item">
                        <h4><i class="fas fa-store me-2"></i>E-commerce</h4>
                        <p>Generate product images, promotional banners, and marketing materials with dynamic pricing and details.</p>
                    </div>
                    <div class="use-case-item">
                        <h4><i class="fas fa-calendar-alt me-2"></i>Events</h4>
                        <p>Create personalized event tickets, invitations, and attendee badges with QR codes and custom information.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="use-case-item">
                        <h4><i class="fas fa-building me-2"></i>Business</h4>
                        <p>Generate employee IDs, business cards, and corporate materials with company branding and personal details.</p>
                    </div>
                    <div class="use-case-item">
                        <h4><i class="fas fa-palette me-2"></i>Marketing</h4>
                        <p>Create personalized marketing materials, social media graphics, and promotional content at scale.</p>
                    </div>
                    <div class="use-case-item">
                        <h4><i class="fas fa-users me-2"></i>Organizations</h4>
                        <p>Generate membership cards, volunteer badges, and organizational materials for clubs and associations.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- White Label Section -->
    <section class="white-label-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="white-label-card text-center">
                        <h3>🔹 White-Label Automation</h3>
                        <p>Need something custom? We offer white-label image generation portals for agencies and organizations. Get your own branded version of Font Merge with custom features and integrations.</p>
                        <a href="/contact" class="btn btn-light btn-lg mt-3">
                            <i class="fas fa-envelope me-2"></i>Contact Us for Custom Solutions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="mb-4">Ready to Start Creating?</h2>
            <p class="lead mb-4">Join thousands of users who are already saving time with Font Merge</p>
            <a href="/app" class="btn btn-primary btn-lg">
                <i class="fas fa-rocket me-2"></i>Start Generating Images Now
            </a>
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