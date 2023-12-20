<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('donations.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-donate"></i>
                    <p>
                        Donations
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('transactions.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-receipt"></i>
                    <p>
                        Transactions
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('donator.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Donator
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('carousel.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Carousel
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('testimonial.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Testimonials
                    </p>
                </a>
            </li>
        <li class="nav-item">
            <a href="#" class="nav-link" onclick="logoutConfirmation();">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                    Logout
                </p>
            </a>
        </li>
    </ul>
</nav>

@push('scripts')
    <script>
        function logoutConfirmation() {
            Swal.fire({
                title: 'Ready to Leave?',
                text: 'You are sure want to Logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Logout',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
@endpush
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
