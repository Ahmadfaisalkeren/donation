<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\Donation;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function index()
    {
        $donationCard = Donation::all();
        $carouselSlides = Carousel::all();
        $testimonials = Testimonial::all();

        if (auth()->user()->role == "admin") {
            return view('admin.template.index', compact('donationCard', 'carouselSlides', 'testimonials'));
        } else {
            return view('donator.index', compact('donationCard', 'carouselSlides', 'testimonials'));
        }

    }
}
