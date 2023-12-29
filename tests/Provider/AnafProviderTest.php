<?php

use Anaf\OAuth2\Client\Provider\AnafProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use League\OAuth2\Client\Token\AccessTokenInterface;

it('constructs with correct parameters', function () {
    $provider = new AnafProvider('client-id', 'client-secret', 'redirect-uri');
    expect($provider)->toBeInstanceOf(AnafProvider::class);
});

it('returns correct base authorization URL', function () {
    $provider = new AnafProvider('client-id', 'client-secret', 'redirect-uri');
    expect($provider->getBaseAuthorizationUrl())->toEqual('https://logincert.anaf.ro/anaf-oauth2/v1/authorize');
});

it('returns correct base access token URL', function () {
    $provider = new AnafProvider('client-id', 'client-secret', 'redirect-uri');
    expect($provider->getBaseAccessTokenUrl([]))->toEqual('https://logincert.anaf.ro/anaf-oauth2/v1/token');
});

it('returns correct authorization URL with options', function () {
    $provider = new AnafProvider('client-id', 'client-secret', 'redirect-uri');
    $url = $provider->getAuthorizationUrl(['scope' => 'test-scope']);
    expect($url)->toContain('https://logincert.anaf.ro/anaf-oauth2/v1/authorize');
    expect($url)->toContain('token_content_type=jwt');
    expect($url)->toContain('scope=test-scope');
});

it('returns an access token', function () {
    // Create a mock response
    $mockResponse = new Response(
        200,
        ['Content-Type' => 'application/json'],
        json_encode(['access_token' => 'test-token', 'expires_in' => 3600])
    );

    $mock = new MockHandler([$mockResponse]);

    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);

    $provider = new AnafProvider('client-id', 'client-secret', 'redirect-uri');
    $provider->setHttpClient($client);

    $accessToken = $provider->getAccessToken('authorization_code', ['code' => 'test-code']);
    expect($accessToken)->toBeInstanceOf(AccessTokenInterface::class)
        ->and($accessToken->getToken())->toBe('test-token');
});

it('retrieves resource owner details', function () {
    $this->markTestIncomplete('Implement this after the resource owner is implemented');
});
