@extends('admin.template.index')

@section('title', 'Transaction')

@section('content')
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div class="card-title">Transaction Lists</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered transactions-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User Name</th>
                                        <th>Donation Title</th>
                                        <th>Donation Amount</th>
                                        <th>Status</th>
                                        <th>Checkout At</th>
                                        <th>Paid At</th>
                                        <th>Donation Amount</th>
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
            $(function() {
                $('.transactions-table').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: "{{ route('transactions.index') }}",
                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'username',
                            name: 'username'
                        },
                        {
                            data: 'title',
                            name: 'title'
                        },
                        {
                            data: 'donation_amount',
                            name: 'donation_amount'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'message',
                            name: 'message'
                        },
                        {
                            data: 'checkout_at',
                            name: 'checkout_at'
                        },
                        {
                            data: 'paid_at',
                            name: 'paid_at'
                        },
                    ]
                });
            })
        </script>
    @endpush
@endsection
