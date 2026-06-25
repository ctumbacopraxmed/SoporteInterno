$(document).ready(function () {
    initView();
    bindButtonClick('.btn-create', createServer);
    $('.ip_address').on('input', function () {
        let value = $(this).val();
        // Solo números y puntos
        value = value.replace(/[^0-9.]/g, '');
        // Evitar puntos consecutivos
        value = value.replace(/\.{2,}/g, '.');
        // Máximo 4 bloques
        let parts = value.split('.');
        if (parts.length > 4) {
            parts = parts.slice(0, 4);
        }
        // Cada bloque entre 0 y 255
        parts = parts.map(function (part) {
            if (part !== '') {
                let num = parseInt(part, 10);
                if (num > 255) {
                    return '255';
                }
                return num.toString();
            }
            return part;
        });
        $(this).val(parts.join('.'));
    });

});
function initView() {
    fetchStats();
    fetcheList();
}
function fetchStats() {
    sendAjax({
        endpoint: '/Servidores/stats',
        beforeSend: function () {
            loadingStats('stats');
        },
        onSuccess: (data) => {
            setTimeout(() => {
                if (data.success) {
                    buildStats(data.data);
                    lucide.createIcons();
                } else {
                    Notify(2, data.message);
                }
            }, 1200);
        }
    });
}
function fetcheList() {
    sendAjax({
        endpoint: '/Servidores/list',
        beforeSend: function () {
            loadingTable('list');
        },
        onSuccess: (data) => {
            setTimeout(() => {
                if (data.success) {
                    buildTable(data.data);
                    lucide.createIcons();
                    setTimeout(refreshServers, 10000);
                } else {
                    Notify(2, data.message);
                }
            }, 1200);
        }
    });
}
function buildTable(data) {
    let rows = '';
    data.forEach(item => {
        rows += `
            <tr class="invoice-row hover:bg-gray-50" data-server-id="${item.id}">
                <td class="p-4 text-sm text-gray-800">${item.name}</td>
                <td class="p-4 text-sm text-gray-800">${item.ip_address}</td>
                <td class="p-4 text-sm text-gray-800">${item.operating_system}</td>
                <td class="p-4 text-sm text-gray-800">${renderEnviroment(item.environment)}</td>
                <td class="p-4 text-sm text-gray-800 status" data-sort="${item.status}">${renderEstadoBadge(item.status)}</td>
                <td class="p-4 text-sm text-gray-800 font-bold latency" data-sort="${item.latency_ms || '-'}">${item.latency_ms || '-'} ms</td>
                <td class="p-4 text-sm text-gray-800" data-sort="${item.last_revision}">
                <div class="time_revition">Hace ${item.time_revition || ''}</div>
                <div class="text-gray-400 last_revision">${item.last_revision || ''}</div>
                </td>
                <td class="p-4 text-sm flex justify-center">
                    <a href="${(ruta_web + '/Servidores/' + item.id)}" title="Servicios" class="text-gray-600 hover:text-gray-800">
                        <i data-lucide="MonitorCog" class="w-7 h-7 cursor-pointer"></i>
                    </a>
                </td>
            </tr>
        `;
    });
    const html = `
    <div class="shadow-lg rounded-xl bg-white p-4">
        <div class="flex items-center justify-between select-none mb-3">
            <div class="font-bold text-xl">Listado de servidores</div>
            <div class="flex justify-end">
                <button id="btnOpenModal"
                    class="flex items-center gap-2 bg-blue-500 text-white hover:bg-blue-600 rounded-xl px-4 py-2 transition-colors text-sm cursor-pointer">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    <span>Agregar Servidor</span>
                </button>
            </div>
        </div>
        <div class="relative w-64 mb-3">
            <i data-lucide="search"
            class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400">
            </i>
            <input id="tableSearch" type="text" placeholder="Buscar servidor..." class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="overflow-x-auto mt-3">
            <table class="w-full" id="table">
                <thead class="bg-gray-50 select-none">
                    <tr>
                        <th class="sortable text-left p-4 font-bold text-gray-700">
                            <div class="flex items-center gap-1">
                                <span>Servidor</span>
                                <i data-lucide="arrow-up-down" class="sort-icon w-4 h-4"></i>
                            </div>
                        </th>
                        <th class="sortable text-left p-4 font-bold text-gray-700">
                            <div class="flex items-center gap-1">
                                <span>IP / Hostname</span>
                                <i data-lucide="arrow-up-down" class="sort-icon w-4 h-4"></i>
                            </div>
                        </th>
                        <th class="sortable text-left p-4 font-bold text-gray-700">
                            <div class="flex items-center gap-1">
                                <span>Sistema Operativo</span>
                                <i data-lucide="arrow-up-down" class="sort-icon w-4 h-4"></i>
                            </div>
                        </th>
                        <th class="sortable text-left p-4 font-bold text-gray-700">
                            <div class="flex items-center gap-1">
                                <span>Entorno</span>
                                <i data-lucide="arrow-up-down" class="sort-icon w-4 h-4"></i>
                            </div>
                        </th>
                        <th class="sortable text-left p-4 font-bold text-gray-700">
                            <div class="flex items-center gap-1">
                                <span>Estado</span>
                                <i data-lucide="arrow-up-down" class="sort-icon w-4 h-4"></i>
                            </div>
                        </th>
                        <th class="sortable text-left p-4 font-bold text-gray-700">
                            <div class="flex items-center gap-1">
                                <span>Latencia</span>
                                <i data-lucide="arrow-up-down" class="sort-icon w-4 h-4"></i>
                            </div>
                        </th>
                        <th class="sortable text-left p-4 font-bold text-gray-700">
                            <div class="flex items-center gap-1">
                                <span>Última Rev.</span>
                                <i data-lucide="arrow-up-down" class="sort-icon w-4 h-4"></i>
                            </div>
                        </th>
                        <th class="text-left p-4 font-bold text-gray-700 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 ">
                    ${rows}
                </tbody>
            </table>
        </div>
    </div>`;
    $('#list').html(html);
    initTableSearch();
    initTableSorting();
}
function refreshServers() {
    sendAjax({
        endpoint: '/Servidores/status',
        onSuccess: (data) => {
            if (data.success) {
                updateServerStatus(data.data.status);
                updateServerStats(data.data.stats);
                lucide.createIcons();
            }
        },
        onComplete: function () {
            setTimeout(refreshServers, 120000);
        }
    });
}
function updateServerStatus(data) {
    data.forEach(server => {
        const row = $(`tr[data-server-id="${server.id}"]`);
        if (!row.length) return;
        row.find('.status').html(
            renderEstadoBadge(server.status)
        );
        row.find('.latency').text(
            `${server.latency_ms || '-'} ms`
        );
        row.find('.time_revition').text(
            `Hace ${server.time_revition || '-'}`
        );
        row.find('.last_revision').text(
            `${server.last_revision || ''}`
        );
    });
}
function updateServerStats(data) {
    $('.servers_quantity').text(data.servers_quantity);
    $('.server_online').text(data.server_online);
    $('.server_offline').text(data.server_offline);
    $('.server_latency').text(data.server_latency);
}
function buildStats(data) {
    let html = `<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 select-none">
    <div class="bg-white  rounded-2xl p-6 shadow-premium border border-gray-200  hover-lift">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600  text-sm font-medium font-body">Servidores</p>
                <p class="text-3xl font-bold text-gray-800  mt-1 font-display servers_quantity">${data.servers_quantity}</p>
                <p class="text-blue-600  text-sm mt-2 font-body">Total de Servidores</p>
            </div>
            <div class="w-12 h-12 bg-blue-100  rounded-xl flex items-center justify-center">
                <i data-lucide="Server" class="w-6 h-6 text-blue-600 "></i>
            </div>
        </div>
    </div>
    <div class="bg-white  rounded-2xl p-6 shadow-premium border border-gray-200  hover-lift">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600  text-sm font-medium font-body">En Linea</p>
                <p class="text-3xl font-bold text-gray-800  mt-1 font-display server_online">${data.server_online}</p>
                <p class="text-green-600  text-sm mt-2 font-body">Sin novedades</p>
            </div>
            <div class="w-12 h-12 bg-green-100  rounded-xl flex items-center justify-center">
                <i data-lucide="CircleCheck" class="w-6 h-6 text-green-600 "></i>
            </div>
        </div>
    </div>

    <div class="bg-white  rounded-2xl p-6 shadow-premium border border-gray-200  hover-lift">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600  text-sm font-medium font-body">Advertencia</p>
                <p class="text-3xl font-bold text-gray-800  mt-1 font-display server_latency">${data.server_latency}</p>
                <p class="text-orange-600  text-sm mt-2 font-body">Lentitud detectada</p>
            </div>
            <div class="w-12 h-12 bg-orange-100  rounded-xl flex items-center justify-center">
                <i data-lucide="clock" class="w-6 h-6 text-orange-600 "></i>
            </div>
        </div>
    </div>
    <div class="bg-white  rounded-2xl p-6 shadow-premium border border-gray-200  hover-lift">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600  text-sm font-medium font-body">Fuera de Linea</p>
                <p class="text-3xl font-bold text-gray-800  mt-1 font-display server_offline">${data.server_offline}</p>
                <p class="text-red-600  text-sm mt-2 font-body">Revisar Servidores</p>
            </div>
            <div class="w-12 h-12 bg-red-100  rounded-xl flex items-center justify-center">
                <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600 "></i>
            </div>
        </div>
    </div>
</div>`;
    $('#stats').empty().html(html);
}
function renderEstadoBadge(estado) {
    const estilos = {
        online: {
            texto: 'En Línea',
            clases: 'bg-green-100 text-green-800 font-semibold',
            punto: 'bg-green-500'
        },
        warning: {
            texto: 'Advertencia',
            clases: 'bg-yellow-100 text-yellow-800 font-semibold',
            punto: 'bg-yellow-500'
        },
        offline: {
            texto: 'Fuera de Línea',
            clases: 'bg-red-100 text-red-800 font-semibold',
            punto: 'bg-red-500'
        }
    };
    const config = estilos[estado] || {
        texto: 'Desconocido',
        clases: 'bg-gray-100 text-gray-800',
        punto: 'bg-gray-500'
    };
    return `
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium ${config.clases}">
            <span class="w-2 h-2 rounded-full ${config.punto}"></span>
            ${config.texto}
        </span>
    `;
}
function renderEnviroment(environment) {
    const estilos = {
        'Producción': {
            texto: 'Producción',
            clases: 'text-blue-600 font-semibold'
        },
        'Pruebas': {
            texto: 'Pruebas',
            clases: 'text-purple-600 font-semibold',
        }
    };
    const config = estilos[environment] || {
        texto: 'Desconocido',
        clases: 'text-gray-800',
    };
    return `
        <span class="${config.clases}">
            ${config.texto}
        </span>
    `;
}

