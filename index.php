<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Merge Online - Free CSV to PDF Generator | Bulk Document Creation Tool</title>
    <meta name="description" content="Free online data merge tool for CSV to PDF conversion. Create professional documents, certificates, and bulk PDFs with custom fonts. No software download required - works in your browser.">
    <meta name="keywords" content="data merge, data merge online, CSV to PDF, bulk PDF generation, mail merge, document automation, PDF generator, CSV converter, merge data, PDF template, certificate generator, font customization, document processing, online data merge tool, free data merge, bulk document creation, CSV data merge, PDF merge tool, document generator, template merge, data merge software, online PDF generator, CSV merge, document automation tool, bulk PDF creator, mail merge online, data merge free, PDF template generator, certificate generator online, document merge tool, CSV to PDF converter, bulk document processing, online document generator, data merge tool free, PDF merge online, document creation tool, template generator, bulk PDF merge, online mail merge, data merge software free, CSV merge tool, document automation software, PDF generator online, bulk document generator, mail merge tool, data merge application, online document merge, CSV data merge tool, PDF creation tool, document merge software, bulk PDF generator online, mail merge software, data merge tool online, CSV to PDF merge, document generator online, template merge tool, data merge free online, PDF merge software, document creation software, bulk document merge, online PDF merge, data merge tool software, CSV merge software, document automation tool online, PDF generator software, bulk document creation tool, mail merge application, data merge online tool, CSV data merge software, PDF merge application, document merge application, bulk PDF creation, online document creation, data merge tool application, CSV merge application, document automation application, PDF generator application, bulk document application, mail merge application online, data merge application online, CSV data merge application, PDF merge application online, document merge application online, bulk PDF application, online document application, data merge application software, CSV merge application software, document automation application software, PDF generator application software, bulk document application software, mail merge application software, data merge application software online, CSV data merge application software, PDF merge application software online, document merge application software online, bulk PDF application software, online document application software">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="googlebot" content="index, follow">
    <meta name="author" content="Data Merge Online">
    <meta name="publisher" content="Data Merge Online">
    <meta name="copyright" content="Data Merge Online">
    <meta name="language" content="en">
    <meta name="revisit-after" content="7 days">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">
    <meta name="geo.region" content="US">
    <meta name="geo.placename" content="United States">
    <meta name="geo.position" content="39.50;-98.35">
    <meta name="ICBM" content="39.50, -98.35">
    <link rel="canonical" href="https://datamerge.online/">
    <meta property="og:title" content="Data Merge Online - Free CSV to PDF Generator | Bulk Document Creation">
    <meta property="og:description" content="Free online data merge tool for CSV to PDF conversion. Create professional documents, certificates, and bulk PDFs with custom fonts. No software download required.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://datamerge.online/">
    <meta property="og:image" content="https://datamerge.online/og-image.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Data Merge Online">
    <meta property="og:locale" content="en_US">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Data Merge Online - Free CSV to PDF Generator">
    <meta name="twitter:description" content="Free online data merge tool for CSV to PDF conversion. Create professional documents with custom fonts.">
    <meta name="twitter:image" content="https://datamerge.online/og-image.jpg">
    <meta name="twitter:site" content="@datamergeonline">
    <meta name="twitter:creator" content="@datamergeonline">
    <link rel="alternate" hreflang="en" href="https://datamerge.online/">
    <link rel="alternate" hreflang="x-default" href="https://datamerge.online/">
    <meta name="theme-color" content="#667eea">
    <meta name="msapplication-TileColor" content="#667eea">
    <meta name="msapplication-config" content="/browserconfig.xml">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "Data Merge Online",
        "description": "Free online data merge tool for CSV to PDF conversion. Create professional documents, certificates, and bulk PDFs with custom fonts.",
        "url": "https://datamerge.online/",
        "applicationCategory": "BusinessApplication",
        "operatingSystem": "Any",
        "browserRequirements": "Requires JavaScript. Requires HTML5.",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "USD"
        },
        "creator": {
            "@type": "Organization",
            "name": "Data Merge Online",
            "url": "https://datamerge.online/"
        },
        "featureList": [
            "CSV to PDF conversion",
            "Bulk document generation",
            "Custom font support",
            "Drag and drop interface",
            "Certificate generation",
            "Template customization",
            "High-resolution PDF output",
            "A4 size standardization",
            "Mobile responsive design"
        ],
        "screenshot": "https://datamerge.online/screenshot.jpg",
        "softwareVersion": "1.0",
        "datePublished": "2024-01-01",
        "dateModified": "2024-01-01"
    }
    </script>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🔤</text></svg>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.4.1/papaparse.min.js"></script>
    <script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" id="jszip-cdn"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            height: 100vh;
            overflow: hidden;
            padding: 20px;
        }

        /* Landing Page Styles */
        .landing-page {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: 10000;
            overflow-y: auto;
            display: none;
        }

        .landing-page.show {
            display: block;
        }

        .landing-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .landing-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10001;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .landing-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        .landing-logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: #667eea;
            text-decoration: none;
        }

        .landing-nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .landing-nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .landing-nav-links a:hover {
            color: #667eea;
        }

        .landing-cta-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s ease;
        }

        .landing-cta-button:hover {
            transform: translateY(-2px);
            color: white;
        }

        .landing-hero {
            padding: 120px 0 80px;
            text-align: center;
            color: white;
        }

        .landing-hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .landing-hero p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .landing-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 4rem 0;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 16px;
            text-align: center;
            color: white;
        }

        .feature-card i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ffd700;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .feature-card p {
            opacity: 0.9;
        }

        .landing-cta {
            text-align: center;
            margin: 4rem 0;
        }

        .landing-cta .btn-primary {
            background: white;
            color: #667eea;
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1rem;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .landing-cta .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
            color: #667eea;
        }

        /* Main App Styles */
        .main-container {
            display: none;
            height: calc(100vh - 40px);
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            overflow: hidden;
            flex-direction: row;
        }

        .main-container.show {
            display: flex;
        }

        .sidebar {
            width: 320px;
            background: #f8fafc;
            padding: 16px 12px;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            gap: 12px;
            overflow-y: auto;
            max-height: 100vh;
        }
        
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 2px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        .sidebar .small, .sidebar .text-muted {
            font-size: 0.75rem;
            line-height: 1.2;
        }
        
        .sidebar .form-label {
            font-size: 0.85rem;
            margin-bottom: 2px;
        }
        
        /* Tooltip styles */
        .tooltip-icon {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        
        .tooltip-icon .tooltip-text {
            visibility: hidden;
            width: 120px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 4px 8px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.75rem;
        }
        
        .tooltip-icon .tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #333 transparent transparent transparent;
        }
        
        .tooltip-icon:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
        
        /* Icon button styles */
        .icon-btn {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 6px 8px;
            margin: 2px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
        }
        
        .icon-btn:hover {
            background: #e9ecef;
            border-color: #adb5bd;
        }
        
        .icon-btn.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        
        .icon-btn i {
            font-size: 0.9rem;
        }
        
        /* Mobile touch optimizations */
        @media (max-width: 900px) {
            .draggable-box {
                min-width: 60px;
                min-height: 40px;
                font-size: 1.2rem;
                padding: 8px;
            }
            
            /* Larger touch targets for mobile */
            .sidebar .btn {
                min-height: 44px;
                touch-action: manipulation;
            }
            
            .form-control, .form-select {
                min-height: 44px;
                touch-action: manipulation;
            }
            
            .icon-btn {
                min-height: 44px;
                touch-action: manipulation;
            }
            
            /* Better spacing for mobile */
            .sidebar {
                gap: 8px;
            }
            
            .mb-2 {
                margin-bottom: 8px !important;
            }
        }
        .sidebar h2 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .sidebar label {
            font-weight: 500;
            margin-bottom: 3px;
            font-size: 0.9rem;
        }
        .sidebar .form-control, .sidebar .form-select {
            margin-bottom: 8px;
            padding: 6px 8px;
            font-size: 0.9rem;
        }
        .sidebar .btn {
            width: 100%;
            margin-bottom: 6px;
            padding: 6px 12px;
            font-size: 0.9rem;
        }
        .template-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 48px 32px;
            min-width: 0;
        }
        .template-preview-box {
            background: #f3f4f6;
            width: 100%;
            max-width: 900px;
            min-height: 650px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
            overflow: hidden;
            position: relative;
        }
        
        /* PDF-specific styling to prevent grey areas */
        .template-preview-box:has(.pdf-preview) {
            background: transparent;
            padding: 0;
            margin: 0;
            border: none;
            border-radius: 0;
            max-width: none;
            min-height: auto;
            display: block;
            align-items: unset;
            justify-content: unset;
        }
        .template-preview-box img {
            max-width: 100%;
            max-height: 800px;
            object-fit: contain;
            display: block;
        }
        .overlay-boxes {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            pointer-events: none;
        }
        .draggable-box {
            position: absolute;
            border: 2px dashed #007bff;
            background: rgba(255,255,255,0.2);
            color: #222;
            min-width: 40px;
            min-height: 30px;
            cursor: move;
            pointer-events: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
            z-index: 2;
            overflow: hidden;
        }
        .draggable-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .draggable-box.selected {
            border: 2px solid #007bff;
            background: rgba(0,123,255,0.08);
        }
        .draggable-box.strikethrough-thick {
            position: relative;
        }
        .draggable-box.strikethrough-thick::after {
            content: '';
            position: absolute;
            left: 0; right: 0;
            top: 50%;
            height: 4px;
            background: currentColor;
            pointer-events: none;
            transform: translateY(-50%);
        }
        .preview-container {
            width: 100%;
            margin-top: 24px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
        }
        .preview-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .preview-card img {
            width: 100%;
            height: auto;
            border-radius: 6px;
        }
        
        /* PDF Preview Styles */
        .pdf-preview {
            width: 100%;
            height: auto;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }
        
        .pdf-page {
            margin-bottom: 10px;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 6px;
            overflow: hidden;
        }
        
        .pdf-page canvas {
            width: 100%;
            height: auto;
            display: block;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }
        @media (max-width: 1200px) {
            .main-container {
                max-width: 100vw;
            }
            .template-preview-box {
                max-width: 98vw;
                min-height: 350px;
            }
        }
        @media (max-width: 900px) {
            .main-container {
                flex-direction: column;
                min-height: unset;
                margin: 10px;
                border-radius: 12px;
            }
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
                padding: 16px 12px;
                max-height: 50vh;
                overflow-y: auto;
            }
            .template-area {
                padding: 16px 12px;
            }
            .template-preview-box {
                max-width: 100vw;
                min-height: 200px;
            }
            .sidebar h2 {
                font-size: 1.1rem;
                margin-bottom: 6px;
            }
            .sidebar .btn {
                padding: 8px 12px;
                font-size: 0.85rem;
                margin-bottom: 4px;
            }
            .sidebar .form-control, .sidebar .form-select {
                padding: 8px 10px;
                font-size: 0.85rem;
                margin-bottom: 6px;
            }
            .icon-btn {
                min-width: 36px;
                height: 36px;
                padding: 8px;
            }
            .tooltip-icon .tooltip-text {
                display: none; /* Hide tooltips on mobile to save space */
            }
        }
        
        @media (max-width: 600px) {
            .main-container {
                margin: 5px;
                border-radius: 8px;
            }
            .sidebar {
                padding: 12px 8px;
                max-height: 40vh;
            }
            .template-area {
                padding: 12px 8px;
            }
            .template-preview-box {
                min-height: 150px;
            }
            .sidebar h2 {
                font-size: 1rem;
            }
            .sidebar .btn {
                padding: 10px 12px;
                font-size: 0.9rem;
            }
            .icon-btn {
                min-width: 40px;
                height: 40px;
                padding: 10px;
            }
            .sidebar .form-label {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Landing Page -->
    <div class="landing-page" id="landingPage">
        <div class="landing-header">
            <div class="landing-container">
                <nav class="landing-nav">
                    <a href="#" class="landing-logo">Data Merge</a>
                    <ul class="landing-nav-links">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#how-it-works">How It Works</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                    <a href="#" class="landing-cta-button" onclick="showApp()">Get Started</a>
                </nav>
            </div>
        </div>

        <div class="landing-container">
            <section class="landing-hero">
                <h1>Free Online Data Merge Tool - CSV to PDF Generator</h1>
                <p>Create professional documents with our free data merge online tool. Convert CSV data to PDFs with custom fonts, perfect for certificates, invitations, and bulk document generation. No software download required!</p>
                <div class="landing-cta">
                    <a href="#" class="btn-primary" onclick="showApp()">Start Data Merge Now - Free</a>
                </div>
            </section>

            <section class="landing-features">
                <div class="feature-card">
                    <i class="fas fa-file-csv"></i>
                    <h3>CSV Data Merge</h3>
                    <p>Upload your CSV file and merge data with PDF templates. Perfect for mail merge, certificate generation, and bulk document creation.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-font"></i>
                    <h3>Custom Font Support</h3>
                    <p>Upload your own fonts and create unique, branded documents with personalized typography for professional data merge results.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-file-pdf"></i>
                    <h3>High-Quality PDF Output</h3>
                    <p>Generate crisp, high-resolution PDFs with A4 size standardization. Perfect for printing and professional document distribution.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-bolt"></i>
                    <h3>Bulk Document Generation</h3>
                    <p>Process hundreds of documents in seconds with our optimized bulk PDF generation system. Ideal for large-scale data merge projects.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-mobile-alt"></i>
                    <h3>Online Data Merge Tool</h3>
                    <p>Works seamlessly on desktop, tablet, and mobile devices. No software download required - complete data merge solution in your browser.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Secure Data Processing</h3>
                    <p>Your data stays secure with client-side processing. No server storage of sensitive information during data merge operations.</p>
                </div>
            </section>

        </div>
    </div>

    <!-- Main Application -->
    <div class="main-container" id="mainApp">
        <div class="sidebar">
            <h2><i class="fas fa-file-csv"></i> Data Merge Tool</h2>
            
            <!-- Back to Landing Button -->
            <div class="mb-2">
                <button onclick="showLanding()" style="width: 100%; padding: 10px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; transition: transform 0.2s ease;">
                    <i class="fas fa-home"></i> Back to Landing Page
                </button>
            </div>
            
            <div class="mb-2">
                <label class="form-label">Upload Custom Font (.ttf, .otf)</label>
                <div id="fontDropArea" class="border p-2 mb-1 text-center" style="cursor:pointer; background:#f8f9fa; font-size: 0.85rem;">
                    <span id="fontDropText">Drag & drop font file here or click to select</span>
                    <input type="file" id="fontUploadInput" accept=".ttf,.otf" style="display:none;" />
                </div>
                <div id="fontUploadStatus" class="small text-muted"></div>
            </div>
            <div class="mb-2">
                <label for="templateInput">1. Upload Template</label>
                <input type="file" id="templateInput" accept="image/*,.pdf" class="form-control">
                <small class="text-muted" style="font-size: 0.8rem;">Supports images (JPG, PNG, GIF) and PDF files</small>
            </div>
            <div class="mb-2">
                <label for="csvInput">2. Upload Data (CSV/Excel)</label>
                <input type="file" id="csvInput" accept=".csv,.xlsx,.xls" class="form-control">
            </div>
            <div class="mb-2">
                <label for="fieldSelect" class="form-label">Select Field</label>
                <select id="fieldSelect" class="form-select" disabled>
                    <option value="">Select a field</option>
                </select>
            </div>
            <div class="mb-2">
                <button class="btn btn-outline-primary" id="addTextBoxBtn">Add Text Box</button>
            </div>
            <div id="boxEditor" style="display:none;">
                <div id="boxesContainer"></div>
            </div>
            <div class="accordion" id="sidebarAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDownload">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDownload" aria-expanded="false" aria-controls="collapseDownload" style="padding: 8px 12px; font-size: 0.9rem;">
                            5. Download
                        </button>
                    </h2>
                    <div id="collapseDownload" class="accordion-collapse collapse" aria-labelledby="headingDownload" data-bs-parent="#sidebarAccordion">
                        <div class="accordion-body" style="padding: 8px 12px;">
                            <label style="font-size: 0.85rem; margin-bottom: 4px;">Generate & Download</label>
                            <div class="d-grid gap-1">
                                <button class="btn btn-primary btn-sm" id="downloadBtn" disabled><i class="fas fa-download"></i> Current Image</button>
                                <button class="btn btn-info btn-sm" id="downloadPdfBtn" disabled><i class="fas fa-file-pdf"></i> As PDF</button>
                                <button class="btn btn-success btn-sm" id="downloadAllBtn" disabled><i class="fas fa-file-archive"></i> All Images</button>
                                <button class="btn btn-warning btn-sm" id="downloadAllPdfsBtn" disabled><i class="fas fa-file-pdf"></i> All PDFs</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-2" style="display:none;">
                <label class="form-label">Paste Google Fonts link or CSS URL</label>
                <div class="input-group">
                    <input type="text" id="fontUrlInput" class="form-control" placeholder="https://fonts.googleapis.com/css2?family=Share+Tech&display=swap">
                    <button class="btn btn-outline-primary" id="addFontUrlBtn" type="button">Add Font</button>
                </div>
                <div id="fontUrlStatus" class="small text-muted mt-1"></div>
            </div>
        </div>
        <!-- Main Template Area -->
        <div class="template-area">
            <div class="template-preview-box" id="templatePreview">
                <span class="text-muted">Template preview will appear here</span>
                <div class="overlay-boxes" id="overlayBoxes"></div>
            </div>
            <div id="previewsContainer" class="preview-container"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
                <script src="app.js"></script>
    
    <script>
        // Landing page functionality
        function showApp() {
            document.getElementById('landingPage').classList.remove('show');
            document.getElementById('mainApp').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function showLanding() {
            document.getElementById('landingPage').classList.add('show');
            document.getElementById('mainApp').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function scrollToSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section) {
                section.scrollIntoView({ behavior: 'smooth' });
            }
        }

        // Show landing page by default
        document.getElementById('landingPage').classList.add('show');
    </script>
</body>
</html> 