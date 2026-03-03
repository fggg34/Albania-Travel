<?php

namespace App\Http\Controllers;

use App\Mail\AdminNewReview;
use App\Models\Review;
use App\Models\Tour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ReviewController extends Controller
{
    public function store(Request $request, Tour $tour): RedirectResponse
    {
        $recaptchaSecret = config('services.recaptcha.secret_key');
        if ($recaptchaSecret) {
            $request->validate(['g-recaptcha-response' => 'required'], [
                'g-recaptcha-response.required' => 'Please complete the reCAPTCHA verification.',
            ]);

            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $recaptchaSecret,
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]);

            $result = $response->json();
            if (! ($result['success'] ?? false)) {
                return back()->with('error', 'reCAPTCHA verification failed. Please try again.')->withInput()->withFragment('reviews');
            }
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string|max:2000',
        ]);

        // Prevent duplicate review from same user
        $existing = Review::where('tour_id', $tour->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already submitted a review for this tour.')->withFragment('reviews');
        }

        $review = Review::create([
            'tour_id' => $tour->id,
            'user_id' => auth()->id(),
            'rating' => (int) $validated['rating'],
            'title' => $validated['title'],
            'comment' => $validated['comment'],
            'is_approved' => false,
        ]);

        $adminEmail = config('mail.admin_email');
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new AdminNewReview($review));
        }

        return back()->with('success', 'Thank you! Your review has been submitted and is pending approval.')->withFragment('reviews');
    }
}