$(document).on('click', '#btnOpenModal', function () {
    const fields = [
        '#name',
        '#ip_address',
        '#user',
        '#password',
        '#operating_system',
        '#environment',
    ];
    openModal(
        '#serverModal',
        '#serverModalContent',
        fields
    );
});
$(document).on('click', '[data-modal-close]', function () {
    const $modal = $(this).closest('.modal');
    const $content = $modal.find('.modal-content');
    closeModal(
        `#${$modal.attr('id')}`,
        `#${$content.attr('id')}`
    );
});
function createServer() {
    const requiredFields = [
        '#name',
        '#ip_address',
        '#user',
        '#password',
        '#operating_system',
        '#environment',
    ];
    if (!validateRequiredFields(requiredFields)) {
        Notify(2, 'Complete el formulario');
        return;
    }
    const data = {
        name: $('#name').val().trim(),
        ip_address: $('#ip_address').val().trim(),
        user: $('#user').val().trim(),
        password: $('#password').val().trim(),
        operating_system: $('#operating_system').val().trim(),
        environment: $('#environment').val().trim()
    }
    sendAjax({
        endpoint: '/Servidores/create',
        type: 'POST',
        data,
        onSuccess: (data) => {
            if (data.success) {
                Notify(1, data.message);
                closeModal('#serverModal', '#serverModalContent');
                initView();
            } else {
                Notify(2, data.message);
            }
        }
    });
}