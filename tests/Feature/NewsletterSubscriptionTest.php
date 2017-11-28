<?php

namespace Tests\Feature;

use App\NewsletterSubscription;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsletterSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        $params = $this->validParams();

        $this->actingAs($this->user())
            ->post('/newsletter-subscriptions', $params)
            ->assertStatus(302)
            ->assertSessionHas('success', 'Email ajouté à la newsletter avec succès');

        $this->assertDatabaseHas('newsletter_subscriptions', $params);
    }

    public function testStoreFail()
    {
        $params = $this->validParams();
        factory(NewsletterSubscription::class)->create($params);

        $this->actingAs($this->user())
            ->post('/newsletter-subscriptions', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $this->assertEquals(session('errors')->first(), 'La valeur du champ Adresse e-mail est déjà utilisée.');
    }

    public function testUnsubscribe()
    {
        $params = $this->validParams();
        $newsletter = factory(NewsletterSubscription::class)->create($params);

        $this->actingAs($this->user())
            ->get("newsletter-subscriptions/unsubscribe?email={$newsletter->email}")
            ->assertStatus(200)
            ->assertSessionHas('success', 'La demande de désabonnement a bien été prise en compte.');

        $this->assertDatabaseMissing('newsletter_subscriptions', $newsletter->toArray());
    }

    public function testUnsubscribeFail()
    {
        $params = $this->validParams();

        $this->actingAs($this->user())
            ->get("newsletter-subscriptions/unsubscribe?email={$params['email']}")
            ->assertStatus(302)
            ->assertRedirect('/')
            ->assertSessionHas('errors');

        $this->assertEquals(session('errors')->first(), 'Le champ Adresse e-mail sélectionné est invalide.');
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
