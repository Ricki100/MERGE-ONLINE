<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Font Merge | Data Merge Online - Convert CSV or Excel to Custom Images</title>
    <meta name="description" content="Font Merge - The best data merge online tool. Upload a template, add CSV/Excel data, and generate customized images with text and image overlays. 100% web-based. No coding or software installation required.">
    <meta name="keywords" content="font merge, data merge, data merge online, image generator, CSV to image, Excel to image, certificate generator, bulk image creation">
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

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8rem 0 6rem;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 80%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            transform: rotate(15deg);
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .hero-badge i {
            margin-right: 0.5rem;
            color: #fbbf24;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            color: white;
        }

        .hero-section .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            font-weight: 400;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }



        .cta-button {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            color: var(--primary-color);
            padding: 1.25rem 3rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        .cta-button:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .cta-button i {
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }



        /* Quick Steps Section */
        .quick-steps {
            padding: 5rem 0;
            background: var(--light-bg);
        }

        .step-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            text-align: center;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .step-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .step-icon {
            width: 80px;
            height: 80px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }

        .step-number {
            background: var(--primary-color);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin: 0 auto 1rem;
        }

        /* Features Section */
        .features-section {
            padding: 5rem 0;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .feature-icon {
            background: var(--primary-color);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
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
            .hero-section {
                padding: 4rem 0 3rem;
            }
            
            .hero-section h1 {
                font-size: 2.2rem;
            }
            
            .hero-section .hero-subtitle {
                font-size: 1.1rem;
            }
        }

        /* Utility Classes */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-color), #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 4rem;
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
                        <a class="nav-link" href="/contact">Contact</a>
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fas fa-star"></i>
                    The #1 Data Merge Tool Online
                </div>
                
                <h1>Transform Data Into Stunning Visuals</h1>
                
                <p class="hero-subtitle">
                    Create certificates, product visuals, ID cards, and digital badges at scale with our powerful online data merge tool. 
                    Upload templates, import data, and generate hundreds of customized images instantly.
                </p>
                

                
                <a href="/app" class="cta-button">
                    <i class="fas fa-rocket"></i>
                    Start Creating Now
                </a>
                

            </div>
        </div>
    </section>

    <!-- Quick Steps Section -->
    <section class="quick-steps">
        <div class="container">
            <h2 class="section-title">Quick Steps</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-icon">
                            <i class="fas fa-upload"></i>
                        </div>
                        <div class="step-number">1</div>
                        <h4>Upload a Template Image</h4>
                        <p class="text-muted">Upload your PNG, JPG, or JPEG template as the base for your designs</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-icon">
                            <i class="fas fa-file-csv"></i>
                        </div>
                        <div class="step-number">2</div>
                        <h4>Upload Your CSV or Excel File</h4>
                        <p class="text-muted">Import your data with names, details, or any information you want to overlay</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="step-number">3</div>
                        <h4>Place Custom Text and Image Boxes</h4>
                        <p class="text-muted">Drag and drop text or image overlays exactly where you want them</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="step-number">4</div>
                        <h4>Preview All Images</h4>
                        <p class="text-muted">See how your designs will look with different data entries</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-icon">
                            <i class="fas fa-download"></i>
                        </div>
                        <div class="step-number">5</div>
                        <h4>Download All in a ZIP File</h4>
                        <p class="text-muted">Get all your customized images packaged and ready to use</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <div class="step-number">6</div>
                        <h4>Ready to Use</h4>
                        <p class="text-muted">Your professional images are ready for certificates, marketing, or any project</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Section -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title">Why Choose Font Merge?</h2>
            <div class="row">
                <div class="col-lg-6">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div>
                            <h5>100% Online</h5>
                            <p class="text-muted">No software to install or download. Everything runs in your browser.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-font"></i>
                        </div>
                        <div>
                            <h5>Professional Fonts</h5>
                            <p class="text-muted">Supports fonts like Arial, Times, Helvetica, and custom Google Fonts.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <h5>Privacy-Focused</h5>
                            <p class="text-muted">Files are automatically deleted after use. Your data stays secure.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h5>Perfect for Everyone</h5>
                            <p class="text-muted">Easy for educators, designers, marketers, and developers to use.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div>
                            <h5>Lightning Fast</h5>
                            <p class="text-muted">Generate hundreds of images in seconds with our optimized processing.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div>
                            <h5>Mobile Friendly</h5>
                            <p class="text-muted">Works perfectly on desktop, tablet, and mobile devices.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="/app" class="cta-button">
                    🎯 Try it now — Start Generating
                </a>
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
                        <li><a href="/app" class="try-now-btn">TRY NOW</a></li>
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