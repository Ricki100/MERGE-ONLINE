// Global variables
let templateFile = null;
let csvData = null;
let boxes = [];
let currentRecord = 0;
let selectedBoxId = null;
let availableFonts = {};
let templateNaturalWidth = 0;
let templateNaturalHeight = 0;
let isDownloadMode = false;
let defaultFontFamily = 'Arial';

// Font loading cache
const loadedFonts = {};

// Smart JPEG quality optimization for target file size (1MB-1.5MB)
async function optimizeImageQuality(canvas, targetSizeBytes = 1.25 * 1024 * 1024) { // 1.25MB target
    const maxIterations = 10;
    let quality = 0.95; // Start with high quality
    let minQuality = 0.7; // Minimum acceptable quality
    let bestQuality = quality;
    let bestSize = 0;
    
    for (let i = 0; i < maxIterations; i++) {
        const testDataUrl = canvas.toDataURL('image/jpeg', quality);
        const sizeBytes = (testDataUrl.length - 22) * 3 / 4; // Approximate byte size
        
        // Check if size is within target range (1MB-1.5MB)
        if (sizeBytes >= 1024 * 1024 && sizeBytes <= 1.5 * 1024 * 1024) {
            return { dataUrl: testDataUrl, quality: quality, size: sizeBytes };
        }
        
        // If too large, reduce quality
        if (sizeBytes > 1.5 * 1024 * 1024) {
            quality = Math.max(quality - 0.05, minQuality);
        }
        // If too small, increase quality (but don't exceed 0.95)
        else if (sizeBytes < 1024 * 1024) {
            quality = Math.min(quality + 0.02, 0.95);
        }
        
        // Track best quality within acceptable range
        if (sizeBytes <= 1.5 * 1024 * 1024 && quality > bestQuality) {
            bestQuality = quality;
            bestSize = sizeBytes;
        }
        
        // If we've hit minimum quality, use the best we found
        if (quality <= minQuality) {
            const finalDataUrl = canvas.toDataURL('image/jpeg', bestQuality);
            return { dataUrl: finalDataUrl, quality: bestQuality, size: bestSize };
        }
    }
    
    // Fallback to best quality found
    const finalDataUrl = canvas.toDataURL('image/jpeg', bestQuality);
    return { dataUrl: finalDataUrl, quality: bestQuality, size: bestSize };
}

// PDF Conversion Dialogue
function showPdfConversionDialog() {
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.id = 'pdfConversionModal';
    modal.setAttribute('tabindex', '-1');
    modal.setAttribute('aria-labelledby', 'pdfConversionModalLabel');
    modal.setAttribute('aria-hidden', 'true');
    
    modal.innerHTML = `
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfConversionModalLabel">
                        <i class="fas fa-file-pdf text-danger"></i> Convert to PDF?
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Would you like to convert the processed image to PDF format?</p>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> PDF format is ideal for printing and sharing documents.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, keep as image</button>
                    <button type="button" class="btn btn-primary" id="convertToPdfBtn">
                        <i class="fas fa-file-pdf"></i> Yes, convert to PDF
                    </button>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Show the modal
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
    
    // Handle conversion
    document.getElementById('convertToPdfBtn').addEventListener('click', function() {
        bsModal.hide();
        // Trigger PDF download
        downloadPdfBtn.click();
    });
    
    // Clean up modal when hidden
    modal.addEventListener('hidden.bs.modal', function() {
        document.body.removeChild(modal);
    });
}

// PDF Conversion Dialogue for All Images
function showPdfConversionDialogForAll() {
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.id = 'pdfConversionAllModal';
    modal.setAttribute('tabindex', '-1');
    modal.setAttribute('aria-labelledby', 'pdfConversionAllModalLabel');
    modal.setAttribute('aria-hidden', 'true');
    
    modal.innerHTML = `
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfConversionAllModalLabel">
                        <i class="fas fa-file-pdf text-danger"></i> Convert All to PDFs?
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Would you like to convert all processed images to PDF format?</p>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> This will generate a ZIP file containing PDF versions of all your images.
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> This may take a moment depending on the number of records.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, keep as images</button>
                    <button type="button" class="btn btn-primary" id="convertAllToPdfBtn">
                        <i class="fas fa-file-pdf"></i> Yes, convert all to PDFs
                    </button>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Show the modal
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
    
    // Handle conversion
    document.getElementById('convertAllToPdfBtn').addEventListener('click', function() {
        bsModal.hide();
        // Trigger PDF download for all
        downloadAllPdfsBtn.click();
    });
    
    // Clean up modal when hidden
    modal.addEventListener('hidden.bs.modal', function() {
        document.body.removeChild(modal);
    });
}

const SUPPORTED_FONTS = [
  { name: 'Arial', google: false },
  { name: 'Times New Roman', google: false }
];

// DOM Elements
const templateInput = document.getElementById('templateInput');
const csvInput = document.getElementById('csvInput');
const templatePreview = document.getElementById('templatePreview');
const boxEditor = document.getElementById('boxEditor');
const boxesContainer = document.getElementById('boxesContainer');
const generateBtn = document.getElementById('generateBtn');
const downloadBtn = document.getElementById('downloadBtn');
const downloadPdfBtn = document.getElementById('downloadPdfBtn');
const previewsContainer = document.getElementById('previewsContainer');
const fieldSelect = document.getElementById('fieldSelect');
const addTextBoxBtn = document.getElementById('addTextBoxBtn');
const addImageBoxBtn = document.getElementById('addImageBoxBtn');
const fontPreviewContainer = document.getElementById('fontPreviewContainer');
const fontPreviewBox = document.getElementById('fontPreviewBox');

// Event Listeners
if (templateInput) {
    templateInput.addEventListener('change', handleTemplateUpload);
}
if (csvInput) {
    csvInput.addEventListener('change', handleCSVUpload);
}

