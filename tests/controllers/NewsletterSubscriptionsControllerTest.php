<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\NewsletterSubscription;

class NewsletterSubscriptionsControllerTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testStore()
    {
        $user = factory(User::class)->create();
        $params = [ 'email' => 'darthvader@deathstar.ds' ];

        $response = $this->actingAs($user)->call('POST', route('newsletter-subscriptions.store'), $params);

        $this->seeInDatabase('newsletter_subscriptions', $params);
        $this->assertResponseStatus('302');
        $this->assertSessionHas('success');
    }

    public function testStoreUniqueFail()
    {
        $user = factory(User::class)->create();
        $params = [ 'email' => 'darthvader@deathstar.ds' ];
        $newsletter = factory(NewsletterSubscription::class)->create($params);

        $response = $this->actingAs($user)->call('POST', route('newsletter-subscriptions.store'), $params);

        $this->assertSessionHasErrors('email');
        $this->assertResponseStatus('302');
    }

    public function testUnsubscribe()
    {
        $user = factory(User::class)->create();
        $params = [ 'email' => 'darthvader@deathstar.ds' ];
        $newsletter = factory(NewsletterSubscription::class)->create($params);

        $response = $this->actingAs($user)->call('GET', route('newsletter-subscriptions.unsubscribe'), $params);

        $this->assertResponseStatus('200');
        $this->assertSessionHas('success', trans('newsletter.unsubscribed'));
    }

    public function testUnsubscribeFail()
    {
        $user = factory(User::class)->create();
        $params = [ 'email' => 'darthvader@deathstar.ds' ];

        $response = $this->actingAs($user)->call('GET', route('newsletter-subscriptions.unsubscribe'), $params);

        $this->assertRedirectedToRoute('home');
        $this->assertSessionHasErrors();
    }
}
