<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewsletterSubscriptionRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\NewsletterSubscription;
use App\Jobs\UnsubscribeEmailNewsletter;
use Validator;

class NewsletterSubscriptionsController extends Controller
{
    /**
    * Store a newly created resource in storage.
    *
    * @return Response
    */
    public function store(NewsletterSubscriptionRequest $request)
    {
        $newsletterSubscription = NewsletterSubscription::create([
            'email' => $request->input('email')
        ]);

        return back()->withSuccess(__('newsletter.created'));
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  Request $request
    * @return \Illuminate\Http\Response
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
