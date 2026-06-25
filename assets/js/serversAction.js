$(document).ready(function () {
    bindButtonClick('.btn-createService', createService, 'id');
    bindButtonClick('.btn-createCommand', createCommand, 'id');
});
$(document).on('click', '#btnModalServices', function () {
    openModal(
        '#ModalServices',
        '#ModalServicesContent',
        ['#name', '#description', '#file_log']
    );
});

$(document).on('click', '#btnModalCommands', function () {
    const id = $(this).data('id');
    openModal(
        '#ModalCommands',
        '#ModalCommandsContent',
        ['#namec', '#command']
    );
    $('#servicioId').val(id);
});

$(document).on('click', '[data-modal-close]', function () {
    const $modal = $(this).closest('.modal');
    const $content = $modal.find('.modal-content');
    closeModal(
        `#${$modal.attr('id')}`,
        `#${$content.attr('id')}`
    );
});


function executeCommand(serverId, serviceId, commandId, line) {
    const terminal = document.querySelector('#terminal-' + serviceId + ' pre');
    sendAjax({
        endpoint: '/Commands/execute-command',
        type: 'POST',
        data: { serverId, serviceId, commandId },
        beforeSend: function () {
            terminal.innerHTML += line + "Procesando...\n";
        },
        onSuccess: (data) => {
            if (data.success) {
                Notify(1, data.message);
                terminal.innerHTML += line + data.command + "\n";
                terminal.innerHTML += formatTerminalOutput(data.output) + "\n";
                terminal.innerHTML += line + "\n";
                scrollTerminalToBottom(serviceId);
            } else {
                Notify(2, data.message);
                terminal.innerHTML += line + data.command + "\n";
                terminal.innerHTML += formatTerminalOutput(data.output) + "\n";
                terminal.innerHTML += line + "\n";
                scrollTerminalToBottom(serviceId);
            }
        }
    });
}
function executeCommandLogs(serverId, serviceId, line) {
    const terminal = document.querySelector('#terminal-' + serviceId + ' pre');
    sendAjax({
        endpoint: '/Commands/command-logs',
        type: 'POST',
        data: { serverId, serviceId },
        beforeSend: function () {
            terminal.innerHTML += line + "Procesando...\n";
        },
        onSuccess: (data) => {
            if (data.success) {
                Notify(1, data.message);
                terminal.innerHTML += line + data.command + "\n";
                terminal.innerHTML += data.output + "\n";
                terminal.innerHTML += line + "\n";
                scrollTerminalToBottom(serviceId);
            } else {
                Notify(2, data.message);
                terminal.innerHTML += line + data.command + "\n";
                terminal.innerHTML += data.output + "\n";
                terminal.innerHTML += line + "\n";
                scrollTerminalToBottom(serviceId);
            }
        }
    });
}
function formatTerminalOutput(output) {
    return output
        // Active running
        .replace(
            /Active:\s+active\s+\(running\)/gi,
            '<span class="text-green-400 font-bold">$&</span>'
        )
        // Failed
        .replace(
            /Active:\s+failed/gi,
            '<span class="text-red-400 font-bold">$&</span>'
        )
        // Inactive
        .replace(
            /Active:\s+inactive/gi,
            '<span class="text-yellow-400 font-bold">$&</span>'
        )
        // Enabled
        .replace(
            /\benabled\b/gi,
            '<span class="text-green-400">$&</span>'
        )
        // Disabled
        .replace(
            /\bdisabled\b/gi,
            '<span class="text-red-400">$&</span>'
        );
}
function clearTerminal(serviceId, line) {
    document.querySelector('#terminal-' + serviceId + ' pre').innerHTML = line + "\n";
}
function scrollTerminalToBottom(serviceId) {
    const terminal = document.querySelector('#terminal-' + serviceId);
    terminal.scrollTop = terminal.scrollHeight;
}

function createService(id) {
    const requiredFields = [
        '#name',
        '#file_log'
    ];
    if (!validateRequiredFields(requiredFields)) {
        Notify(2, 'Complete el formulario');
        return;
    }
    const data = {
        serverId: id,
        name: $('#name').val().trim(),
        description: $('#description').val().trim(),
        file_log: $('#file_log').val().trim()
    }
    sendAjax({
        endpoint: '/Servicios/create',
        type: 'POST',
        data,
        onSuccess: (data) => {
            if (data.success) {
                Notify(1, data.message);
                closeModal();
                window.location.reload();
            } else {
                Notify(2, data.message);
            }
        }
    });
}
function createCommand(id){
    const requiredFields = [
        '#namec',
        '#command'
    ];
    if (!validateRequiredFields(requiredFields)) {
        Notify(2, 'Complete el formulario');
        return;
    }
    const data = {
        serverId: id,
        serviceId: $('#servicioId').val().trim(),
        name: $('#namec').val().trim(),
        command: $('#command').val().trim()
    }
    sendAjax({
        endpoint: '/Servicios/createCommands',
        type: 'POST',
        data,
        onSuccess: (data) => {
            if (data.success) {
                Notify(1, data.message);
                closeModal();
                window.location.reload();
            } else {
                Notify(2, data.message);
            }
        }
    });
}