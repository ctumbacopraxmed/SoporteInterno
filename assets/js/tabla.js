/*

function exportToExcel(jsonData, fileName) {
    var workbook = XLSX.utils.book_new();
    var worksheet = XLSX.utils.json_to_sheet(jsonData);
    XLSX.utils.book_append_sheet(workbook, worksheet, "Hoja 1");
    XLSX.writeFile(workbook, fileName + ".xlsx");
}*/
function initTableSearch() {
    $('#tableSearch')
        .off('input')
        .on('input', function () {
            const value = $(this).val().toLowerCase();
            $('#table tbody tr').each(function () {

                const text = $(this).text().toLowerCase();

                $(this).toggle(
                    text.includes(value)
                );
            });
        });
}
function initTableSorting() {
    let sortDirection = {};
    $('#table th.sortable').each(function (index) {
        $(this)
            .css('cursor', 'pointer')
            .off('click')
            .on('click', function () {
                sortDirection[index] =
                    !sortDirection[index];
                sortTable(
                    index,
                    sortDirection[index]
                );
                // table todos los iconos
                $('#table th.sortable .sort-icon')
                    .attr('data-lucide', 'arrow-up-down');
                // Actualizar el actual
                $(this)
                    .find('.sort-icon')
                    .attr(
                        'data-lucide',
                        sortDirection[index]
                            ? 'arrow-up'
                            : 'arrow-down'
                    );
                lucide.createIcons();
            });
    });
}
function sortTable(columnIndex, asc = true) {
    const tbody = $('#table tbody');
    const rows = tbody.find('tr').get();
    rows.sort((a, b) => {
        const aCell = $(a).children().eq(columnIndex);
        const bCell = $(b).children().eq(columnIndex);
        let aValue = aCell.data('sort');
        let bValue = bCell.data('sort');
        // Si no existe data-sort, usar el texto visible
        if (aValue === undefined) {
            aValue = aCell.text().trim();
        }
        if (bValue === undefined) {
            bValue = bCell.text().trim();
        }
        // Si ambos son numéricos, ordenar como números
        const aNum = Number(aValue);
        const bNum = Number(bValue);
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return asc
                ? aNum - bNum
                : bNum - aNum;
        }
        // Ordenamiento de texto
        return asc
            ? String(aValue).localeCompare(String(bValue), undefined, {
                numeric: true,
                sensitivity: 'base'
            })
            : String(bValue).localeCompare(String(aValue), undefined, {
                numeric: true,
                sensitivity: 'base'
            });
    });
    tbody.append(rows);
}