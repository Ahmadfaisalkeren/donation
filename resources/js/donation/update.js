function handleEditDonationClick() {
    $('body').on('click', '.editDonation', function () {
        var donation_id = $(this).data('id');
        $.get("{{ route('donations.index') }}" + '/' + donation_id + '/edit', function(data) {
            $('#modelHeading').html("Edit Donation");
            $('#saveDonation').hide();
            $('#updateDonation').show();
            $('#updateDonation').val("edit-donation");
            $('#addDonationModal .modal-dialog');
            $('#addDonationModal').modal('show');
            $('#donation_id').val(data.id);
            $('#title').val(data.title);
            $('#description').val(data.description);
            $('#donation_target').val(data.donation_target);
            $('#current_donation').val(data.current_donation);
            $('#start_date').val(data.start_date);
            $('#end_date').val(data.end_date);
            $('#current_image').attr('src', 'storage/' + data.image);
        });
    });
}

function handleUpdateDonationClick(table) {
    $('#updateDonation').click(function (e) {
        e.preventDefault();

        var donation_id = $('#donation_id').val();
        var url = "{{ route('donations.update', ':id') }}".replace(':id', donation_id);
        var method = 'PUT';

        // Add validation checks here

        var formData = new FormData($('#donationForm')[0]);
        formData.append('_method', method);

        $.ajax({
            data: formData,
            url: url,
            type: 'POST',
            contentType: false,
            processData: false,
            success: function(data) {
                $('#donationForm').trigger("reset");
                $('#addDonationModal').modal('hide');
                table.draw();
                Swal.fire({
                    title: "Success!",
                    text: "The donation has been updated successfully.",
                    icon: "success",
                    timer: 3000
                });
            },
            error: function(data) {
                console.log('Error:', data);
                $('#updateDonation').html('Save Changes');
            }
        });
    });
}
