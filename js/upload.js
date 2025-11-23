document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('arquivo');
    const uploadBox = document.getElementById('uploadBox');
    const defaultUpload = document.getElementById('defaultUpload');
    const previewContainer = document.getElementById('previewContainer');
    const previewArea = document.getElementById('previewArea');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeButton = document.getElementById('removeFile');

    const maxSizes = {
        'image': 10 * 1024 * 1024,    // 10MB
        'video': 50 * 1024 * 1024,    // 50MB
        'audio': 20 * 1024 * 1024     // 20MB
    };

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function resetUpload() {
        fileInput.value = '';
        previewArea.innerHTML = '';
        defaultUpload.style.display = 'flex';
        previewContainer.style.display = 'none';
    }

    function showPreview(file) {
        // Check file size limits
        const fileType = file.type.split('/')[0];
        const maxSize = maxSizes[fileType];
        
        if (!maxSize) {
            alert('Tipo de arquivo não suportado');
            resetUpload();
            return;
        }

        if (file.size > maxSize) {
            alert(`O arquivo excede o limite de ${formatFileSize(maxSize)} para arquivos do tipo ${fileType}`);
            resetUpload();
            return;
        }

        // Update file info
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);

        // Create preview based on file type
        previewArea.innerHTML = '';
        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.onload = () => URL.revokeObjectURL(img.src);
            previewArea.appendChild(img);
        } else if (file.type.startsWith('video/')) {
            const video = document.createElement('video');
            video.src = URL.createObjectURL(file);
            video.controls = true;
            previewArea.appendChild(video);
        } else if (file.type.startsWith('audio/')) {
            const audio = document.createElement('audio');
            audio.src = URL.createObjectURL(file);
            audio.controls = true;
            previewArea.appendChild(audio);
        }

        // Show preview container
        defaultUpload.style.display = 'none';
        previewContainer.style.display = 'block';
    }

    // Handle file selection
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            showPreview(file);
        }
    });

    // Handle drag and drop
    uploadBox.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadBox.style.borderColor = '#11b85a';
    });

    uploadBox.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadBox.style.borderColor = 'rgba(0, 0, 0, 0.08)';
    });

    uploadBox.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadBox.style.borderColor = 'rgba(0, 0, 0, 0.08)';
        const file = e.dataTransfer.files[0];
        if (file) {
            fileInput.files = e.dataTransfer.files;
            showPreview(file);
        }
    });

    // Handle remove button with animation
    removeButton.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        // Add fade out animation to preview container
        previewContainer.style.transition = 'opacity 0.3s ease';
        previewContainer.style.opacity = '0';

        // Reset upload after animation
        setTimeout(() => {
            resetUpload();
            // Reset opacity for next upload
            previewContainer.style.opacity = '1';
        }, 300);

        // Clear the file input
        fileInput.value = '';

        // Show the default upload view
        defaultUpload.style.display = 'flex';
        defaultUpload.style.opacity = '0';
        defaultUpload.style.transition = 'opacity 0.3s ease';
        
        // Fade in the default upload view
        setTimeout(() => {
            defaultUpload.style.opacity = '1';
        }, 300);
    });
});