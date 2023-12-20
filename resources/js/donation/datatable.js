var table;

function initializeDataTable() {
    table = $('.donations-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: donationsIndexRoute,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'image', name: 'image' },
            { data: 'donation_target', name: 'donation_target' },
            { data: 'current_donation', name: 'current_donation' },
            { data: 'start_date', name: 'start_date' },
            { data: 'end_date', name: 'end_date' },
            { data: 'action', name: 'action' },
        ]
    });

    $(document).ready(function() {
        initializeDataTable();
    });
}
