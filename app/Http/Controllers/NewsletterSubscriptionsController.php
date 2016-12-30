<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewsletterSubscriptionRequest;
use App\NewsletterSubscription;


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
}
