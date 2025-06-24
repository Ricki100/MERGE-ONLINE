<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Merge App | Generate Custom Images</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f6f8fa;
            min-height: 100vh;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 0;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #2563eb !important;
        }
        .navbar-nav .nav-link {
            font-weight: 500;
            color: #1e293b !important;
            margin: 0 0.5rem;
            transition: color 0.3s ease;
        }
        .navbar-nav .nav-link:hover {
            color: #2563eb !important;
        }
        .main-container {
            max-width: 1500px;
            margin: 40px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 32px rgba(0,0,0,0.08);
            overflow: hidden;
            display: flex;
            min-height: 900px;
        }
        .sidebar {
            width: 340px;
            background: #f8fafc;
            padding: 32px 24px;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            gap: 32px;
        }
        .sidebar h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 18px;
        }
        .sidebar label {
            font-weight: 500;
            margin-bottom: 6px;
        }
        .sidebar .form-control, .sidebar .form-select {
            margin-bottom: 14px;
        }
        .sidebar .btn {
            width: 100%;
            margin-bottom: 10px;
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
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
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
        .template-preview-box img {
            max-width: 100%;
            max-height: 800px;
            object-fit: contain;
            border-radius: 12px;
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
            }
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
                padding: 24px 12px;
            }
            .template-area {
                padding: 24px 12px;
            }
            .template-preview-box {
                max-width: 100vw;
                min-height: 220px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-layer-group me-2"></i>Data Merge
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="privacy.php">Privacy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white px-3 ms-2 active" href="app.php">App</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <!-- Sidebar Controls -->
        <div class="sidebar">
            <h2><i class="fas fa-image"></i> Image Generator</h2>
            <div class="mb-3">
                <label class="form-label">Upload Custom Font (.ttf, .otf)</label>
                <div id="fontDropArea" class="border p-3 mb-2 text-center" style="cursor:pointer; background:#f8f9fa;">
                    <span id="fontDropText">Drag & drop font file here or click to select</span>
                    <input type="file" id="fontUploadInput" accept=".ttf,.otf" style="display:none;" />
                </div>
                <div id="fontUploadStatus" class="small text-muted"></div>
            </div>
            <div>
                <label for="templateInput">1. Upload Template</label>
                <input type="file" id="templateInput" accept="image/*" class="form-control">
            </div>
            <div>
                <label for="csvInput">2. Upload Data (CSV/Excel)</label>
                <input type="file" id="csvInput" accept=".csv,.xlsx,.xls" class="form-control">
            </div>
            <div class="mb-3">
                <label for="fieldSelect" class="form-label">Select Field</label>
                <select id="fieldSelect" class="form-select" disabled>
                    <option value="">Select a field</option>
                </select>
            </div>
            <div class="d-flex gap-2 mb-2">
                <button class="btn btn-outline-primary flex-fill" id="addTextBoxBtn">Add Text Box</button>
                <button class="btn btn-outline-secondary flex-fill" id="addImageBoxBtn">Add Image Box</button>
            </div>
            <div id="boxEditor" style="display:none;">
                <div id="boxesContainer"></div>
            </div>
            <div class="accordion" id="sidebarAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDownload">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDownload" aria-expanded="false" aria-controls="collapseDownload">
                            5. Download
                        </button>
                    </h2>
                    <div id="collapseDownload" class="accordion-collapse collapse" aria-labelledby="headingDownload" data-bs-parent="#sidebarAccordion">
                        <div class="accordion-body">
                            <label>Generate & Download</label>
                            <button class="btn btn-primary" id="downloadBtn" disabled><i class="fas fa-download"></i> Download Current Image</button>
                            <button class="btn btn-success" id="downloadAllBtn" disabled><i class="fas fa-file-archive"></i> Download All Images</button>
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
            <div class="card p-2 mb-4 font-section" id="fontSectionCard" style="display:none; max-width:700px; margin:0 auto 32px auto;">
                <div class="mb-2">
                    <label class="form-label" style="font-size:1.2rem; font-weight:600;">Paste Google Fonts link or CSS URL</label>
                    <div id="fontUrlSection">
                        <input type="text" id="fontUrlInput" class="form-control mb-2" placeholder="https://fonts.googleapis.com/css2?family=Share+Tech&display=swap">
                        <button class="btn btn-outline-primary w-100 mb-2" id="addFontUrlBtn" type="button">Add Font</button>
                    </div>
                    <div id="fontUrlStatus" class="small text-muted mb-2"></div>
                    <a href="#" id="fontUrlHelpLink" class="small text-primary d-block mb-1">How to get the correct Google Fonts URL?</a>
                </div>
            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" id="jszip-cdn"></script>
    <script src="js/app.js"></script>
</body>
</html> 