document.getElementById('addTextBox')?.addEventListener('click', () => addBox('text'));
document.getElementById('addImageBox')?.addEventListener('click', () => addBox('image'));
downloadBtn.addEventListener('click', async function() {
    if (!templateFile || !csvData || boxes.length === 0) return;
    downloadBtn.disabled = true;
    downloadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Capturing...';
    try {
        isDownloadMode = true;
        renderOverlayBoxes();
        const templatePreview = document.getElementById('templatePreview');
        const img = document.getElementById('templateImg');
        let scale = 1;
        if (img && img.naturalWidth && img.width) {
            scale = Math.max(img.naturalWidth / img.width, img.naturalHeight / img.height);
        }
        const options = {
            scale: scale,
            useCORS: true,
            allowTaint: true,
            backgroundColor: null,
            logging: false,
            onclone: (clonedDoc) => {
                const clonedPreview = clonedDoc.getElementById('templatePreview');
                if (clonedPreview) {
                    const selectedBoxes = clonedPreview.querySelectorAll('.selected');
                    selectedBoxes.forEach(box => box.classList.remove('selected'));
                    const allBoxes = clonedPreview.querySelectorAll('.draggable-box');
                    allBoxes.forEach(box => {
                        box.style.border = 'none';
                        box.style.background = 'transparent';
                        box.style.boxShadow = 'none';
                    });
                }
            }
        };
        // Wait for all fonts and DOM to be ready
        await document.fonts.ready;
        await new Promise(requestAnimationFrame);
        const canvas = await html2canvas(templatePreview, options);
        let cropX = 0, cropY = 0, cropW = canvas.width, cropH = canvas.height;
        if (img) {
            const previewRect = templatePreview.getBoundingClientRect();
            const imgRect = img.getBoundingClientRect();
            cropX = Math.round((imgRect.left - previewRect.left) * scale);
            cropY = Math.round((imgRect.top - previewRect.top) * scale);
            cropW = Math.round(img.naturalWidth);
            cropH = Math.round(img.naturalHeight);
        }
        const croppedCanvas = document.createElement('canvas');
        croppedCanvas.width = cropW;
        croppedCanvas.height = cropH;
        const ctx = croppedCanvas.getContext('2d');
        ctx.drawImage(canvas, cropX, cropY, cropW, cropH, 0, 0, cropW, cropH);
        croppedCanvas.toBlob((blob) => {
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `template_${currentRecord + 1}.jpg`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }, 'image/jpeg', 0.95);
    } catch (error) {
        console.error('Error capturing image:', error);
        alert('Error capturing image. Please try again.');
    } finally {
        isDownloadMode = false;
        renderOverlayBoxes();
        downloadBtn.disabled = false;
        downloadBtn.innerHTML = '<i class="fas fa-download"></i> Download Current Image';
        
        // Show PDF conversion dialogue
        showPdfConversionDialog();
    }
});

// PDF Download functionality
downloadPdfBtn.addEventListener('click', async function() {
    if (!templateFile || !csvData || boxes.length === 0) return;
    downloadPdfBtn.disabled = true;
    downloadPdfBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating PDF...';

    try {
        // Capture the template preview WITH text overlays (same as image generation)
        const templatePreview = document.getElementById('templatePreview');
        const img = document.getElementById('templateImg');
        let scale = 2;
        if (img && img.naturalWidth && img.width) {
            scale = img.naturalWidth / img.width;
        }
        
        // Use the same html2canvas approach as image generation
        const options = {
            scale: scale,
            useCORS: true,
            allowTaint: true,
            backgroundColor: null,
            logging: false,
            onclone: (clonedDoc) => {
                const clonedPreview = clonedDoc.getElementById('templatePreview');
                if (clonedPreview) {
                    const selectedBoxes = clonedPreview.querySelectorAll('.selected');
                    selectedBoxes.forEach(box => box.classList.remove('selected'));
                    const allBoxes = clonedPreview.querySelectorAll('.draggable-box');
                    allBoxes.forEach(box => {
                        box.style.border = 'none';
                        box.style.background = 'transparent';
                        box.style.boxShadow = 'none';
                    });
                }
            }
        };
        
        // Wait for all fonts and DOM to be ready (same as image generation)
        await document.fonts.ready;
        await new Promise(requestAnimationFrame);
        const canvas = await html2canvas(templatePreview, options);
        
        // Crop to just the image area (same as image generation)
        let cropX = 0, cropY = 0, cropW = canvas.width, cropH = canvas.height;
        if (img) {
            const previewRect = templatePreview.getBoundingClientRect();
            const imgRect = img.getBoundingClientRect();
            cropX = Math.round((imgRect.left - previewRect.left) * scale);
            cropY = Math.round((imgRect.top - previewRect.top) * scale);
            cropW = Math.round(img.naturalWidth);
            cropH = Math.round(img.naturalHeight);
        }
        
        const croppedCanvas = document.createElement('canvas');
        croppedCanvas.width = cropW;
        croppedCanvas.height = cropH;
        const ctx = croppedCanvas.getContext('2d');
        ctx.drawImage(canvas, cropX, cropY, cropW, cropH, 0, 0, cropW, cropH);
        
        // Optimize image quality for target file size (1MB-1.5MB)
        const optimizedImage = await optimizeImageQuality(croppedCanvas);
        const imgData = optimizedImage.dataUrl;
        console.log(`PDF Image optimized: Quality ${(optimizedImage.quality * 100).toFixed(1)}%, Size ${(optimizedImage.size / 1024 / 1024).toFixed(2)}MB`);
        const imgElement = new Image();
        imgElement.src = imgData;

        // Wait for image to load
        await new Promise((resolve) => {
            imgElement.onload = resolve;
        });

        // Create PDF with exact image dimensions
        const { jsPDF } = window.jspdf;
        
        // Convert pixels to mm (1 inch = 25.4mm, 1 inch = 96 pixels typically)
        const pixelsToMm = 25.4 / 96;
        const imgWidthMm = imgElement.width * pixelsToMm;
        const imgHeightMm = imgElement.height * pixelsToMm;
        
        // Create PDF with exact image dimensions
        const pdf = new jsPDF({
            orientation: imgWidthMm > imgHeightMm ? 'landscape' : 'portrait',
            unit: 'mm',
            format: [imgWidthMm, imgHeightMm]
        });
        
        // Add image to PDF at full size (0,0 position, full dimensions)
        pdf.addImage(imgData, 'JPEG', 0, 0, imgWidthMm, imgHeightMm);
        
        // Save PDF
        pdf.save(`template_${currentRecord + 1}.pdf`);

    } catch (error) {
        console.error('Error generating PDF:', error);
        alert('Error generating PDF. Please try again.');
    } finally {
        downloadPdfBtn.disabled = false;
        downloadPdfBtn.innerHTML = '<i class="fas fa-file-pdf"></i> Download as PDF';
    }
});

// File handling functions
function handleTemplateUpload(e) {
    const file = e.target.files[0];
    if (file) {
        handleTemplateFile(file);
    }
}

function handleTemplateFile(file) {
    templateFile = file;
    
    if (file.type === 'application/pdf') {
        // Handle PDF file
        handlePDFFile(file);
    } else {
        // Handle image file
        const reader = new FileReader();
        reader.onload = (e) => {
            templatePreview.innerHTML = `<img src="${e.target.result}" class="preview-image" id="templateImg">` + '<div class="overlay-boxes" id="overlayBoxes"></div>';
            // Get natural size
            const img = document.getElementById('templateImg');
            img.onload = function() {
                templateNaturalWidth = img.naturalWidth;
                templateNaturalHeight = img.naturalHeight;
                renderOverlayBoxes();
            };
            setTimeout(renderOverlayBoxes, 100); // re-render overlay after image loads
            checkReadyState();
        };
        reader.readAsDataURL(file);
    }
}

