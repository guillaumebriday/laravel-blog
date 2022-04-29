<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterSubscriptionRequest;
use App\Jobs\UnsubscribeEmailNewsletter;
use App\Models\NewsletterSubscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Validator;

class NewsletterSubscriptionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsletterSubscriptionRequest $request): RedirectResponse
    {
        $newsletterSubscription = NewsletterSubscription::create($request->validated());

        return back()->withSuccess(__('newsletter.created'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function unsubscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:newsletter_subscriptions,email'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $route = 'login';

            if (Auth::check()) {
                $route = 'home';
            }

            return redirect()->route($route)->withErrors($errors);
        }

        UnsubscribeEmailNewsletter::dispatch($request->input('email'));

        Session::flash('success', __('newsletter.unsubscribed'));

        return view('newsletters.unsubscribed');
    }
}
