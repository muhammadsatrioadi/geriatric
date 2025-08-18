/**
 * Video Form Validation and Field Toggling
 * Digunakan untuk form create dan edit video di Admin dan SuperAdmin
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get form elements
    const form = document.querySelector('form');
    const jenisSelect = document.querySelector('select[name="jenis"]');
    const categoryTypeSelect = document.querySelector('select[name="category_type"]');
    const testTypeGroup = document.getElementById('test-type-group');
    const klasifikasiGroup = document.getElementById('klasifikasi-group');
    const pasienGroup = document.getElementById('pasien-group');
    const klasifikasiSelect = document.querySelector('select[name="klasifikasi"]');
    const pasienSelect = document.querySelector('select[name="pasien_id"]');
    const testTypeSelect = document.querySelector('select[name="test_type"]');
    const videoFileInput = document.getElementById('video_file');
    const videoPreview = document.getElementById('video-preview');

    // Check if elements exist before proceeding
    if (!form || !jenisSelect || !categoryTypeSelect) {
        console.warn('Video form elements not found');
        return;
    }

    /**
     * Toggle form fields based on selected options
     */
    function toggleFields() {
        const selectedJenis = jenisSelect.value;
        const selectedCategoryType = categoryTypeSelect.value;

        // Toggle test type group for per_test and self_assessment
        if (selectedCategoryType === 'per_test' || selectedCategoryType === 'self_assessment') {
            if (testTypeGroup) {
                testTypeGroup.style.display = 'block';
                if (testTypeSelect) {
                    testTypeSelect.required = true;
                }
            }
        } else {
            if (testTypeGroup) {
                testTypeGroup.style.display = 'none';
                if (testTypeSelect) {
                    testTypeSelect.required = false;
                    testTypeSelect.value = '';
                }
            }
        }

        // Toggle klasifikasi and pasien groups
        if (selectedJenis === 'global') {
            if (klasifikasiGroup) {
                klasifikasiGroup.style.display = 'block';
                if (klasifikasiSelect) {
                    klasifikasiSelect.required = true;
                }
            }
            if (pasienGroup) {
                pasienGroup.style.display = 'none';
                if (pasienSelect) {
                    pasienSelect.required = false;
                    pasienSelect.value = '';
                }
            }
        } else if (selectedJenis === 'khusus') {
            if (klasifikasiGroup) {
                klasifikasiGroup.style.display = 'none';
                if (klasifikasiSelect) {
                    klasifikasiSelect.required = false;
                    klasifikasiSelect.value = '';
                }
            }
            if (pasienGroup) {
                pasienGroup.style.display = 'block';
                if (pasienSelect) {
                    pasienSelect.required = true;
                }
            }
        } else {
            if (klasifikasiGroup) {
                klasifikasiGroup.style.display = 'none';
                if (klasifikasiSelect) {
                    klasifikasiSelect.required = false;
                }
            }
            if (pasienGroup) {
                pasienGroup.style.display = 'none';
                if (pasienSelect) {
                    pasienSelect.required = false;
                }
            }
        }
    }

    /**
     * Form validation before submit
     */
    function validateForm(e) {
        const selectedJenis = jenisSelect.value;
        const selectedCategoryType = categoryTypeSelect.value;
        let isValid = true;
        let errorMessage = '';

        // Validate test_type for per_test and self_assessment
        if ((selectedCategoryType === 'per_test' || selectedCategoryType === 'self_assessment')) {
            if (testTypeSelect && !testTypeSelect.value) {
                isValid = false;
                errorMessage = 'Jenis Tes harus dipilih untuk kategori ini.';
                if (testTypeSelect) {
                    testTypeSelect.focus();
                }
            }
        }

        // Validate klasifikasi for global videos
        if (selectedJenis === 'global' && klasifikasiSelect && !klasifikasiSelect.value) {
            isValid = false;
            errorMessage = 'Klasifikasi harus dipilih untuk video global.';
            if (klasifikasiSelect) {
                klasifikasiSelect.focus();
            }
        }

        // Validate pasien_id for khusus videos
        if (selectedJenis === 'khusus' && pasienSelect && !pasienSelect.value) {
            isValid = false;
            errorMessage = 'Pasien harus dipilih untuk video khusus.';
            if (pasienSelect) {
                pasienSelect.focus();
            }
        }

        if (!isValid) {
            e.preventDefault();
            alert(errorMessage);
            return false;
        }

        return true;
    }

    /**
     * Video file validation and preview
     */
    function handleVideoFileChange(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Validate file type
            const allowedTypes = ['video/mp4', 'video/avi', 'video/mov', 'video/wmv'];
            if (!allowedTypes.includes(file.type)) {
                alert('Format file tidak didukung. Gunakan MP4, AVI, MOV, atau WMV.');
                e.target.value = '';
                if (videoPreview) {
                    videoPreview.innerHTML = '<p class="text-center text-muted">Silahkan upload video terlebih dahulu</p>';
                }
                return;
            }

            // Validate file size (200MB = 200 * 1024 * 1024 bytes)
            const maxSize = 200 * 1024 * 1024;
            if (file.size > maxSize) {
                alert('Ukuran file terlalu besar. Maksimal 200MB.');
                e.target.value = '';
                if (videoPreview) {
                    videoPreview.innerHTML = '<p class="text-center text-muted">Silahkan upload video terlebih dahulu</p>';
                }
                return;
            }

            // Show video preview
            if (videoPreview) {
                const url = URL.createObjectURL(file);
                videoPreview.innerHTML = `
                    <div class="border rounded p-2">
                        <video class="w-100" controls>
                            <source src="${url}" type="${file.type}">
                            Browser Anda tidak mendukung video.
                        </video>
                        <div class="mt-2 text-center">
                            <small class="text-muted">
                                <strong>${file.name}</strong><br>
                                Ukuran: ${(file.size / 1024 / 1024).toFixed(2)} MB
                            </small>
                        </div>
                    </div>
                `;
            }
        } else {
            if (videoPreview) {
                videoPreview.innerHTML = '<p class="text-center text-muted">Silahkan upload video terlebih dahulu</p>';
            }
        }
    }

    // Add event listeners
    if (jenisSelect) {
        jenisSelect.addEventListener('change', toggleFields);
    }
    
    if (categoryTypeSelect) {
        categoryTypeSelect.addEventListener('change', toggleFields);
    }

    if (form) {
        form.addEventListener('submit', validateForm);
    }

    if (videoFileInput) {
        videoFileInput.addEventListener('change', handleVideoFileChange);
    }

    // Initialize on page load
    toggleFields();
});