function handlePDFFile(file) {
    const reader = new FileReader();
    reader.onload = async (e) => {
        const typedarray = new Uint8Array(e.target.result);
        
        try {
            // Load PDF document
            const loadingTask = pdfjsLib.getDocument({data: typedarray});
            const pdf = await loadingTask.promise;
            
            // Create container for PDF pages
            const pdfContainer = document.createElement('div');
            pdfContainer.className = 'pdf-preview';
            pdfContainer.id = 'pdfContainer';
            
            // Render first page (you can modify to show multiple pages)
            const page = await pdf.getPage(1);
            
            // Use higher scale for better resolution (3.0 = 3x resolution)
            const scale = 3.0;
            const viewport = page.getViewport({scale: scale});
            
            // Create canvas for the page
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            
            // Render PDF page to canvas
            const renderContext = {
                canvasContext: context,
                viewport: viewport
            };
            
            await page.render(renderContext).promise;
            
            // Add canvas to container
            const pageDiv = document.createElement('div');
            pageDiv.className = 'pdf-page';
            pageDiv.appendChild(canvas);
            pdfContainer.appendChild(pageDiv);
            
            // Add overlay boxes container
            const overlayBoxes = document.createElement('div');
            overlayBoxes.className = 'overlay-boxes';
            overlayBoxes.id = 'overlayBoxes';
            pdfContainer.appendChild(overlayBoxes);
            
            // Set template preview content
            templatePreview.innerHTML = '';
            templatePreview.appendChild(pdfContainer);
            
            // Set natural dimensions
            templateNaturalWidth = viewport.width;
            templateNaturalHeight = viewport.height;
            
            // Store PDF info for later use
            templateFile.pdfDocument = pdf;
            templateFile.pdfPage = page;
            
            setTimeout(renderOverlayBoxes, 100);
            checkReadyState();
            
        } catch (error) {
            console.error('Error loading PDF:', error);
            alert('Error loading PDF file. Please try again.');
        }
    };
    reader.readAsArrayBuffer(file);
}

function getTemplateScale() {
    const img = document.getElementById('templateImg');
    const pdfContainer = document.getElementById('pdfContainer');
    
    if (img) {
        // Image template
        const displayedWidth = img.width;
        const displayedHeight = img.height;
        return {
            scaleX: templateNaturalWidth / displayedWidth,
            scaleY: templateNaturalHeight / displayedHeight
        };
    } else if (pdfContainer) {
        // PDF template
        const canvas = pdfContainer.querySelector('canvas');
        if (canvas) {
            const displayedWidth = canvas.offsetWidth;
            const displayedHeight = canvas.offsetHeight;
            return {
                scaleX: templateNaturalWidth / displayedWidth,
                scaleY: templateNaturalHeight / displayedHeight
            };
        }
    }
    
    return { scaleX: 1, scaleY: 1 };
}

function handleCSVUpload(e) {
    const file = e.target.files[0];
    if (file) {
        handleCSVFile(file);
    }
}

function handleCSVFile(file) {
    const formData = new FormData();
    formData.append('csv', file);
    fetch('upload_csv.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
            return;
        }
        csvData = data;
        currentRecord = 0;
        boxEditor.style.display = 'block';
        checkReadyState();
        renderRecordNavigation();
        renderOverlayBoxes();
        populateFieldDropdown();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error uploading CSV file');
    });
}

// Box handling functions
function addBox(type) {
    addBoxAt(type);
}

function addBoxAt(type, x, y, column) {
    const box = {
        id: Date.now(),
        type: type,
        x: x || 20,
        y: y || 20,
        width: 200,
        height: 100,
        column: column || '',
        fontSize: 24,
        fontFamily: type === 'text' ? defaultFontFamily : 'Arial',
        color: '#000000',
        bold: false,
        italic: false,
        underline: false,
        align: 'center'
    };
    boxes.push(box);
    selectedBoxId = box.id;
    renderBoxEditor();
    renderOverlayBoxes();
    checkReadyState();
    showFontUrlIfTextBoxExists();
}

