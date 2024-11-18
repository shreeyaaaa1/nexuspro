// Form validation
document.addEventListener('DOMContentLoaded', function() {
    'use strict';
    
    // Form validation for all forms with 'needs-validation' class
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
    
    // Keywords input handling
    var keywordsInput = document.getElementById('keywords');
    if (keywordsInput) {
        keywordsInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                var value = this.value.trim();
                if (value) {
                    this.value = value + ', ';
                }
            }
        });
    }
    
    // Auto-hide alerts after 5 seconds
    var alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 500);
        }, 5000);
    });
    
    // Confirmation dialogs
    var confirmActions = document.querySelectorAll('[data-confirm]');
    confirmActions.forEach(function(element) {
        element.addEventListener('click', function(e) {
            if (!confirm(this.dataset.confirm)) {
                e.preventDefault();
            }
        });
    });
    
    // File upload preview
    var fileInputs = document.querySelectorAll('.custom-file-input');
    fileInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            var fileName = this.files[0].name;
            var label = this.nextElementSibling;
            label.textContent = fileName;
        });
    });
});

// Research data visualization functions
function initializeCharts(data) {
    if (!data) return;
    
    // Example chart initialization using a hypothetical charting library
    // This should be replaced with actual chart implementation
    if (document.getElementById('projectProgressChart')) {
        createProjectProgressChart(data.progress);
    }
    
    if (document.getElementById('dataDistributionChart')) {
        createDataDistributionChart(data.distribution);
    }
}

function createProjectProgressChart(data) {
    // Implementation for project progress chart
    console.log('Project progress chart initialized');
}

function createDataDistributionChart(data) {
    // Implementation for data distribution chart
    console.log('Data distribution chart initialized');
}

// Dynamic metadata field handling
function addMetadataField(container, fieldName) {
    var fieldCount = document.querySelectorAll('.metadata-field').length;
    var template = `
        <div class="metadata-field mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="metadata[${fieldCount}][key]" placeholder="Field name" required>
                <input type="text" class="form-control" name="metadata[${fieldCount}][value]" placeholder="Value" required>
                <button type="button" class="btn btn-danger" onclick="removeMetadataField(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', template);
}

function removeMetadataField(button) {
    button.closest('.metadata-field').remove();
}

// Collaboration features
function initializeCollaboration() {
    var collaboratorSelect = document.getElementById('collaborator-select');
    if (collaboratorSelect) {
        collaboratorSelect.addEventListener('change', function() {
            updateCollaboratorPermissions(this.value);
        });
    }
}

function updateCollaboratorPermissions(userId) {
    // Implementation for updating collaborator permissions
    console.log('Updating permissions for user:', userId);
}