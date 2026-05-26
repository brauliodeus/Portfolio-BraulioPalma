// assets/js/admin.js

let projectModal;

document.addEventListener('DOMContentLoaded', function() {
    projectModal = new bootstrap.Modal(document.getElementById('projectModal'));
    loadProjects();
});

// Cargar proyectos mediante AJAX
function loadProjects() {
    const tbody = document.getElementById('projectsTableBody');
    tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4"><span class="spinner-border spinner-border-sm"></span> Cargando...</td></tr>';

    fetch('api/projects_api.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                renderProjectsTable(data.data);
            } else {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-danger">${data.message}</td></tr>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            tbody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-danger">Error al cargar los proyectos.</td></tr>`;
        });
}

// Renderizar la tabla de proyectos
function renderProjectsTable(projects) {
    const tbody = document.getElementById('projectsTableBody');
    tbody.innerHTML = '';

    if (projects.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-muted">No hay proyectos registrados.</td></tr>';
        return;
    }

    projects.forEach(project => {
        const desc = project.description.length > 80 ? project.description.substring(0, 80) + '...' : project.description;
        const isLocked = project.is_locked == 1 || project.is_locked === true;
        const lockIcon = isLocked ? 'bi-lock-fill' : 'bi-unlock';
        const lockClass = isLocked ? 'btn-outline-warning' : 'btn-outline-secondary';
        
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="px-4 py-3">
                <img src="${project.image_url}" alt="${project.title}" class="project-thumbnail">
            </td>
            <td class="px-4 py-3 fw-medium">${project.title}</td>
            <td class="px-4 py-3 text-muted small">${desc}</td>
            <td class="px-4 py-3 text-end">
                <button class="btn btn-sm ${lockClass} me-1" onclick="toggleLock(${project.id}, ${isLocked ? 0 : 1})" title="${isLocked ? 'Desbloquear' : 'Bloquear'}">
                    <i class="bi ${lockIcon}"></i>
                </button>
                <button class="btn btn-sm btn-outline-primary me-1" onclick="editProject(${project.id}, ${isLocked})">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="deleteProject(${project.id}, ${isLocked})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

// Abrir modal para crear proyecto
function openProjectModal() {
    document.getElementById('projectForm').reset();
    document.getElementById('projectId').value = '';
    document.getElementById('projectModalTitle').innerText = 'Nuevo Proyecto';
    projectModal.show();
}

// Editar proyecto (cargar datos en el modal)
function editProject(id, isLocked = false) {
    if (isLocked) {
        Swal.fire('Proyecto Bloqueado', 'Por favor, desbloquea el proyecto antes de editarlo.', 'warning');
        return;
    }
    fetch(`api/projects_api.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const p = data.data;
                document.getElementById('projectId').value = p.id;
                document.getElementById('projectTitle').value = p.title;
                document.getElementById('projectImage').value = p.image_url;
                document.getElementById('projectDescription').value = p.description;
                document.getElementById('projectDemo').value = p.demo_link || '';
                document.getElementById('projectRepo').value = p.repo_link || '';
                
                document.getElementById('projectModalTitle').innerText = 'Editar Proyecto';
                projectModal.show();
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => console.error('Error:', error));
}

// Guardar (Crear/Actualizar) Proyecto
function saveProject() {
    const id = document.getElementById('projectId').value;
    const isEditing = id !== '';
    
    const formData = {
        title: document.getElementById('projectTitle').value,
        image_url: document.getElementById('projectImage').value,
        description: document.getElementById('projectDescription').value,
        demo_link: document.getElementById('projectDemo').value,
        repo_link: document.getElementById('projectRepo').value
    };

    if(!formData.title || !formData.image_url || !formData.description) {
        Swal.fire('Atención', 'Por favor, completa los campos obligatorios.', 'warning');
        return;
    }

    if (isEditing) {
        formData.id = id;
        formData._method = 'PUT';
    }

    const method = 'POST'; // Siempre usamos POST por compatibilidad (Method Spoofing)
    const btn = document.getElementById('saveProjectBtn');
    const originalText = btn.innerText;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Guardando...';

    fetch('api/projects_api.php', {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            });
            projectModal.hide();
            loadProjects(); // Recargar la tabla asíncronamente
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'No se pudo contactar con el servidor.', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerText = originalText;
    });
}

// Eliminar proyecto
function deleteProject(id, isLocked = false) {
    if (isLocked) {
        Swal.fire('Proyecto Bloqueado', 'Por favor, desbloquea el proyecto antes de eliminarlo.', 'warning');
        return;
    }
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`api/projects_api.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ _method: 'DELETE', id: id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Eliminado',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    loadProjects(); // Recargar la tabla
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'No se pudo contactar con el servidor.', 'error');
            });
        }
    });
}

// Alternar bloqueo de proyecto
function toggleLock(id, newStatus) {
    fetch('api/projects_api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ _method: 'PATCH', id: id, is_locked: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            loadProjects(); // Recargar la tabla para mostrar el nuevo estado
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'No se pudo contactar con el servidor.', 'error');
    });
}

// Cambiar de pestaña
function switchTab(tab) {
    // Actualizar estilos del menú
    document.getElementById('tab-projects').classList.remove('active');
    document.getElementById('tab-messages').classList.remove('active');
    document.getElementById(`tab-${tab}`).classList.add('active');

    // Ocultar todas las secciones
    document.getElementById('section-projects').style.display = 'none';
    document.getElementById('section-messages').style.display = 'none';

    // Mostrar sección actual
    document.getElementById(`section-${tab}`).style.display = 'block';

    if (tab === 'messages') {
        loadMessages();
    } else if (tab === 'projects') {
        loadProjects();
    }
}

// Cargar mensajes mediante AJAX
function loadMessages() {
    const tbody = document.getElementById('messagesTableBody');
    tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4"><span class="spinner-border spinner-border-sm"></span> Cargando...</td></tr>';

    fetch('api/messages_api.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                renderMessagesTable(data.data);
            } else {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-danger">${data.message}</td></tr>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            tbody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-danger">Error al cargar los mensajes.</td></tr>`;
        });
}

// Renderizar la tabla de mensajes
function renderMessagesTable(messages) {
    const tbody = document.getElementById('messagesTableBody');
    tbody.innerHTML = '';

    if (messages.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-muted">No hay mensajes.</td></tr>';
        return;
    }

    messages.forEach(msg => {
        const date = new Date(msg.created_at).toLocaleString('es-ES');
        
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="px-4 py-3 small text-muted">${date}</td>
            <td class="px-4 py-3 fw-medium">${msg.name}</td>
            <td class="px-4 py-3"><a href="mailto:${msg.email}" class="text-decoration-none">${msg.email}</a></td>
            <td class="px-4 py-3">
                <strong>${msg.subject}</strong><br>
                <span class="text-muted small">${msg.message}</span>
            </td>
        `;
        tbody.appendChild(tr);
    });
}