function renderBox(box) {
    const boxElement = document.createElement('div');
    boxElement.className = 'box-item mb-3 p-3 border rounded';
    boxElement.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5>${box.type === 'text' ? 'Text Box' : 'Image Box'}</h5>
            <button class="btn btn-danger btn-sm" onclick="removeBox(${box.id})">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="row">
            <div class="col-md-6 mb-2">
                <label class="form-label">Column</label>
                <select class="form-select" onchange="updateBox(${box.id}, 'column', this.value)">
                    <option value="">Select Column</option>
                    ${csvData.columns.map(col => `
                        <option value="${col}" ${box.column === col ? 'selected' : ''}>${col}</option>
                    `).join('')}
                </select>
            </div>
            ${box.type === 'text' ? `
                <div class="col-md-6 mb-2">
                    <label class="form-label">Font Size</label>
                    <input type="number" class="form-control" value="${box.fontSize}"
                           onchange="updateBox(${box.id}, 'fontSize', this.value)">
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">Font Family</label>
                    <select class="form-select" onchange="updateBox(${box.id}, 'fontFamily', this.value)">
                        <option value="Arial" ${box.fontFamily === 'Arial' ? 'selected' : ''}>Arial</option>
                        <option value="Times New Roman" ${box.fontFamily === 'Times New Roman' ? 'selected' : ''}>Times New Roman</option>
                        <option value="Helvetica" ${box.fontFamily === 'Helvetica' ? 'selected' : ''}>Helvetica</option>
                    </select>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">Color</label>
                    <input type="color" class="form-control" value="${box.color}"
                           onchange="updateBox(${box.id}, 'color', this.value)">
                </div>
                <div class="col-md-12 mb-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" ${box.bold ? 'checked' : ''}
                               onchange="updateBox(${box.id}, 'bold', this.checked)">
                        <label class="form-check-label">Bold</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" ${box.italic ? 'checked' : ''}
                               onchange="updateBox(${box.id}, 'italic', this.checked)">
                        <label class="form-check-label">Italic</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" ${box.underline ? 'checked' : ''}
                               onchange="updateBox(${box.id}, 'underline', this.checked)">
                        <label class="form-check-label">Underline</label>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">Text Alignment</label>
                    <select class="form-select" onchange="updateBox(${box.id}, 'align', this.value)">
                        <option value="left" ${box.align === 'left' ? 'selected' : ''}>Left</option>
                        <option value="center" ${box.align === 'center' ? 'selected' : ''}>Center</option>
                        <option value="right" ${box.align === 'right' ? 'selected' : ''}>Right</option>
                    </select>
                </div>
            ` : ''}
            <div class="col-md-6 mb-2">
                <label class="form-label">X Position</label>
                <input type="number" class="form-control" value="${box.x}"
                       onchange="updateBox(${box.id}, 'x', this.value)">
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label">Y Position</label>
                <input type="number" class="form-control" value="${box.y}"
                       onchange="updateBox(${box.id}, 'y', this.value)">
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label">Width</label>
                <input type="number" class="form-control" value="${box.width}"
                       onchange="updateBox(${box.id}, 'width', this.value)">
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label">Height</label>
                <input type="number" class="form-control" value="${box.height}"
                       onchange="updateBox(${box.id}, 'height', this.value)">
            </div>
        </div>
    `;
    boxesContainer.appendChild(boxElement);
    renderOverlayBoxes();
    showFontUrlIfTextBoxExists();
}

function renderOverlayBoxes() {
    const overlayBoxes = document.getElementById('overlayBoxes');
    if (!overlayBoxes) return;
    overlayBoxes.innerHTML = '';
    let row = csvData && csvData.all_data ? csvData.all_data[currentRecord] : null;
    for (const box of boxes) {
        const div = document.createElement('div');
        div.className = 'draggable-box' + (box.id === selectedBoxId ? ' selected' : '');
        div.style.left = box.x + 'px';
        div.style.top = box.y + 'px';
        div.style.width = box.width + 'px';
        div.style.height = box.height + 'px';
        div.setAttribute('data-id', box.id);
        
        if (box.type === 'text') {
            let text = box.column && row ? row[box.column] : (box.column || 'Text');
            // Ensure font is loaded before rendering
            if (box.fontFamily) {
                ensureFontLoaded(box.fontFamily);
                div.style.fontFamily = `'${box.fontFamily}', Arial, sans-serif`;
            }
            div.innerHTML = (text || '').replace(/\n/g, '<br>');
            div.style.whiteSpace = 'pre-line';
            // Apply text styles
            div.style.fontSize = (box.fontSize || 24) + 'px';
            div.style.color = box.color || '#000000';
            div.style.fontWeight = box.bold ? 'bold' : 'normal';
            div.style.fontStyle = box.italic ? 'italic' : 'normal';
            let decorations = [];
            if (box.underline) decorations.push('underline');
            if (box.strikethrough) decorations.push('line-through');
            div.style.textDecoration = decorations.length ? decorations.join(' ') : 'none';
            div.style.textAlign = box.align || 'left';
            div.style.display = 'flex';
            div.style.alignItems = 'center';
            div.style.justifyContent = box.align === 'center' ? 'center' : (box.align === 'right' ? 'flex-end' : 'flex-start');
            console.log(`[Text Render] Box ID: ${box.id}, Font: ${box.fontFamily}`);
        } else if (box.type === 'image') {
            let imageUrl = box.column && row ? row[box.column] : '';
            if (imageUrl) {
                const proxiedUrl = 'proxy_image.php?url=' + encodeURIComponent(imageUrl);
                const img = document.createElement('img');
                img.src = proxiedUrl;
                img.onload = function() {
                    if (isDownloadMode) {
                        // Center image at natural size, never stretched
                        img.style.width = img.naturalWidth + 'px';
                        img.style.height = img.naturalHeight + 'px';
                        img.style.maxWidth = 'none';
                        img.style.maxHeight = 'none';
                        img.style.position = 'absolute';
                        img.style.left = ((box.width - img.naturalWidth) / 2) + 'px';
                        img.style.top = ((box.height - img.naturalHeight) / 2) + 'px';
                    } else {
                        img.style.width = '100%';
                        img.style.height = '100%';
                        img.style.objectFit = 'contain';
                        img.style.objectPosition = 'center';
                        img.style.position = '';
                        img.style.left = '';
                        img.style.top = '';
                    }
                };
                div.appendChild(img);
                div.style.position = 'relative';
                div.style.overflow = 'hidden';
                div.style.display = 'flex';
                div.style.alignItems = 'center';
                div.style.justifyContent = 'center';
                // Double-click to fit box to image natural size
                img.onload = function() {
                    div.ondblclick = function(e) {
                        e.stopPropagation();
                        box.width = img.naturalWidth;
                        box.height = img.naturalHeight;
                        renderBoxEditor();
                        renderOverlayBoxes();
                    };
                };
            } else {
                div.textContent = 'No Image';
                div.style.display = 'flex';
                div.style.alignItems = 'center';
                div.style.justifyContent = 'center';
                div.style.color = '#666';
            }
        }
        
        div.onclick = (e) => {
            e.stopPropagation();
            selectedBoxId = box.id;
            renderBoxEditor();
            renderOverlayBoxes();
        };
        overlayBoxes.appendChild(div);
    }
    enableDragResize();
}

function enableDragResize() {
    interact('.draggable-box').draggable({
        listeners: {
            move (event) {
                const target = event.target;
                const id = parseInt(target.getAttribute('data-id'));
                const box = boxes.find(b => b.id === id);
                if (!box) return;
                box.x += event.dx;
                box.y += event.dy;
                target.style.left = box.x + 'px';
                target.style.top = box.y + 'px';
            }
        }
    }).resizable({
        edges: { left: true, right: true, bottom: true, top: true },
        listeners: {
            move (event) {
                const target = event.target;
                const id = parseInt(target.getAttribute('data-id'));
                const box = boxes.find(b => b.id === id);
                if (!box) return;
                let { x, y } = event.target.dataset;
                x = parseFloat(x) || box.x;
                y = parseFloat(y) || box.y;
                target.style.width = event.rect.width + 'px';
                target.style.height = event.rect.height + 'px';
                target.style.left = (x + event.deltaRect.left) + 'px';
                target.style.top = (y + event.deltaRect.top) + 'px';
                box.x = x + event.deltaRect.left;
                box.y = y + event.deltaRect.top;
                box.width = event.rect.width;
                box.height = event.rect.height;
                target.dataset.x = box.x;
                target.dataset.y = box.y;
            }
        },
        modifiers: [
            interact.modifiers.restrictEdges({
                outer: 'parent',
                endOnly: true
            }),
            interact.modifiers.restrictSize({
                min: { width: 40, height: 30 }
            })
        ],
        inertia: true
    });
}

function updateBox(id, property, value) {
    const box = boxes.find(b => b.id === id);
    if (!box) return;
    
    box[property] = value;
    
    // If updating font family, ensure it's loaded before rendering
    if (property === 'fontFamily') {
        ensureFontLoaded(value).then(() => {
            renderOverlayBoxes();
        });
    } else {
        renderOverlayBoxes();
    }
    
    renderBoxEditor();
}

function removeBox(id) {
    boxes = boxes.filter(b => b.id !== id);
    if (boxes.length > 0) {
        selectedBoxId = boxes[boxes.length - 1].id;
    } else {
        selectedBoxId = null;
    }
    renderBoxEditor();
    renderOverlayBoxes();
    checkReadyState();
    showFontUrlIfTextBoxExists();
}

// Add record navigation controls
function renderRecordNavigation() {
    if (!csvData || !csvData.all_data) return;
    let nav = document.getElementById('recordNav');
    if (!nav) {
        nav = document.createElement('div');
        nav.id = 'recordNav';
        nav.className = 'd-flex align-items-center gap-2 mb-3';
        templatePreview.parentNode.insertBefore(nav, templatePreview);
    }
    nav.innerHTML = `
        <button class="btn btn-sm btn-outline-secondary" id="prevRecord">&lt;</button>
        <span>Record <b id="recordNum">${currentRecord + 1}</b> of <b id="recordTotal">${csvData.all_data.length}</b></span>
        <button class="btn btn-sm btn-outline-secondary" id="nextRecord">&gt;</button>
    `;
    document.getElementById('prevRecord').onclick = () => {
        if (currentRecord > 0) { currentRecord--; renderOverlayBoxes(); renderRecordNavigation(); }
    };
    document.getElementById('nextRecord').onclick = () => {
        if (currentRecord < csvData.all_data.length - 1) { currentRecord++; renderOverlayBoxes(); renderRecordNavigation(); }
    };
}

// Helper to fetch JSON with error handling
async function fetchJsonWithErrorHandling(url, options) {
    const response = await fetch(url, options);
    const text = await response.text();
    try {
        return JSON.parse(text);
    } catch (e) {
        alert('Server error: ' + text);
        throw e;
    }
}

// Fetch available TTFs from list_fonts.php
fetchJsonWithErrorHandling('list_fonts.php')
    .then(fontList => {
        availableFonts = fontList;
        updateFontDropdown();
    });

function updateFontDropdown() {
    const fontSelects = document.querySelectorAll('select.form-select');
    fontSelects.forEach(select => {
        if (select.getAttribute('data-font-dropdown')) {
            // Remove old options
            select.innerHTML = '';

            // Always add base fonts
            SUPPORTED_FONTS.forEach(font => {
                const option = document.createElement('option');
                option.value = font.name;
                option.textContent = font.name;
                select.appendChild(option);
            });

            // Add custom fonts if any
            if (Array.isArray(availableFonts)) {
                availableFonts.forEach(fontName => {
                    if (!SUPPORTED_FONTS.some(f => f.name === fontName)) {
                        const option = document.createElement('option');
                        option.value = fontName;
                        option.textContent = fontName;
                        select.appendChild(option);
                    }
                });
            }

            // Set default selection to defaultFontFamily if present
            if (defaultFontFamily && (SUPPORTED_FONTS.some(f => f.name === defaultFontFamily) || (Array.isArray(availableFonts) && availableFonts.includes(defaultFontFamily)))) {
                select.value = defaultFontFamily;
            }
        }
    });
}

function injectFontFace(fontName) {
    if (document.getElementById('ff-' + fontName)) return;
    
    // Skip for base fonts as they're system fonts
    if (SUPPORTED_FONTS.some(f => f.name === fontName)) return;
    
    // Only use .ttf for custom fonts
    const ttfUrl = `fonts/${fontName}.ttf`;
    // Check if the .ttf file exists
    fetch(ttfUrl, { method: 'HEAD' }).then(response => {
        if (response.ok) {
            const style = document.createElement('style');
            style.id = 'ff-' + fontName;
            style.textContent = `@font-face { font-family: '${fontName}'; src: url('fonts/${fontName}.ttf') format('truetype'); font-display: swap; }`;
            document.head.appendChild(style);
            if (!loadedFonts[fontName]) {
                new FontFace(fontName, `url(${ttfUrl})`).load()
                    .then(font => {
                        document.fonts.add(font);
                        loadedFonts[fontName] = true;
                        console.log(`[FontFace] Loaded: ${fontName} from ${ttfUrl}`);
                    })
                    .catch(() => {
                        console.warn(`[FontFace] Failed to load font: ${fontName}`);
                    });
            }
        } else {
            console.warn(`[FontFace] No .ttf font file found for: ${fontName}`);
        }
    });
}

// Wait for font to be loaded before rendering text boxes
async function ensureFontLoaded(fontName) {
    if (loadedFonts[fontName]) return;
    
    try {
        // Check if the font is already in the document.fonts
        const fontStatus = await document.fonts.check(`1em ${fontName}`);
        if (fontStatus) {
            loadedFonts[fontName] = true;
            console.log(`[FontFace] Font ready: ${fontName}`);
            return;
        }
        
        // If not, wait for it to load
        await document.fonts.load(`1em ${fontName}`);
        loadedFonts[fontName] = true;
        console.log(`[FontFace] Font ready: ${fontName}`);
    } catch (e) {
        console.warn(`[FontFace] Font not ready: ${fontName}`);
    }
}

function getFontFaceName(box) {
    // For preview, use Google Font or system font name
    return box.fontFamily;
}

// Only show controls for selected box
function renderBoxEditor() {
    boxesContainer.innerHTML = '';
    const box = boxes.find(b => b.id === selectedBoxId);
    if (!box) return;
    const boxElement = document.createElement('div');
    boxElement.className = 'box-item mb-3 p-3 border rounded';
    
    boxElement.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5>${box.type === 'text' ? 'Text Box' : 'Image Box'}</h5>
            <button class="btn btn-danger btn-sm" onclick="removeBox(${box.id})">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="row">
            <div class="col-md-6 mb-2">
                <label class="form-label">Column</label>
                <select class="form-select" onchange="updateBox(${box.id}, 'column', this.value)">
                    <option value="">Select Column</option>
                    ${csvData.columns.map(col => `
                        <option value="${col}" ${box.column === col ? 'selected' : ''}>${col}</option>
                    `).join('')}
                </select>
            </div>
            ${box.type === 'text' ? `
                <div class="col-md-6 mb-2">
                    <label class="form-label">Font Size</label>
                    <input type="number" class="form-control" value="${box.fontSize}"
                           onchange="updateBox(${box.id}, 'fontSize', this.value)">
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">Font Family</label>
                    <select class="form-select" data-font-dropdown="1" onchange="updateBox(${box.id}, 'fontFamily', this.value)">
                        ${availableFonts.map(font => 
                            `<option value="${font}" ${box.fontFamily === font ? 'selected' : ''}>${font}</option>`
                        ).join('')}
                    </select>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">Color</label>
                    <input type="color" class="form-control" value="${box.color}"
                           onchange="updateBox(${box.id}, 'color', this.value)">
                </div>
                <div class="col-md-12 mb-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" ${box.bold ? 'checked' : ''}
                               onchange="updateBox(${box.id}, 'bold', this.checked)">
                        <label class="form-check-label">Bold</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" ${box.italic ? 'checked' : ''}
                               onchange="updateBox(${box.id}, 'italic', this.checked)">
                        <label class="form-check-label">Italic</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" ${box.underline ? 'checked' : ''}
                               onchange="updateBox(${box.id}, 'underline', this.checked)">
                        <label class="form-check-label">Underline</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" ${box.strikethrough ? 'checked' : ''}
                               onchange="updateBox(${box.id}, 'strikethrough', this.checked)">
                        <label class="form-check-label">Strikethrough</label>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">Text Alignment</label>
                    <select class="form-select" onchange="updateBox(${box.id}, 'align', this.value)">
                        <option value="left" ${box.align === 'left' ? 'selected' : ''}>Left</option>
                        <option value="center" ${box.align === 'center' ? 'selected' : ''}>Center</option>
                        <option value="right" ${box.align === 'right' ? 'selected' : ''}>Right</option>
                    </select>
                </div>
            ` : ''}
            <div class="col-md-6 mb-2">
                <label class="form-label">X Position</label>
                <input type="number" class="form-control" value="${box.x}"
                       onchange="updateBox(${box.id}, 'x', this.value)">
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label">Y Position</label>
                <input type="number" class="form-control" value="${box.y}"
                       onchange="updateBox(${box.id}, 'y', this.value)">
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label">Width</label>
                <input type="number" class="form-control" value="${box.width}"
                       onchange="updateBox(${box.id}, 'width', this.value)">
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label">Height</label>
                <input type="number" class="form-control" value="${box.height}"
                       onchange="updateBox(${box.id}, 'height', this.value)">
            </div>
        </div>
    `;
    boxesContainer.appendChild(boxElement);
    showFontUrlIfTextBoxExists();
}

