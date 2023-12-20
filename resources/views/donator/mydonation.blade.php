<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Donation Page</title>

    @include('donator.components.css')
</head>

<body>
    @include('donator.navbar')

    <div class="col-lg-12">
        <div class="row">
            <div class="container">
                <div class="card mt-3">
                    <div class="card-header bg-donker">
                        <p class="text-white">My Donation Lists</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered mydonation-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Donation Title</th>
                                    <th>Donation Amount</th>
                                    <th>Status</th>
                                    <th>Message</th>
                                    <th>Checkout At</th>
                                    <th>Paid At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('donator.components.scripts')

    <script type="text/javascript">
        $(function() {
            var table = $('.mydonation-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('mydonation') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
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
                        name: 'status',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'message',
                        name: 'message'
                    },
                    {
                        data: 'checkout_at',
                        name: 'checkout_at',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'paid_at',
                        name: 'paid_at',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        sortable: false
                    },
                ]
            });
        });
    </script>
</body>

</html>
