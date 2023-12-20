$(document).ready(function() {
    initializeDataTable();

    $('#addDonation').click(function () {
        $('#saveDonation').show();
        $('#updateDonation').hide();
        $('#saveDonation').val("create-donation");
        $('#donation_id').val('');
        $('#donationForm').trigger("reset");
        $('#addDonationModal .modal-dialog');
        $('#addDonationModal').modal('show');
    });

    $('#saveDonation').click(function(e) {
        e.preventDefault();

        var formData = new FormData($("#donationForm")[0]);

        var url = donationsStoreRoute;
        var method = 'POST';

        $.ajax({
            data: formData,
            processData: false,
            contentType: false,
            url: url,
            type: method,
            dataType: 'json',
            success: function(data) {
                $('#donationForm').trigger("reset");
                $('#addDonationModal').modal('hide');
                table.draw();
                $('#current_image').attr('src', '');
                Swal.fire({
                    title: "Success!",
                    text: "The Donation has been added successfully.",
                    icon: "success",
                    timer: 3000
                });
            },
            error: function(data) {
                console.log('Error:', data);
                $('#saveDonation').html('Save Changes');
            }
        });
    });
});
