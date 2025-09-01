$(document).ready(function () {
    $('.common-datatable').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        columnDefs: [{
            targets: 'no-sort',
            orderable: false
        }]
    });
});