/**
 * Video Index Filtering
 * Digunakan untuk halaman index video di Admin dan SuperAdmin
 */
function initializeVideoFilters() {
    const categoryFilter = document.getElementById('categoryFilter');
    const testTypeFilter = document.getElementById('testTypeFilter');
    const levelFilter = document.getElementById('levelFilter');
    const statusFilter = document.getElementById('statusFilter');
    const tableRows = document.querySelectorAll('tbody tr');

    if (!categoryFilter || !tableRows.length) {
        return;
    }

    /**
     * Apply filters to table rows
     */
    function applyFilters() {
        const selectedCategory = categoryFilter.value;
        const selectedTestType = testTypeFilter ? testTypeFilter.value : '';
        const selectedLevel = levelFilter ? levelFilter.value : '';
        const selectedStatus = statusFilter ? statusFilter.value : '';

        tableRows.forEach(row => {
            let showRow = true;

            // Filter by category
            if (selectedCategory) {
                const categoryCell = row.querySelector('td:nth-child(4) .badge');
                if (categoryCell && !categoryCell.textContent.toLowerCase().includes(selectedCategory.replace('_', ' '))) {
                    showRow = false;
                }
            }

            // Filter by test type
            if (selectedTestType) {
                const testTypeCell = row.querySelector('td:nth-child(5) .badge');
                if (testTypeCell && !testTypeCell.textContent.toLowerCase().includes(selectedTestType.replace('_', ' '))) {
                    showRow = false;
                }
            }

            // Filter by level
            if (selectedLevel) {
                const levelCell = row.querySelector('td:nth-child(6) .badge');
                if (levelCell && !levelCell.textContent.toLowerCase().includes(selectedLevel)) {
                    showRow = false;
                }
            }

            // Filter by status
            if (selectedStatus !== '') {
                const statusCell = row.querySelector('td:nth-child(10) .badge');
                if (statusCell) {
                    const isActive = statusCell.textContent.toLowerCase().includes('aktif');
                    if ((selectedStatus === '1' && !isActive) || (selectedStatus === '0' && isActive)) {
                        showRow = false;
                    }
                }
            }

            // Show/hide row
            row.style.display = showRow ? '' : 'none';
        });

        // Update row numbers
        updateRowNumbers();
    }

    /**
     * Update row numbers after filtering
     */
    function updateRowNumbers() {
        let visibleRowCount = 0;
        tableRows.forEach(row => {
            if (row.style.display !== 'none') {
                visibleRowCount++;
                const numberCell = row.querySelector('td:first-child');
                if (numberCell) {
                    numberCell.textContent = visibleRowCount;
                }
            }
        });
    }

    // Add event listeners to filters
    categoryFilter.addEventListener('change', applyFilters);
    
    if (testTypeFilter) {
        testTypeFilter.addEventListener('change', applyFilters);
    }
    
    if (levelFilter) {
        levelFilter.addEventListener('change', applyFilters);
    }
    
    if (statusFilter) {
        statusFilter.addEventListener('change', applyFilters);
    }

    // Initialize filters
    applyFilters();
}

// Initialize filters when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeVideoFilters();
});
