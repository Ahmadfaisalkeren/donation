function handleDeleteDonationClick(table) {
    function deleteDonation(url) {
        Swal.fire({
            title: 'Are You sure want to delete Donation Data?',
            text: 'Deleted Data Can not be Revert!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        const dataTable = $('.donations-table').DataTable();
                        dataTable.row(`[data-id="${response.id}"]`).remove().draw();
                        Swal.fire({
                            title: 'Donation Deleted Successfully!',
                            icon: 'success',
                        });
                    })
                    .fail((errors) => {
                        alert('Failed To Delete Data');
                        return;
                    });
            }
        });
    }

    $('body').on('click', '.deleteDonation', function () {
        var donation_id = $(this).data('id');
        var url = "{{ route('donations.destroy', ':id') }}".replace(':id', donation_id);
        deleteDonation(url);
    });
}
