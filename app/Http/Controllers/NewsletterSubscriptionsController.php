<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewsletterSubscriptionRequest;
use Illuminate\Support\Facades\Session;
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

    return back()->withSuccess(trans('newsletter.created'));
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

      if ($validator->fails())
      {
        return redirect()->route('home')->withErrors($validator);
      }

      $this->dispatch(new UnsubscribeEmailNewsletter($request->input('email')));

      Session::flash('success', trans('newsletter.unsubscribed'));

      return view('newsletters.unsubscribed')->withSuccess(trans('newsletter.unsubscribed'));
  }
}
