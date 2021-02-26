<?php

namespace App\Providers;

use App\Models\Captcha;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Repository $setConfig)
    {
        Schema::defaultStringLength(191);

        try {
            $setting = \App\Models\Settings::where('key', 'email_setting')->first();
            if($setting) {
                $setting = $setting->value;

                $setConfig->set('mail.driver', $setting->driver);
                $setConfig->set('mail.host', $setting->host);
                $setConfig->set('mail.port', $setting->port);
                $setConfig->set('mail.from.address', $setting->from_email);
                $setConfig->set('mail.from.name', $setting->from_name);
                $setConfig->set('mail.encryption', $setting->encryption);
                $setConfig->set('mail.username', $setting->account);
                $setConfig->set('mail.password', $setting->password);
            }
        } catch(\PDOException $e) {
            Log::error($e->getMessage());
        }
    }
}
