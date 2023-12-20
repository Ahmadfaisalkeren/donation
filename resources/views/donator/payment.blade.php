<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout Page</title>

    @include('donator.components.css')

</head>

<body>
    @include('donator.navbar')

    <div class="col-12">
        <div class="row">
            <div class="container mt-3">
                <div class="card">
                    <div class="card-header bg-success">
                        <p class="text-center">Checkout Success, Let's Pay Your Donation</p>
                    </div>
                    <div class="card-body fixed-height">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 mx-auto">
                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>Transaction Id</td>
                                                <td>{{ $transaction->id }}</td>
                                            </tr>
                                            <tr>
                                                <td>Donation Title</td>
                                                <td>{{ $transaction->donation->title }}</td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td class="bg-danger">{{ $transaction->status }}</td>
                                            </tr>
                                            <tr>
                                                <td>Checkout Time</td>
                                                <td>{{ tanggal_indonesia($transaction->created_at) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Donation Amount</td>
                                                <td>IDR. {{ format_uang($transaction->donation_amount) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Message</td>
                                                <td>{{ $transaction->message }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mx-auto mb-3">
                        <button id="pay-button" class="btn btn-donker text-white btn-xl"><i class="fas fa-money-check-alt"></i> Pay Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('donator.components.scripts')

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('{{ $transaction->snap_token }}', {
                // Optional
                onSuccess: function(result) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('donation.payment', ['transaction_id' => ':transaction_id']) }}"
                            .replace(':transaction_id', '{{ $transaction->id }}'),
                        type: 'PUT', // Use 'PUT' since you've mentioned you are using a PUT route
                        dataType: 'json',
                        success: function(data) {
                            // Redirect to the mydonation page
                            window.location.href = '{{ route('mydonation') }}';
                        },
                        error: function(data) {
                            console.log('Error updating status and paid_at:', data);
                        }
                    });
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script>

</body>

</html>
