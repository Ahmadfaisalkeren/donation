@extends('admin.template.index')

@section('title', 'Donation')

@section('content')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div class="card-title">Donation Lists</div>
                                <button type="button" class="btn btn-primary btn-sm" id="addDonation"><i
                                        class="fas fa-plus"></i> Add Donation</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered donations-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Donation Title</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Donation Target</th>
                                        <th>Current Donation</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.donations.add')

    @push('scripts')
        <script type="text/javascript">
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var table = $('.donations-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('donations.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'image',
                            name: 'image'
                        },
                        {
                            data: 'donation_target',
                            name: 'donation_target'
                        },
                        {
                            data: 'current_donation',
                            name: 'current_donation'
                        },
                        {
                            data: 'start_date',
                            name: 'start_date'
                        },
                        {
                            data: 'end_date',
                            name: 'end_date'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ]
                });

                $('#addDonation').click(function() {
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

                    var url = "{{ route('donations.store') }}";
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

                $('#image').on('change', function() {
                    var input = this;
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#current_image').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                });

                $('body').on('click', '.editDonation', function() {
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

                $('#updateDonation').click(function(e) {
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

                const titleInput = document.getElementById('title');
                const charCountTitle = document.getElementById('charCountTitle');

                const descriptionInput = document.getElementById('description');
                const charCountDescription = document.getElementById('charCountDescription');

                // Attach input event listeners to the input fields
                titleInput.addEventListener('input', updateCharacterCount.bind(null, titleInput, charCountTitle, 200));
                descriptionInput.addEventListener('input', updateCharacterCount.bind(null, descriptionInput,
                    charCountDescription, 200));

                // Function to update character count
                function updateCharacterCount(input, charCountElement, maxCount) {
                    input.value = input.value.slice(0, maxCount); // Truncate to the maximum length
                    const currentCount = input.value.length;
                    // Update the character count element
                    charCountElement.textContent = `${currentCount}/${maxCount}`;
                }

            })

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
        </script>
    @endpush
@endsection
