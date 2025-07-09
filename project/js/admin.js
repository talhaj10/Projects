// Admin Panel JavaScript

document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin panel initialized');
    
    // Initialize admin components
    initializeAdminNavigation();
    initializeAdminForms();
    initializeAdminModals();
    initializeAdminTables();
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 300);
        }, 5000);
    });
});

function initializeAdminNavigation() {
    // Highlight current page in navigation
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.admin-nav-link');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage || (currentPage === '' && href === 'dashboard.php')) {
            link.classList.add('active');
        }
    });
}

function initializeAdminForms() {
    // Form validation
    const forms = document.querySelectorAll('.admin-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#e74c3c';
                    showFieldError(field, 'This field is required');
                } else {
                    field.style.borderColor = '#bdc3c7';
                    hideFieldError(field);
                }
                
                // URL validation for image paths
                if (field.type === 'url' && field.value.trim()) {
                    try {
                        new URL(field.value);
                        field.style.borderColor = '#bdc3c7';
                        hideFieldError(field);
                    } catch {
                        isValid = false;
                        field.style.borderColor = '#e74c3c';
                        showFieldError(field, 'Please enter a valid URL');
                    }
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                const firstError = form.querySelector('[style*="border-color: rgb(231, 76, 60)"]');
                if (firstError) {
                    firstError.focus();
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
        
        // Real-time validation
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateAdminField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.style.borderColor === 'rgb(231, 76, 60)') {
                    validateAdminField(this);
                }
            });
        });
    });
    
    // Image URL preview
    const imageUrlInputs = document.querySelectorAll('input[name="image_path"]');
    imageUrlInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim()) {
                showImagePreview(this);
            }
        });
    });
}

function validateAdminField(field) {
    let isValid = true;
    
    if (field.hasAttribute('required') && !field.value.trim()) {
        isValid = false;
        showFieldError(field, 'This field is required');
    } else if (field.type === 'url' && field.value.trim()) {
        try {
            new URL(field.value);
        } catch {
            isValid = false;
            showFieldError(field, 'Please enter a valid URL');
        }
    }
    
    if (isValid) {
        field.style.borderColor = '#bdc3c7';
        hideFieldError(field);
    } else {
        field.style.borderColor = '#e74c3c';
    }
    
    return isValid;
}

function showFieldError(field, message) {
    hideFieldError(field);
    
    const errorElement = document.createElement('div');
    errorElement.className = 'admin-field-error';
    errorElement.textContent = message;
    errorElement.style.color = '#e74c3c';
    errorElement.style.fontSize = '12px';
    errorElement.style.marginTop = '5px';
    
    field.parentNode.appendChild(errorElement);
}

function hideFieldError(field) {
    const existingError = field.parentNode.querySelector('.admin-field-error');
    if (existingError) {
        existingError.remove();
    }
}

function showImagePreview(input) {
    const existingPreview = input.parentNode.querySelector('.image-preview');
    if (existingPreview) {
        existingPreview.remove();
    }
    
    if (input.value.trim()) {
        const preview = document.createElement('div');
        preview.className = 'image-preview';
        preview.style.marginTop = '10px';
        
        const img = document.createElement('img');
        img.src = input.value;
        img.style.maxWidth = '200px';
        img.style.maxHeight = '150px';
        img.style.borderRadius = '8px';
        img.style.border = '1px solid #bdc3c7';
        
        img.onerror = function() {
            preview.innerHTML = '<span style="color: #e74c3c; font-size: 12px;">Invalid image URL</span>';
        };
        
        preview.appendChild(img);
        input.parentNode.appendChild(preview);
    }
}

function initializeAdminModals() {
    // Modal functionality is handled by individual page scripts
    // This function can be extended for common modal behaviors
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openModals = document.querySelectorAll('.modal[style*="block"]');
            openModals.forEach(modal => {
                modal.style.display = 'none';
            });
        }
    });
}

function initializeAdminTables() {
    // Add sorting functionality to tables
    const tables = document.querySelectorAll('.admin-table');
    
    tables.forEach(table => {
        const headers = table.querySelectorAll('th[data-sort]');
        
        headers.forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', function() {
                const column = this.dataset.sort;
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                
                const isAscending = this.classList.contains('sort-asc');
                
                // Remove sort classes from all headers
                headers.forEach(h => h.classList.remove('sort-asc', 'sort-desc'));
                
                // Add appropriate sort class
                this.classList.add(isAscending ? 'sort-desc' : 'sort-asc');
                
                // Sort rows
                rows.sort((a, b) => {
                    const aValue = a.querySelector(`[data-column="${column}"]`)?.textContent || '';
                    const bValue = b.querySelector(`[data-column="${column}"]`)?.textContent || '';
                    
                    if (isAscending) {
                        return bValue.localeCompare(aValue);
                    } else {
                        return aValue.localeCompare(bValue);
                    }
                });
                
                // Reorder rows in DOM
                rows.forEach(row => tbody.appendChild(row));
            });
        });
    });
}

// Utility functions for admin panel
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type}`;
    notification.textContent = message;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '9999';
    notification.style.minWidth = '300px';
    notification.style.animation = 'slideInRight 0.3s ease';
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 5000);
}

function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// Export admin utilities
window.AdminUtils = {
    showNotification,
    confirmAction,
    validateAdminField,
    showImagePreview
};

// Add CSS animations for notifications
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .sort-asc::after {
        content: ' ↑';
        color: #3498db;
    }
    
    .sort-desc::after {
        content: ' ↓';
        color: #3498db;
    }
`;
document.head.appendChild(style);