// --- Field dropdown and Add Text Box button logic ---
function populateFieldDropdown() {
    if (!fieldSelect || !csvData) return;
    fieldSelect.innerHTML = '<option value="">Select a field</option>';
    csvData.columns.forEach(col => {
        const opt = document.createElement('option');
        opt.value = col;
        opt.textContent = col;
        fieldSelect.appendChild(opt);
    });
    fieldSelect.disabled = false;
}

if (fieldSelect && addTextBoxBtn && addImageBoxBtn) {
    fieldSelect.addEventListener('change', function() {
        const enabled = !!fieldSelect.value;
        addTextBoxBtn.disabled = !enabled;
        addImageBoxBtn.disabled = !enabled;
    });
    addTextBoxBtn.addEventListener('click', function() {
        if (!fieldSelect.value) return;
        addBoxAt('text', 50, 50, fieldSelect.value);
        fieldSelect.value = '';
        addTextBoxBtn.disabled = true;
        addImageBoxBtn.disabled = true;
    });
    addImageBoxBtn.addEventListener('click', function() {
        if (!fieldSelect.value) return;
        addBoxAt('image', 50, 50, fieldSelect.value);
        fieldSelect.value = '';
        addTextBoxBtn.disabled = true;
        addImageBoxBtn.disabled = true;
    });
}

