function sendAjax({
    endpoint,
    type = 'GET',
    data = {},
    beforeSend = () => { },
    onSuccess,
    onComplete = () => { }
}) {

    const ajaxConfig = {
        url: ruta_web + endpoint,
        type,
        beforeSend,
        success: function (response) {
            try {
                onSuccess(response);
            } catch (e) {
                console.log(e);
                Notify(2, 'Ocurrio un error inesperado');
            }
        },
        error: function () {
            Notify(2, 'Ocurrio un error inesperado');
        },
        complete: function () {
            onComplete();
        }
    };
    if (type.toUpperCase() !== 'GET') {
        ajaxConfig.contentType = 'application/json';
        ajaxConfig.data = JSON.stringify(data);
    } else if (Object.keys(data).length > 0) {
        ajaxConfig.data = data;
    }
    $.ajax(ajaxConfig);
}

function bindButtonClick(buttonClass, callback, dataAttribute = null) {
    $(document).on('click', buttonClass, function () {
        const value = dataAttribute ? $(this).data(dataAttribute) : null;
        if (callback) {
            callback(value);
        }
    });
}

function validateRequiredFields(fields) {
    for (const field of fields) {
        const value = $(field).val();

        if (value === null || value === undefined || value.toString().trim() === '') {
            $(field).focus();
            return false;
        }
    }

    return true;
}
function loadingTable(containerId, rows = 5) {
    let html = '<div class="space-y-3 animate-pulse">';

    for (let i = 0; i < rows; i++) {
        html += `
            <div class="grid grid-cols-6 gap-4 items-center p-3 border border-gray-200 rounded-lg">
                <div class="w-4 h-4 bg-gray-200 rounded"></div>
                <div class="h-4 bg-gray-200 rounded"></div>
                <div class="h-4 bg-gray-200 rounded"></div>
                <div class="h-4 w-24 bg-gray-200 rounded"></div>
                <div class="h-4 w-20 bg-gray-200 rounded ml-auto"></div>
                <div class="h-6 w-16 bg-gray-200 rounded-full"></div>
            </div>
        `;
    }

    html += '</div>';

    $('#' + containerId).empty().html(html);
}
function loadingStats(containerId, cards = 4) {
    let html = `
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4 select-none animate-pulse">
    `;

    for (let i = 0; i < cards; i++) {
        html += `
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4">
                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 bg-gray-200 rounded-lg"></div>

                    <div class="flex-1">
                        <div class="h-4 w-24 bg-gray-200 rounded mb-3"></div>
                        <div class="h-6 w-16 bg-gray-200 rounded mb-3"></div>
                        <div class="h-3 w-32 bg-gray-200 rounded"></div>
                    </div>

                </div>
            </div>
        `;
    }

    html += '</div>';

    $('#' + containerId).empty().html(html);
}

function openModal(modalId, contentId, fields = []) {
    $(modalId).removeClass('hidden');

    requestAnimationFrame(() => {
        $(contentId)
            .removeClass('scale-95 opacity-0')
            .addClass('scale-100 opacity-100');
    });

    fields.forEach(field => {
        $(field).val('');
    });
}

function closeModal(modalId, contentId, duration = 300) {
    $(contentId)
        .removeClass('scale-100 opacity-100')
        .addClass('scale-95 opacity-0');

    setTimeout(() => {
        $(modalId).addClass('hidden');
    }, duration);
}