<div class="col-12">
    <h3 class="text-center text-donker">Donation Lists</h3>
    <div class="container">
        <div class="row">
            @foreach ($donationCard as $item)
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="card shadow-lg mb-5 bg-body-tertiary rounded h-100">
                        <div class="img-wrapper rounded-top">
                            <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top">
                        </div>
                        <div class="card-body">
                            <p class="text-bold text-donker">{{ $item->title }}</p>
                            <p class="text-center mt-2">IDR. {{ format_uang($item->getTotalDonationAmount()) }} of IDR.
                                {{ format_uang($item->donation_target) }}</p>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ ($item->getTotalDonationAmount() / $item->donation_target) * 100 }}%;"
                                    aria-valuenow="{{ $item->getTotalDonationAmount() }}" aria-valuemin="0"
                                    aria-valuemax="{{ $item->donation_target }}"></div>
                            </div>
                            <p class="text-bold text-small mb-1">Ended</p>
                            <p class="text-bold text-small">{{ tanggal_indonesia($item->end_date) }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <a title="Choose your donation" href="{{ route('donation.donate', ['id' => $item->id]) }}"
                                class="btn btn-donker text-white mt-3"><i class="fas fa-donate"></i> Donate</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="text-center">
        <a class="text-purple" href="">View More...</a>
    </div>
</div>
