# Data Merge - Web-Based Image Generation Tool

A complete web application that allows users to upload templates and CSV/Excel data to generate customized images with text and image overlays. Built with PHP, JavaScript, and modern web technologies.

## 🌟 Features

- **Template Upload**: Support for PNG, JPG, JPEG image formats
- **Data Import**: CSV and Excel file processing
- **Drag & Drop Interface**: Intuitive text and image overlay placement
- **Font Support**: Built-in fonts + custom font upload (.ttf, .otf)
- **Google Fonts Integration**: Add any Google Font via URL
- **Preview System**: See up to 10 generated images before download
- **Bulk Download**: Download all images as a ZIP file
- **Responsive Design**: Works on desktop, tablet, and mobile
- **Privacy-Focused**: Files auto-deleted after 24 hours

## 📁 Project Structure

```
MERGE-ONLINE/
├── index.php              # Homepage with marketing content
├── app.php                # Main application interface
├── about.php              # About page
├── contact.php            # Contact information
├── services.php           # Services and use cases
├── privacy.php            # Privacy policy
├── js/
│   └── app.js            # Main JavaScript functionality
├── fonts/                 # Built-in font collection
├── upload_csv.php         # CSV/Excel processing
├── upload_font.php        # Font upload handler
├── generate_previews.php  # Image generation
├── download_all.php       # Bulk download functionality
├── proxy_image.php        # Image proxy for security
└── vendor/                # Composer dependencies
```

## 🚀 Pages Overview

### 1. Homepage (`index.php`)
- **Meta Title**: "Data Merge | Convert CSV or Excel to Custom Images Online"
- **Meta Description**: Upload a template, add CSV/Excel data, and generate customized images with text and image overlays. 100% web-based. No coding or software installation required.
- **Content**: Hero section, quick steps, features, and call-to-action

### 2. Application (`app.php`)
- Main image generation interface
- Template upload and preview
- CSV/Excel data import
- Drag-and-drop overlay system
- Font management
- Download functionality

### 3. About (`about.php`)
- Company mission and vision
- Technology stack information
- Team background

### 4. Contact (`contact.php`)
- Support email: support@datamerge.app
- Business inquiries: business@datamerge.app
- Support hours: Monday – Saturday | 8 AM – 8 PM
- 24-hour response guarantee

### 5. Services (`services.php`)
- Certificate & Award Generator
- Product Catalog Image Creation
- Student Report Cards & ID Badges
- Event Passes & Invitations
- White-Label Automation
- Industry-specific use cases

### 6. Privacy (`privacy.php`)
- Temporary file handling (24-hour auto-deletion)
- Minimal data storage policy
- No third-party trackers
- Secure session management
- Contact: privacy@datamerge.app

## 🛠️ Technical Stack

- **Backend**: PHP 7.4+
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **UI Framework**: Bootstrap 5.3.0
- **Icons**: Font Awesome 6.0.0
- **Fonts**: Inter (Google Fonts)
- **Image Processing**: PHP GD Library
- **File Handling**: Custom PHP scripts
- **Dependencies**: Managed via Composer

## 🎨 Design Features

- **Modern UI**: Clean, professional design with gradient backgrounds
- **Responsive**: Mobile-first approach with Bootstrap grid system
- **Accessibility**: Semantic HTML and ARIA labels
- **Performance**: Optimized images and minified assets
- **Branding**: Consistent color scheme and typography

## 🔧 Installation

1. **Prerequisites**:
   - PHP 7.4 or higher
   - GD extension enabled
   - Composer (for dependencies)

2. **Setup**:
   ```bash
   # Clone the repository
   git clone [repository-url]
   cd MERGE-ONLINE

   # Install dependencies
   composer install

   # Set up web server
   # Point document root to the project directory
   ```

3. **Configuration**:
   - Ensure `fonts/` directory is writable
   - Configure upload limits in PHP if needed
   - Set up proper file permissions

## 📱 Usage

1. **Upload Template**: Select a PNG, JPG, or JPEG image
2. **Upload Data**: Import CSV or Excel file with your data
3. **Add Overlays**: Drag and drop text or image boxes
4. **Customize**: Adjust fonts, colors, and positioning
5. **Preview**: See generated images with different data entries
6. **Download**: Get individual images or bulk ZIP download

## 🔒 Security & Privacy

- **File Security**: Uploaded files stored in isolated directories
- **Auto-Cleanup**: Files automatically deleted after 24 hours
- **No Tracking**: No analytics or advertising trackers
- **Session Management**: Temporary session storage only
- **Input Validation**: All uploads validated and sanitized

## 🌐 Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

## 📞 Support

- **Email**: support@datamerge.app
- **Business**: business@datamerge.app
- **Privacy**: privacy@datamerge.app
- **Hours**: Monday – Saturday | 8 AM – 8 PM

## 📄 License

Copyright © 2024 Data Merge. All rights reserved.

## 🤝 Contributing

This is a commercial project. For business inquiries or custom development, please contact business@datamerge.app.

---

**Data Merge** - Transform your data into stunning images instantly. No coding required, no software to install. 