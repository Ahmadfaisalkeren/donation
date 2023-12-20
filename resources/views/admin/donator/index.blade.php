@extends('admin.template.index')

@section('title', 'Donator')

@section('content')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div class="card-title">Donator Lists</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered donator-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
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

    @push('scripts')
        <script type="text/javascript">
            $(function () {
                $('.donator-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('donator.index') }}",
                    columns:
                        [
                            {
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex'
                            },
                            {
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'email',
                                name: 'email'
                            },
                            {
                                data: 'action',
                                name: 'action'
                            },
                        ],
                });
            })
        </script>
    @endpush
@endsection
