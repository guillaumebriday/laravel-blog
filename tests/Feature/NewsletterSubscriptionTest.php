<?php

use App\Models\NewsletterSubscription;

test('store', function () {
    $params = validNewsletterSubscriptionParams();

    $this->actingAsUser()
        ->post('/newsletter-subscriptions', $params)
        ->assertStatus(302)
        ->assertSessionHas('success', 'Email added to the newsletter successfully');

    $this->assertDatabaseHas('newsletter_subscriptions', $params);
});

test('store fail', function () {
    $params = validNewsletterSubscriptionParams();
    NewsletterSubscription::factory()->create($params);

    $this->actingAsUser()
        ->post('/newsletter-subscriptions', $params)
        ->assertStatus(302)
        ->assertSessionHas('errors');

    expect('The Email has already been taken.')->toEqual(session('errors')->first());
});

test('unsubscribe', function () {
    $params = validNewsletterSubscriptionParams();
    $newsletter = NewsletterSubscription::factory()->create($params);

    $this->actingAsUser()
        ->get("newsletter-subscriptions/unsubscribe?email={$newsletter->email}")
        ->assertOk()
        ->assertSessionHas('success', 'The request for unsubscription has been taken into account.');

    $this->assertDatabaseMissing('newsletter_subscriptions', $newsletter->toArray());
});

test('unsubscribe fail', function () {
    $params = validNewsletterSubscriptionParams();

    $this->actingAsUser()
        ->get("newsletter-subscriptions/unsubscribe?email={$params['email']}")
        ->assertRedirect('/')
        ->assertSessionHas('errors');

    expect('The selected Email is invalid.')->toEqual(session('errors')->first());
});

/**
 * Valid params for updating or creating a resource
 */
function validNewsletterSubscriptionParams(array $overrides = []): array
{
    return array_merge([
        'email' => 'demo@demo.com'
    ], $overrides);
}
