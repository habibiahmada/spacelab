// Auto-dismiss alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function () {
    const successAlert = document.getElementById('successAlert');
    const errorAlert = document.getElementById('errorAlert');
    const validationAlert = document.getElementById('validationAlert');

    if (successAlert) {
        setTimeout(() => {
            successAlert.style.transition = 'opacity 0.5s';
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 500);
        }, 5000);
    }

    if (errorAlert) {
        setTimeout(() => {
            errorAlert.style.transition = 'opacity 0.5s';
            errorAlert.style.opacity = '0';
            setTimeout(() => errorAlert.remove(), 500);
        }, 5000);
    }
});

// Term Modal Functions
function openTermModal() {
    resetTermModal();
    document.getElementById('termModal').classList.remove('hidden');
}

function closeTermModal() {
    document.getElementById('termModal').classList.add('hidden');
    resetTermModal();
}

function resetTermModal() {
    document.getElementById('termForm').reset();
    document.getElementById('termForm').action = window.termRoutes.store;
    document.getElementById('termMethod').value = 'POST';
    document.getElementById('termId').value = '';
    document.getElementById('termModalTitle').textContent = 'Tambah Tahun Ajaran';
    document.getElementById('termSubmitBtn').textContent = 'Simpan';
}

function editTerm(termId) {
    // Fetch term data
    fetch(`${window.termRoutes.base}/${termId}/edit`)
        .then(response => response.json())
        .then(data => {
            // Populate form
            document.getElementById('termId').value = data.id;
            document.getElementById('termTahunAjaran').value = data.tahun_ajaran;
            document.getElementById('termStartDate').value = data.start_date;
            document.getElementById('termEndDate').value = data.end_date;
            document.getElementById('termKind').value = data.kind;
            document.getElementById('is_active').checked = data.is_active;

            // Update form for editing
            document.getElementById('termForm').action = `${window.termRoutes.base}/${termId}`;
            document.getElementById('termMethod').value = 'PUT';
            document.getElementById('termModalTitle').textContent = 'Edit Tahun Ajaran';
            document.getElementById('termSubmitBtn').textContent = 'Update';

            // Open modal
            document.getElementById('termModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat data tahun ajaran');
        });
}

function deleteTerm(termId) {
    if (confirm('Apakah Anda yakin ingin menghapus tahun ajaran ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `${window.termRoutes.base}/${termId}`;
        form.innerHTML = window.csrfToken + '<input type="hidden" name="_method" value="DELETE">';
        document.body.appendChild(form);
        form.submit();
    }
}

// Block Modal Functions
function openBlockModal(termId) {
    resetBlockModal();
    document.getElementById('block_terms_id').value = termId;
    document.getElementById('blockModal').classList.remove('hidden');
}

function closeBlockModal() {
    document.getElementById('blockModal').classList.add('hidden');
    resetBlockModal();
}

function resetBlockModal() {
    document.getElementById('blockForm').reset();
    document.getElementById('blockForm').action = window.blockRoutes.store;
    document.getElementById('blockMethod').value = 'POST';
    document.getElementById('blockId').value = '';
    document.getElementById('blockModalTitle').textContent = 'Tambah Block';
}

function editBlock(blockId) {
    // Fetch block data
    fetch(`${window.blockRoutes.base}/${blockId}/edit`)
        .then(response => response.json())
        .then(data => {
            // Populate form
            document.getElementById('blockId').value = data.id;
            document.getElementById('block_terms_id').value = data.terms_id;
            document.getElementById('blockName').value = data.name;
            document.getElementById('blockStartDate').value = data.start_date;
            document.getElementById('blockEndDate').value = data.end_date;

            // Update form for editing
            document.getElementById('blockForm').action = `${window.blockRoutes.base}/${blockId}`;
            document.getElementById('blockMethod').value = 'PUT';
            document.getElementById('blockModalTitle').textContent = 'Edit Block';

            // Open modal
            document.getElementById('blockModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat data block');
        });
}

function deleteBlock(blockId) {
    if (confirm('Apakah Anda yakin ingin menghapus block ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `${window.blockRoutes.base}/${blockId}`;
        form.innerHTML = window.csrfToken + '<input type="hidden" name="_method" value="DELETE">';
        document.body.appendChild(form);
        form.submit();
    }
}

function toggleBlocks(termId) {
    const blocksDiv = document.getElementById('blocks-' + termId);
    const chevron = document.getElementById('chevron-' + termId);
    blocksDiv.classList.toggle('hidden');
    chevron.classList.toggle('rotate-180');
}
