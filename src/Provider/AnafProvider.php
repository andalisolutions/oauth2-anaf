<?php

declare(strict_types=1);

namespace Anaf\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class AnafProvider extends AbstractProvider
{
    protected const ANAF_URL_LOGINCERT = 'https://logincert.anaf.ro';

    protected const ANAF_API_VERSION = 'v1';

    public function __construct(string $clientId, string $clientSecret, string $redirectUri)
    {
        parent::__construct([
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri' => $redirectUri,
        ]);
    }

    public function getBaseAuthorizationUrl(): string
    {
        return self::ANAF_URL_LOGINCERT.'/anaf-oauth2/'.self::ANAF_API_VERSION.'/authorize';
    }

    public function getBaseAccessTokenUrl(array $params): string
    {
        return self::ANAF_URL_LOGINCERT.'/anaf-oauth2/'.self::ANAF_API_VERSION.'/token';
    }

    public function getAuthorizationUrl(array $options = []): string
    {
        $url = parent::getAuthorizationUrl($options);

        return $this->appendQuery($url, $this->buildQueryString(['token_content_type' => 'jwt']));
    }

    public function getAccessToken($grant, array $options = []): AccessTokenInterface|AccessToken
    {
        $options = array_merge($options, ['token_content_type' => 'jwt']);

        return parent::getAccessToken($grant, $options);
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        // TODO: Implement getResourceOwnerDetailsUrl() after the ANAF API is ready
        throw new RuntimeException('Method not implemented.');
    }

    /**
     * @return array<int, string>
     */
    protected function getDefaultScopes(): array
    {
        return [];
    }

    /**
     * Checks a provider response for errors.
     *
     * @param  array|string  $data Parsed response data
     *
     * @throws IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if ($response->getStatusCode() >= 400 || isset($data['error'])) {
            throw new IdentityProviderException(
                $data['error'] ?? $response->getReasonPhrase(),
                $response->getStatusCode(),
                (string) $response->getBody()
            );
        }
    }

    /**
     * @param  array<string, mixed>  $response
     */
    protected function createResourceOwner(array $response, AccessToken $token): ResourceOwnerInterface
    {
        // TODO: Implement createResourceOwner() method.
        throw new RuntimeException('Method not implemented.');
    }
}
