<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MailchimpProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->registerSwiftMailer();

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    // app/Providers/DBMailProvider.php

    function registerSwiftMailer()
    {
        if ($this->app['config']['mail.driver'] == 'mailchimp') {
            $this->registerDBSwiftMailer();
        } else {
            parent::registerSwiftMailer();
        }
    }

    private function registerDBSwiftMailer()
    {
        $this->app['swift.mailer'] = $this->app->share(function ($app) {
            return new \Swift_Mailer(new MailchimpTransport());
        });
    }
}
