<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Font Merge App | Generate Custom Images</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f6f8fa;
            min-height: 100vh;
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


    <div class="main-container">
        <!-- Sidebar Controls -->
        <div class="sidebar">
            <h2><i class="fas fa-image"></i> Image Generator</h2>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" id="jszip-cdn"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
                <script src="app.js"></script>
</body>
</html> 