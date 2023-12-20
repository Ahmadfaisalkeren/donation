@extends('admin.template.index')

@section('title', 'Carousel')

@section('content')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div class="card-title">Carousel Lists</div>
                                <button class="btn btn-primary btn-sm" id="addCarousel"><i class="fas fa-plus"></i> Add
                                    Carousel</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered carousel-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
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

    @include('admin.carousel.add')

    @push('scripts')
        <script type="text/javascript">
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var table = $('.carousel-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('carousel.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'title',
                            name: 'title'
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

                $('#addCarousel').click(function() {
                    $('#saveCarousel').show();
                    $('#updateCarousel').hide();
                    $('#saveCarousel').val("create-carousel");
                    $('#carousel_id').val('');
                    $('#carouselForm').trigger("reset");
                    $('#addCarouselModal .modal-dialog');
                    $('#addCarouselModal').modal('show');
                });

                $('#saveCarousel').click(function(e) {
                    e.preventDefault();

                    var formData = new FormData($("#carouselForm")[0]);

                    var url = "{{ route('carousel.store') }}";
                    var method = 'POST';

                    $.ajax({
                        data: formData,
                        processData: false,
                        contentType: false,
                        url: url,
                        type: method,
                        dataType: 'json',
                        success: function(data) {
                            $('#carouselForm').trigger("reset");
                            $('#addCarouselModal').modal('hide');
                            table.draw();
                            Swal.fire({
                                title: "Success!",
                                text: "The Carousel has been added successfully.",
                                icon: "success",
                                timer: 3000
                            });
                        },
                        error: function(data) {
                            console.log('Error:', data);
                            $('#saveCarousel').html('Save Changes');
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

                $('body').on('click', '.editCarousel', function() {
                    var carousel_id = $(this).data('id');
                    $.get("{{ route('carousel.index') }}" + '/' + carousel_id + '/edit', function(data) {
                        $('#modelHeading').html("Edit Carousel");
                        $('#saveCarousel').hide();
                        $('#updateCarousel').show();
                        $('#updateCarousel').val("edit-carousel");
                        $('#addCarouselModal .modal-dialog');
                        $('#addCarouselModal').modal('show');
                        $('#carousel_id').val(data.id);
                        $('#title').val(data.title);
                        $('#description').val(data.description);
                        $('#carousel_target').val(data.carousel_target);
                        $('#current_carousel').val(data.current_carousel);
                        $('#start_date').val(data.start_date);
                        $('#end_date').val(data.end_date);
                        $('#current_image').attr('src', 'storage/' + data.image);
                    });
                });

                $('#updateCarousel').click(function(e) {
                    e.preventDefault();

                    var carousel_id = $('#carousel_id').val();
                    var url = "{{ route('carousel.update', ':id') }}".replace(':id', carousel_id);
                    var method = 'PUT';

                    // Add validation checks here

                    var formData = new FormData($('#carouselForm')[0]);
                    formData.append('_method', method);

                    $.ajax({
                        data: formData,
                        url: url,
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $('#carouselForm').trigger("reset");
                            $('#addCarouselModal').modal('hide');
                            table.draw();
                            Swal.fire({
                                title: "Success!",
                                text: "The carousel has been updated successfully.",
                                icon: "success",
                                timer: 3000
                            });
                        },
                        error: function(data) {
                            console.log('Error:', data);
                            $('#updateCarousel').html('Save Changes');
                        }
                    });
                });
            })

            function deleteCarousel(url) {
                Swal.fire({
                    title: 'Are You sure want to delete Carousel Data?',
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
                                const dataTable = $('.carousel-table').DataTable();
                                dataTable.row(`[data-id="${response.id}"]`).remove().draw();
                                Swal.fire({
                                    title: 'Carousel Deleted Successfully!',
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
