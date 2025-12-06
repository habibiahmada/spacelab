// Classroom Management JavaScript

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function () {
    const alerts = ['successAlert', 'errorAlert', 'validationAlert'];
    alerts.forEach(alertId => {
        const alert = document.getElementById(alertId);
        if (alert) {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        }
    });
});

// Toggle classrooms section
function toggleClassrooms(majorId) {
    const classroomsSection = document.getElementById(`classrooms-${majorId}`);
    const chevron = document.getElementById(`chevron-${majorId}`);

    if (classroomsSection.classList.contains('hidden')) {
        classroomsSection.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
    } else {
        classroomsSection.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
    }
}

// Open classroom modal for adding
function openClassroomModal(majorId = null) {
    const modal = document.querySelector('[x-data]');
    const form = document.getElementById('classroomForm');
    const modalTitle = document.getElementById('classroomModalTitle');
    const method = document.getElementById('classroomMethod');
    const classroomId = document.getElementById('classroomId');

    // Reset form
    form.reset();
    form.action = window.classroomRoutes.store;
    method.value = 'POST';
    classroomId.value = '';
    modalTitle.textContent = 'Tambah Kelas';

    // Pre-select major if provided
    if (majorId) {
        document.getElementById('classroomMajorId').value = majorId;
    }

    // Open modal
    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'classroomModal' }));
}

// Edit classroom
async function editClassroom(id) {
    try {
        const response = await fetch(`${window.classroomRoutes.base}/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error('Failed to fetch classroom data');
        }

        const classroom = await response.json();

        // Populate form
        const form = document.getElementById('classroomForm');
        const modalTitle = document.getElementById('classroomModalTitle');
        const method = document.getElementById('classroomMethod');
        const classroomId = document.getElementById('classroomId');

        form.action = `${window.classroomRoutes.base}/${id}`;
        method.value = 'PUT';
        classroomId.value = id;
        modalTitle.textContent = 'Edit Kelas';

        document.getElementById('classroomMajorId').value = classroom.major_id;
        document.getElementById('classroomLevel').value = classroom.level;
        document.getElementById('classroomRombel').value = classroom.rombel;

        // Open modal
        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'classroomModal' }));
    } catch (error) {
        console.error('Error fetching classroom:', error);
        alert('Gagal mengambil data kelas. Silakan coba lagi.');
    }
}

// Delete classroom
function deleteClassroom(id) {
    if (confirm('Apakah Anda yakin ingin menghapus kelas ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `${window.classroomRoutes.base}/${id}`;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (csrfToken) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
        }

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
    }
}