// Enable/disable Download buttons
function checkReadyState() {
    const isReady = templateFile && csvData && boxes.length > 0;
    downloadBtn.disabled = !isReady;
    downloadPdfBtn.disabled = !isReady;
    const downloadAllBtn = document.getElementById('downloadAllBtn');
    if (downloadAllBtn) downloadAllBtn.disabled = !isReady;
    const downloadAllPdfsBtn = document.getElementById('downloadAllPdfsBtn');
    if (downloadAllPdfsBtn) downloadAllPdfsBtn.disabled = !isReady;
}

// Download All Images logic
const downloadAllBtn = document.getElementById('downloadAllBtn');
if (downloadAllBtn) {
    downloadAllBtn.addEventListener('click', async function() {
        if (!templateFile || !csvData || boxes.length === 0) return;
        downloadAllBtn.disabled = true;
        downloadAllBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Zipping...';
        const JSZipScript = document.getElementById('jszip-cdn');
        if (!window.JSZip && !JSZipScript) {
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js';
            script.id = 'jszip-cdn';
            document.body.appendChild(script);
            await new Promise(res => { script.onload = res; });
        } else if (!window.JSZip && JSZipScript) {
            await new Promise(res => { JSZipScript.onload = res; });
        }
        const zip = new JSZip();
        const templatePreview = document.getElementById('templatePreview');
        const img = document.getElementById('templateImg');
        let scale = 2;
        if (img && img.naturalWidth && img.width) {
            scale = img.naturalWidth / img.width;
        }
        isDownloadMode = true;
        for (let i = 0; i < csvData.all_data.length; i++) {
            currentRecord = i;
            renderOverlayBoxes();
            await new Promise(r => setTimeout(r, 50)); // let DOM update
            const options = {
                scale: scale,
                useCORS: true,
                allowTaint: true,
                backgroundColor: null,
                logging: false,
                onclone: (clonedDoc) => {
                    const clonedPreview = clonedDoc.getElementById('templatePreview');
                    if (clonedPreview) {
                        const selectedBoxes = clonedPreview.querySelectorAll('.selected');
                        selectedBoxes.forEach(box => box.classList.remove('selected'));
                        const allBoxes = clonedPreview.querySelectorAll('.draggable-box');
                        allBoxes.forEach(box => {
                            box.style.border = 'none';
                            box.style.background = 'transparent';
                            box.style.boxShadow = 'none';
                        });
                    }
                }
            };
            // Wait for all fonts and DOM to be ready
            await document.fonts.ready;
            await new Promise(requestAnimationFrame);
            const canvas = await html2canvas(templatePreview, options);
            let cropX = 0, cropY = 0, cropW = canvas.width, cropH = canvas.height;
            if (img) {
                const previewRect = templatePreview.getBoundingClientRect();
                const imgRect = img.getBoundingClientRect();
                cropX = Math.round((imgRect.left - previewRect.left) * scale);
                cropY = Math.round((imgRect.top - previewRect.top) * scale);
                cropW = Math.round(img.naturalWidth);
                cropH = Math.round(img.naturalHeight);
            }
            const croppedCanvas = document.createElement('canvas');
            croppedCanvas.width = cropW;
            croppedCanvas.height = cropH;
            const ctx = croppedCanvas.getContext('2d');
            ctx.drawImage(canvas, cropX, cropY, cropW, cropH, 0, 0, cropW, cropH);
            const blob = await new Promise(res => croppedCanvas.toBlob(res, 'image/jpeg', 0.95));
            zip.file(`image_${i+1}.jpg`, blob);
        }
        isDownloadMode = false;
        // Restore current record
        currentRecord = 0;
        renderOverlayBoxes();
        renderRecordNavigation();
        const content = await zip.generateAsync({type: 'blob'});
        const url = URL.createObjectURL(content);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'images.zip';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        downloadAllBtn.disabled = false;
        downloadAllBtn.innerHTML = '<i class="fas fa-file-archive"></i> Download All Images';
        
        // Show PDF conversion dialogue for all images
        showPdfConversionDialogForAll();
    });
}

