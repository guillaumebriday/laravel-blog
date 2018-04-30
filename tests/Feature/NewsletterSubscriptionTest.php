<?php

namespace Tests\Feature;

use App\Models\NewsletterSubscription;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsletterSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        $params = $this->validParams();

        $this->actingAsUser()
            ->post('/newsletter-subscriptions', $params)
            ->assertStatus(302)
            ->assertSessionHas('success', 'Email added to the newsletter successfully');

        $this->assertDatabaseHas('newsletter_subscriptions', $params);
    }

    public function testStoreFail()
    {
        $params = $this->validParams();
        factory(NewsletterSubscription::class)->create($params);

        $this->actingAsUser()
            ->post('/newsletter-subscriptions', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $this->assertEquals(session('errors')->first(), 'The Email has already been taken.');
    }

    public function testUnsubscribe()
    {
        $params = $this->validParams();
        $newsletter = factory(NewsletterSubscription::class)->create($params);

        $this->actingAsUser()
            ->get("newsletter-subscriptions/unsubscribe?email={$newsletter->email}")
            ->assertStatus(200)
            ->assertSessionHas('success', 'The request for unsubscription has been taken into account.');

        $this->assertDatabaseMissing('newsletter_subscriptions', $newsletter->toArray());
    }

    public function testUnsubscribeFail()
    {
        $params = $this->validParams();

        $this->actingAsUser()
            ->get("newsletter-subscriptions/unsubscribe?email={$params['email']}")
            ->assertRedirect('/')
            ->assertSessionHas('errors');

        $this->assertEquals(session('errors')->first(), 'The selected Email is invalid.');
    }

    /**
     * Valid params for updating or creating a resource
     *
     * @param  array $overrides new params
     * @return array Valid params for updating or creating a resource
     */
    private function validParams($overrides = [])
    {
        return array_merge([
            'email' => 'darthvader@deathstar.ds'
        ], $overrides);
    }
}
