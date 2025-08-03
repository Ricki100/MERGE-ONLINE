<?php
// Allow iframe embedding
header('X-Frame-Options: ALLOWALL');
header('Content-Security-Policy: frame-ancestors *');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

// Check if this is being called from Elementor
$is_embedded = isset($_GET['embedded']) || isset($_SERVER['HTTP_X_REQUESTED_WITH']);

// If not embedded, redirect to full app
if (!$is_embedded && !isset($_SERVER['HTTP_X_FRAME_OPTIONS'])) {
    header('Location: app.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Font Merge App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Reset styles for embedded version */
        body {
            background: transparent !important;
            margin: 0 !important;
            padding: 0 !important;
            font-family: inherit;
        }
        
        .main-container {
            max-width: 100% !important;
            margin: 0 !important;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 32px rgba(0,0,0,0.08);
            overflow: hidden;
            display: flex;
            min-height: 600px;
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
            min-height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
            overflow: hidden;
            position: relative;
        }
        
        .template-preview-box img {
            max-width: 100%;
            max-height: 600px;
            object-fit: contain;
            border-radius: 12px;
            display: block;
        }
        
        /* Responsive adjustments for embedded version */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
            }
            
            .template-area {
                padding: 24px 16px;
            }
        }
        
        /* Additional styles from original app */
        .overlay-boxes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        
        .overlay-box {
            position: absolute;
            border: 2px dashed #007bff;
            background: rgba(0, 123, 255, 0.1);
            cursor: move;
            pointer-events: all;
            min-width: 50px;
            min-height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #007bff;
        }
        
        .overlay-box.selected {
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.1);
        }
        
        .preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
            width: 100%;
            max-width: 900px;
        }
        
        .preview-item {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px;
            text-align: center;
        }
        
        .preview-item img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }
        
        .font-section {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
        }
    </style>
</head>
<body>
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