// Download All PDFs logic
const downloadAllPdfsBtn = document.getElementById('downloadAllPdfsBtn');
if (downloadAllPdfsBtn) {
    downloadAllPdfsBtn.addEventListener('click', async function() {
        if (!templateFile || !csvData || boxes.length === 0) return;
        downloadAllPdfsBtn.disabled = true;
        downloadAllPdfsBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating PDFs...';
        
        const JSZipScript = document.getElementById('jszip-cdn');
        if (!window.JSZip && !JSZipScript) {
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js';
            script.id = 'jszip-cdn';
            document.body.appendChild(script);
            await new Promise(res => { script.onload = res; });
        } else if (!window.JSZip && JSZipScript) {
            await new Promise(res => { JSZipScript.onload = res; });
        }
        
        const zip = new JSZip();
        const templatePreview = document.getElementById('templatePreview');
        const img = document.getElementById('templateImg');
        let scale = 2;
        if (img && img.naturalWidth && img.width) {
            scale = img.naturalWidth / img.width;
        }
        
        isDownloadMode = true;
        
        try {
            for (let i = 0; i < csvData.all_data.length; i++) {
                currentRecord = i;
                renderOverlayBoxes();
                await new Promise(r => setTimeout(r, 50)); // let DOM update
                
                // Get current record data
                const currentData = csvData.all_data[i];
                if (!currentData) {
                    console.warn(`No data available for record ${i + 1}`);
                    continue;
                }
                
                // Use the same html2canvas approach as image generation
                const options = {
                    scale: scale,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: null,
                    logging: false,
                    onclone: (clonedDoc) => {
                        const clonedPreview = clonedDoc.getElementById('templatePreview');
                        if (clonedPreview) {
                            const selectedBoxes = clonedPreview.querySelectorAll('.selected');
                            selectedBoxes.forEach(box => box.classList.remove('selected'));
                            const allBoxes = clonedPreview.querySelectorAll('.draggable-box');
                            allBoxes.forEach(box => {
                                box.style.border = 'none';
                                box.style.background = 'transparent';
                                box.style.boxShadow = 'none';
                            });
                        }
                    }
                };
                
                // Wait for all fonts and DOM to be ready (same as image generation)
                await document.fonts.ready;
                await new Promise(requestAnimationFrame);
                const canvas = await html2canvas(templatePreview, options);
                
                // Crop to just the image area (same as image generation)
                let cropX = 0, cropY = 0, cropW = canvas.width, cropH = canvas.height;
                if (img) {
                    const previewRect = templatePreview.getBoundingClientRect();
                    const imgRect = img.getBoundingClientRect();
                    cropX = Math.round((imgRect.left - previewRect.left) * scale);
                    cropY = Math.round((imgRect.top - previewRect.top) * scale);
                    cropW = Math.round(img.naturalWidth);
                    cropH = Math.round(img.naturalHeight);
                }
                
                const croppedCanvas = document.createElement('canvas');
                croppedCanvas.width = cropW;
                croppedCanvas.height = cropH;
                const ctx = croppedCanvas.getContext('2d');
                ctx.drawImage(canvas, cropX, cropY, cropW, cropH, 0, 0, cropW, cropH);
                
                // Optimize image quality for target file size (1MB-1.5MB)
                const optimizedImage = await optimizeImageQuality(croppedCanvas);
                const imgData = optimizedImage.dataUrl;
                console.log(`PDF ${i+1} optimized: Quality ${(optimizedImage.quality * 100).toFixed(1)}%, Size ${(optimizedImage.size / 1024 / 1024).toFixed(2)}MB`);
                const imgElement = new Image();
                imgElement.src = imgData;
                
                // Wait for image to load
                await new Promise((resolve) => {
                    imgElement.onload = resolve;
                });
                
                // Create PDF with exact image dimensions
                const { jsPDF } = window.jspdf;
                
                // Convert pixels to mm (1 inch = 25.4mm, 1 inch = 96 pixels typically)
                const pixelsToMm = 25.4 / 96;
                const imgWidthMm = imgElement.width * pixelsToMm;
                const imgHeightMm = imgElement.height * pixelsToMm;
                
                // Create PDF with exact image dimensions
                const pdf = new jsPDF({
                    orientation: imgWidthMm > imgHeightMm ? 'landscape' : 'portrait',
                    unit: 'mm',
                    format: [imgWidthMm, imgHeightMm]
                });
                
                // Add image to PDF at full size (0,0 position, full dimensions)
                pdf.addImage(imgData, 'JPEG', 0, 0, imgWidthMm, imgHeightMm);
                
                // Generate PDF blob
                const pdfBlob = pdf.output('blob');
                zip.file(`pdf_${i+1}.pdf`, pdfBlob);
            }
            
            // Generate and download zip
            const content = await zip.generateAsync({type: 'blob'});
            const url = URL.createObjectURL(content);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'pdfs.zip';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            
        } catch (error) {
            console.error('Error generating PDFs:', error);
            alert('Error generating PDFs. Please try again.');
        } finally {
            isDownloadMode = false;
            // Restore current record
            currentRecord = 0;
            renderOverlayBoxes();
            renderRecordNavigation();
            downloadAllPdfsBtn.disabled = false;
            downloadAllPdfsBtn.innerHTML = '<i class="fas fa-file-pdf"></i> Download All PDFs';
        }
    });
}

// Font upload logic
const fontDropArea = document.getElementById('fontDropArea');
const fontUploadInput = document.getElementById('fontUploadInput');
const fontUploadStatus = document.getElementById('fontUploadStatus');
if (fontDropArea && fontUploadInput) {
    fontDropArea.addEventListener('click', () => fontUploadInput.click());
    fontDropArea.addEventListener('dragover', e => { e.preventDefault(); fontDropArea.style.background = '#e3e6ea'; });
    fontDropArea.addEventListener('dragleave', e => { e.preventDefault(); fontDropArea.style.background = '#f8f9fa'; });
    fontDropArea.addEventListener('drop', e => {
        e.preventDefault();
        fontDropArea.style.background = '#f8f9fa';
        if (e.dataTransfer.files && e.dataTransfer.files[0]) {
            handleFontUpload(e.dataTransfer.files[0]);
        }
    });
    fontUploadInput.addEventListener('change', e => {
        if (fontUploadInput.files && fontUploadInput.files[0]) {
            handleFontUpload(fontUploadInput.files[0]);
        }
    });
}
function handleFontUpload(file) {
    if (!file.name.match(/\.(ttf|otf)$/i)) {
        fontUploadStatus.textContent = 'Only .ttf and .otf files are allowed.';
        fontUploadStatus.style.color = 'red';
        return;
    }
    
    fontUploadStatus.textContent = 'Processing font...';
    fontUploadStatus.style.color = '#888';
    
    const reader = new FileReader();
    reader.onload = function(e) {
        try {
            const base64 = e.target.result.split(',')[1]; // Get base64 data
            const fontName = file.name.replace(/\.(ttf|otf)$/i, '');
            const fileExtension = file.name.match(/\.(ttf|otf)$/i)[1].toLowerCase();
            const format = fileExtension === 'ttf' ? 'truetype' : 'opentype';
            
            // Remove existing font-face if it exists
            const existingStyle = document.getElementById(`font-face-${fontName}`);
            if (existingStyle) {
                existingStyle.remove();
            }
            
            // Create @font-face rule with data URL
            const style = document.createElement('style');
            style.id = `font-face-${fontName}`;
            style.textContent = `
                @font-face {
                    font-family: '${fontName}';
                    src: url(data:font/${fileExtension};base64,${base64}) format('${format}');
                    font-display: swap;
                }
            `;
            document.head.appendChild(style);
            
            // Add to available fonts if not already present
            if (!availableFonts.includes(fontName)) {
                availableFonts.push(fontName);
                updateFontDropdown();
            }
            
            // Set as default font for new text boxes
            defaultFontFamily = fontName;
            
            // Update existing text boxes that use the old default
            boxes.forEach(box => {
                if (box.type === 'text' && (!box.fontFamily || box.fontFamily === 'Arial')) {
                    box.fontFamily = fontName;
                }
            });
            
            renderBoxEditor();
            renderOverlayBoxes();
            
            fontUploadStatus.textContent = `Font "${fontName}" loaded successfully!`;
            fontUploadStatus.style.color = 'green';
            
        } catch (error) {
            console.error('Error processing font:', error);
            fontUploadStatus.textContent = 'Error processing font file.';
            fontUploadStatus.style.color = 'red';
        }
    };
    
    reader.onerror = function() {
        fontUploadStatus.textContent = 'Error reading font file.';
        fontUploadStatus.style.color = 'red';
    };
    
    reader.readAsDataURL(file);
}

