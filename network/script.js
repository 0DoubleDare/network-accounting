// Данные и режим
let networkPoints = [];
let editModeId = null;

// DOM элементы
const nameInput = document.getElementById('pointName');
const ipInput = document.getElementById('pointIp');
const portInput = document.getElementById('pointPort');
const descInput = document.getElementById('pointDesc');
const saveBtn = document.getElementById('saveBtn');
const cancelBtn = document.getElementById('cancelBtn');
const formErrorDiv = document.getElementById('formError');
const tableBody = document.getElementById('tableBody');

// === Валидация ===
function isValidIPv4(ip) {
    const regex = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
    return regex.test(ip);
}

function isValidPort(port) {
    if (port === '') return true;
    const num = Number(port);
    return Number.isInteger(num) && num >= 1 && num <= 65535;
}

function validateForm() {
    const name = nameInput.value.trim();
    const ip = ipInput.value.trim();
    const portRaw = portInput.value.trim();

    if (!name) {
        formErrorDiv.innerText = 'Ошибка: название обязательно.';
        return false;
    }
    if (!ip) {
        formErrorDiv.innerText = 'Ошибка: IP-адрес обязателен.';
        return false;
    }
    if (!isValidIPv4(ip)) {
        formErrorDiv.innerText = 'Ошибка: некорректный IPv4 (пример: 192.168.0.1).';
        return false;
    }
    if (portRaw !== '' && !isValidPort(portRaw)) {
        formErrorDiv.innerText = 'Ошибка: порт должен быть от 1 до 65535.';
        return false;
    }
    formErrorDiv.innerText = '';
    return true;
}

// === Работа с localStorage ===
function loadFromStorage() {
    const stored = localStorage.getItem('networkPoints');
    if (stored) {
        try {
            networkPoints = JSON.parse(stored);
            if (!Array.isArray(networkPoints)) networkPoints = [];
        } catch(e) {
            networkPoints = [];
        }
    } else {
        // Демо-данные
        networkPoints = [
            { id: Date.now() + 1, name: 'Главный роутер', ip: '192.168.1.1', port: 443, description: 'Центральный шлюз' },
            { id: Date.now() + 2, name: 'Точка доступа 2F', ip: '10.0.0.5', port: 8080, description: 'Этаж 2' }
        ];
    }
    renderTable();
}

function saveToStorage() {
    localStorage.setItem('networkPoints', JSON.stringify(networkPoints));
    renderTable(); 
}

// === Форма: сброс, заполнение, сохранение ===
function resetForm() {
    nameInput.value = '';
    ipInput.value = '';
    portInput.value = '';
    descInput.value = '';
    editModeId = null;
    saveBtn.innerHTML = 'Сохранить (добавить)';
    formErrorDiv.innerText = '';
    console.log('Форма сброшена, editModeId =', editModeId);
}

function fillFormForEdit(point) {
    nameInput.value = point.name;
    ipInput.value = point.ip;
    portInput.value = (point.port !== undefined && point.port !== null) ? point.port : '';
    descInput.value = point.description || '';
    editModeId = point.id;
    saveBtn.innerHTML = 'Обновить точку';
    formErrorDiv.innerText = '';
    console.log('Режим редактирования, id =', editModeId);
}

function handleSave() {
    if (!validateForm()) return;

    const name = nameInput.value.trim();
    const ip = ipInput.value.trim();
    const portRaw = portInput.value.trim();
    const port = portRaw === '' ? null : Number(portRaw);
    const description = descInput.value.trim();

    if (editModeId !== null) {
        // === РЕДАКТИРОВАНИЕ ===
        const index = networkPoints.findIndex(p => p.id === editModeId);
        if (index !== -1) {
            networkPoints[index] = { ...networkPoints[index], name, ip, port, description };
            saveToStorage();
            resetForm();
            console.log('Точка обновлена, id =', editModeId);
        } else {
            formErrorDiv.innerText = 'Ошибка: точка не найдена (возможно, была удалена).';
            resetForm();
        }
    } else {
        // === ДОБАВЛЕНИЕ ===
        const newId = Date.now();
        networkPoints.push({ id: newId, name, ip, port, description });
        saveToStorage();
        resetForm();
        console.log('Добавлена новая точка, id =', newId);
    }
}

// === Удаление ===
function deletePoint(id) {
    if (confirm('Удалить сетевую точку?')) {
        networkPoints = networkPoints.filter(p => p.id !== id);
        if (editModeId === id) resetForm();
        saveToStorage();
        console.log('Удалена точка с id =', id);
    }
}


function editPoint(id) {
    console.log('editPoint вызван для id =', id);
    const point = networkPoints.find(p => p.id === id);
    if (point) {
        fillFormForEdit(point);
        document.querySelector('.form-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        console.error('Точка с id', id, 'не найдена в массиве');
        formErrorDiv.innerText = 'Ошибка: точка не найдена.';
    }
}


function renderTable() {
    if (!tableBody) return;

    if (networkPoints.length === 0) {
        tableBody.innerHTML = '<tr class="empty-row"><td colspan="5">Нет добавленных точек. Будьте первыми!</td></tr>';
        return;
    }

    let html = '';
    for (const p of networkPoints) {
        const portDisplay = (p.port !== null && p.port !== undefined) ? p.port : '—';
        const descShort = p.description ? (p.description.length > 40 ? p.description.substring(0, 37) + '...' : p.description) : '—';
        html += `
            <tr>
                <td><strong>${escapeHtml(p.name)}</strong></td>
                <td><span class="badge">${escapeHtml(p.ip)}</span></td>
                <td>${portDisplay}</td>
                <td>${escapeHtml(descShort)}</td>
                <td class="actions">
                    <button class="edit-btn" data-id="${p.id}">Изменить</button>
                    <button class="delete-btn" data-id="${p.id}">Удалить</button>
                </td>
            </tr>
        `;
    }
    tableBody.innerHTML = html;
}


document.getElementById('pointsTable').addEventListener('click', (e) => {
    const target = e.target;
    // Кнопка "Изменить"
    if (target.classList.contains('edit-btn')) {
        const id = parseInt(target.getAttribute('data-id'));
        if (!isNaN(id)) editPoint(id);
    }
    // Кнопка "Удалить"
    else if (target.classList.contains('delete-btn')) {
        const id = parseInt(target.getAttribute('data-id'));
        if (!isNaN(id)) deletePoint(id);
    }
});

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// === Обработчики главных кнопок ===
saveBtn.addEventListener('click', handleSave);
cancelBtn.addEventListener('click', resetForm);

// === Загрузка данных при старте ===
loadFromStorage();