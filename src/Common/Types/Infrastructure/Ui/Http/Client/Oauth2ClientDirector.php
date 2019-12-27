<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Client;

class Oauth2ClientDirector
{
    public function createClient(Oauth2ClientBuilder $clientBuilder): void
    {
        $clientBuilder->createReAuthClient();
        $clientBuilder->configureGrantType();
        $clientBuilder->createClient();
    }
}