// Font URL logic
const fontUrlInput = document.getElementById('fontUrlInput');
const addFontUrlBtn = document.getElementById('addFontUrlBtn');
const fontUrlStatus = document.getElementById('fontUrlStatus');

async function getFontFamilyFromGoogleFontsUrl(url) {
    // Fetch the CSS and extract the font-family
    try {
        const res = await fetch(url);
        const css = await res.text();
        const match = css.match(/font-family:\s*'([^']+)'/);
        if (match) {
            return match[1];
        }
    } catch (e) {
        console.warn('Could not fetch Google Fonts CSS:', e);
    }
    // Fallback: try to parse from URL
    const urlMatch = url.match(/family=([^:&]+)/);
    if (urlMatch) {
        return decodeURIComponent(urlMatch[1]).replace(/\+/g, ' ').split(':')[0];
    }
    return '';
}

if (addFontUrlBtn && fontUrlInput) {
    addFontUrlBtn.addEventListener('click', async function() {
        const url = fontUrlInput.value.trim();
        if (url.includes('fonts.google.com/share')) {
            fontUrlStatus.textContent = 'This is a share link. Please use the "Use on the web" link from Google Fonts.';
            fontUrlStatus.style.color = 'red';
            if (fontPreviewContainer) fontPreviewContainer.style.display = 'none';
            return;
        }
        if (!url) {
            fontUrlStatus.textContent = 'Please paste a Google Fonts link or CSS URL.';
            fontUrlStatus.style.color = 'red';
            if (fontPreviewContainer) fontPreviewContainer.style.display = 'none';
            return;
        }
        fontUrlStatus.textContent = 'Adding font...';
        fontUrlStatus.style.color = '#888';
        if (url.startsWith('http') && url.includes('fonts.googleapis.com')) {
            let fontName = await getFontFamilyFromGoogleFontsUrl(url);
            if (!fontName) {
                fontUrlStatus.textContent = 'Could not determine font name. Please enter it manually.';
                fontUrlStatus.style.color = 'orange';
                if (fontPreviewContainer) fontPreviewContainer.style.display = 'none';
                return;
            }
            if (!document.querySelector(`link[href="${url}"]`)) {
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = url;
                document.head.appendChild(link);
            }
            if (!availableFonts.includes(fontName)) {
                availableFonts.push(fontName);
                updateFontDropdown();
                fontUrlStatus.textContent = `Font "${fontName}" added! Select it from the dropdown.`;
                fontUrlStatus.style.color = 'green';
            } else {
                fontUrlStatus.textContent = `Font "${fontName}" is now available.`;
                fontUrlStatus.style.color = 'green';
            }
            // Show preview
            if (fontPreviewContainer && fontPreviewBox) {
                fontPreviewContainer.style.display = '';
                fontPreviewBox.style.fontFamily = `'${fontName}', Arial, sans-serif`;
            }
            // Auto-select for current text box
            if (fontName && typeof selectedBoxId !== 'undefined') {
                const box = boxes.find(b => b.id === selectedBoxId && b.type === 'text');
                if (box) {
                    box.fontFamily = fontName;
                    // Wait for font to load before rendering
                    await document.fonts.load(`1em '${fontName}'`);
                    updateFontDropdown();
                    renderBoxEditor();
                    renderOverlayBoxes();
                    console.log(`[Text Render] Box ID: ${box.id}, Font: ${box.fontFamily}`);
                }
            }
            return;
        } else if (url.startsWith('http') && url.endsWith('.css')) {
            if (document.querySelector(`link[href="${url}"]`)) {
                fontUrlStatus.textContent = 'Font CSS already added.';
                fontUrlStatus.style.color = 'green';
                if (fontPreviewContainer) fontPreviewContainer.style.display = 'none';
                return;
            }
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = url;
            document.head.appendChild(link);
            fontUrlStatus.textContent = 'Font CSS added. Enter the font-family name in the dropdown.';
            fontUrlStatus.style.color = 'green';
            if (fontPreviewContainer) fontPreviewContainer.style.display = 'none';
        } else {
            fontUrlStatus.textContent = 'Invalid URL. Only Google Fonts or direct CSS URLs are supported.';
            fontUrlStatus.style.color = 'red';
            if (fontPreviewContainer) fontPreviewContainer.style.display = 'none';
        }
    });
}

// Helper modal for Google Fonts URL
function showFontUrlHelp() {
    const modal = document.createElement('div');
    modal.innerHTML = `
    <div class="modal fade" id="fontUrlHelpModal" tabindex="-1" aria-labelledby="fontUrlHelpModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="fontUrlHelpModalLabel">How to Get the Correct Google Fonts URL</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <ol>
              <li>Go to <a href='https://fonts.google.com/' target='_blank'>Google Fonts</a>.</li>
              <li>Select your fonts.</li>
              <li>In the right sidebar, under <b>"Use on the web"</b>, copy the <b>link</b> that starts with <code>https://fonts.googleapis.com/css2?family=...</code>.</li>
              <li>Paste that URL here. <br><b>Do not use the share link!</b></li>
            </ol>
            <div class='alert alert-info small'>
              <b>Example:</b><br>
              <code>https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap</code>
            </div>
          </div>
        </div>
      </div>
    </div>`;
    document.body.appendChild(modal);
    const modalEl = new bootstrap.Modal(document.getElementById('fontUrlHelpModal'));
    modalEl.show();
    modalEl._element.addEventListener('hidden.bs.modal', () => modal.remove());
}

// Add helper link below fontUrlInput
if (fontUrlInput && !document.getElementById('fontUrlHelpLink')) {
    const helpLink = document.createElement('a');
    helpLink.href = '#';
    helpLink.id = 'fontUrlHelpLink';
    helpLink.className = 'small text-primary';
    helpLink.innerText = 'How to get the correct Google Fonts URL?';
    helpLink.style.display = 'block';
    helpLink.style.marginTop = '4px';
    helpLink.onclick = (e) => { e.preventDefault(); showFontUrlHelp(); };
    fontUrlInput.parentNode.parentNode.insertBefore(helpLink, fontUrlInput.parentNode.nextSibling);
}

function showFontUrlIfTextBoxExists() {
    const hasTextBox = boxes.some(b => b.type === 'text');
    const fontSectionCard = document.getElementById('fontSectionCard');
    if (fontSectionCard) fontSectionCard.style.display = hasTextBox ? '' : 'none';
}

// Call after adding/removing a text box and in renderBoxEditor
const originalAddBox = addBox;
addBox = function() {
    originalAddBox.apply(this, arguments);
    showFontUrlIfTextBoxExists();
};

const originalAddBoxAt = addBoxAt;
addBoxAt = function() {
    originalAddBoxAt.apply(this, arguments);
    showFontUrlIfTextBoxExists();
};

const originalRemoveBox = removeBox;
removeBox = function() {
    originalRemoveBox.apply(this, arguments);
    showFontUrlIfTextBoxExists();
};

// Also call in renderBoxEditor
const originalRenderBoxEditor = renderBoxEditor;
renderBoxEditor = function() {
    originalRenderBoxEditor.apply(this, arguments);
    showFontUrlIfTextBoxExists();
}; 