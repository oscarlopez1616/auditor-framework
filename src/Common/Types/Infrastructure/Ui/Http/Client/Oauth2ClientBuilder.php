<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Infrastructure\Ui\Http\Client;

use GuzzleHttp\ClientInterface;

interface Oauth2ClientBuilder
{
    public function createReAuthClient(): void;
    public function configureGrantType(): void;
    public function createClient(): void;
    public function getClient(): ClientInterface;
}
