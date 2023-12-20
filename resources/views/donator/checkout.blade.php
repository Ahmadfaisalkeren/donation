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
                    <div class="card-header bg-donker">
                        <div class="text-white">
                            {{ $donationCard->title }}
                            <span class="float-right">
                                {{ \Carbon\Carbon::parse($donationCard->end_date)->diffInDays(\Carbon\Carbon::now()) }}
                                days to go
                            </span>
                        </div>
                    </div>
                    <div class="card-body fixed-height">
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Donation Title</th>
                                            <th>Donation Target</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $donationCard->title }}</td>
                                            <td>IDR. {{ format_uang($donationCard->donation_target) }}</td>
                                            <td>{{ tanggal_indonesia($donationCard->start_date) }}</td>
                                            <td>{{ tanggal_indonesia($donationCard->end_date) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <form id="checkoutDonation" name="checkoutDonation" class="form-horizontal">
                            <div class="form-group">
                                <label for="donation_amount" class="col-sm-2 control-label">
                                    Amount
                                </label><br>
                                <p class="badge bg-info ml-2">Minimum Donation IDR. 10.000</p>
                                <div class="col-12">
                                    <input type="number" name="donation_amount" id="donation_amount"
                                        class="form-control" placeholder="Amount" value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message" class="col-sm-2 control-label">
                                    Message
                                </label>
                                <div class="col-12">
                                    <textarea type="text" name="message" id="message" class="form-control" placeholder="Message" value=""
                                        required=""></textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button title="Checkout Donation" type="submit" class="btn btn-donker text-white btn-sm mr-2"
                                    id="saveCheckoutDonation"><i class="fas fa-money-check"></i> Checkout</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('donator.components.scripts')

    <script type="text/javascript">
        $(function() {
            var donation_id = {{ $donationCard->id }};

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#saveCheckoutDonation').click(function(e) {
                e.preventDefault();

                var formData = new FormData($("#checkoutDonation")[0]);

                var donation_id = $(this).data('donation_id');
                var url = "{{ route('donation.checkout', ['id' => $donationCard->id]) }}";
                var method = 'POST';

                $.ajax({
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    type: method,
                    dataType: 'json',
                    success: function(data) {
                        $('#saveCheckoutDonation').trigger("reset");
                        Swal.fire({
                            title: "Success!",
                            text: "The Donation has been added successfully, Redirecting to My Donation Page",
                            icon: "success",
                            timer: 3000
                        });
                        var transaction = data.transaction;
                        window.location.href =
                            "{{ route('donation.getPayment', ['transaction_id' => ':transaction_id']) }}"
                            .replace(':transaction_id', transaction.id);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#saveCheckoutDonation').html('Save Changes');
                    }
                });
            });
        })
    </script>

</body>

</html>
