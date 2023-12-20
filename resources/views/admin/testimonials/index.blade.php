@extends('admin.template.index')

@section('title', 'Testimonial')

@section('content')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div class="card-title">Testimonial Lists</div>
                                <button class="btn btn-primary btn-sm" id="addTestimonial"><i class="fas fa-plus"></i> Add
                                    Testimonial</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered testimonial-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Testimonial</th>
                                        <th>Job</th>
                                        <th>Image</th>
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

    @include('admin.testimonials.add')

    @push('scripts')
        <script type="text/javascript">
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var table = $('.testimonial-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('testimonial.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'testimonial',
                            name: 'testimonial'
                        },
                        {
                            data: 'job',
                            name: 'job'
                        },
                        {
                            data: 'image',
                            name: 'image'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            sortable: false,
                            searchable: false,
                        },
                    ],
                });

                $('#addTestimonial').click(function() {
                    $('#saveTestimonial').show();
                    $('#updateTestimonial').hide();
                    $('#saveTestimonial').val("create-testimonial");
                    $('#testimonial_id').val('');
                    $('#testimonialForm').trigger("reset");
                    $('#addTestimonialModal .modal-dialog');
                    $('#addTestimonialModal').modal('show');
                });

                $('#saveTestimonial').click(function(e) {
                    e.preventDefault();

                    var formData = new FormData($("#testimonialForm")[0]);

                    var url = "{{ route('testimonial.store') }}";
                    var method = 'POST';

                    $.ajax({
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: url,
                        type: method,
                        dataType: 'json',
                        success: function(data) {
                            $('#testimonialForm').trigger("reset");
                            $('#addTestimonialModal').modal('hide');
                            table.draw();
                            Swal.fire({
                                title: "Success!",
                                text: "The Testimonial has been added successfully.",
                                icon: "success",
                                timer: 3000
                            });
                        },
                        error: function(data) {
                            console.log('Error:', data);
                            $('#saveTestimonial').html('Save Changes');
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

                $('body').on('click', '.editTestimonial', function() {
                    var testimonial_id = $(this).data('id');
                    $.get("{{ route('testimonial.index') }}" + '/' + testimonial_id + '/edit', function(data) {
                        $('#modelHeading').html("Edit Testimonial");
                        $('#saveTestimonial').hide();
                        $('#updateTestimonial').show();
                        $('#updateTestimonial').val("edit-testimonial");
                        $('#addTestimonialModal .modal-dialog');
                        $('#addTestimonialModal').modal('show');
                        $('#testimonial_id').val(data.id);
                        $('#name').val(data.name);
                        $('#testimonial').val(data.testimonial);
                        $('#job').val(data.job);
                        $('#current_image').attr('src', 'storage/' + data.image);
                    });
                });

                $('#updateTestimonial').click(function(e) {
                    e.preventDefault();

                    var testimonial_id = $('#testimonial_id').val();
                    var url = "{{ route('testimonial.update', ':id') }}".replace(':id', testimonial_id);
                    var method = 'PUT';

                    // Add validation checks here

                    var formData = new FormData($('#testimonialForm')[0]);
                    formData.append('_method', method);

                    $.ajax({
                        data: formData,
                        url: url,
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $('#testimonialForm').trigger("reset");
                            $('#addTestimonialModal').modal('hide');
                            table.draw();
                            Swal.fire({
                                title: "Success!",
                                text: "The testimonial has been updated successfully.",
                                icon: "success",
                                timer: 3000
                            });
                        },
                        error: function(data) {
                            console.log('Error:', data);
                            $('#updateTestimonial').html('Save Changes');
                        }
                    });
                });
            })

            function deleteTestimonial(url) {
                Swal.fire({
                    title: 'Are You sure want to delete Testimonial Data?',
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
                                const dataTable = $('.testimonial-table').DataTable();
                                dataTable.row(`[data-id="${response.id}"]`).remove().draw();
                                Swal.fire({
                                    title: 'Testimonial Deleted Successfully!',
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
