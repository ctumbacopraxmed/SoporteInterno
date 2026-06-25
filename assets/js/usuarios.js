$(document).ready(function () {
    $('#settings').removeClass('hidden');
});

$(document).on('click', '#btnOpenModal', function () {
    const fields = [
        '#name',
        '#user',
        '#password'
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