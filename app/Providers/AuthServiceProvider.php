<?php

namespace App\Providers;

use App\Models\Client;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\AuthCode;
use Laravel\Passport\Passport;
use Laravel\Passport\PersonalAccessClient;
use Mockery\Generator\StringManipulation\Pass\Pass;
use TheSeer\Tokenizer\Token;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */

    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        Passport::personalAccessClient('1');

        /*Passport::loadKeysFrom(__DIR__.'/../secrets.oauth');
        Passport::hashClientSecrets();

        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        Passport::useTokenModel(Token::class);
        Passport::useClientModel(Client::class);
        Passport::useAuthCodeModel(AuthCode::class);
        Passport::usePersonalAccessClientModel(PersonalAccessClient::class);*/

    }
}
