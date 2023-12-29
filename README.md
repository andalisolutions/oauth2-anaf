<p align="center">
    <img src="https://raw.githubusercontent.com/andalisolutions/oauth2-anaf/main/art/social.png" width="600" alt="OAuth 2.0 ANAF">
    <p align="center">
        <a href="https://github.com/andalisolutions/oauth2-anaf/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/andalisolutions/oauth2-anaf/tests.yml?branch=main&label=tests&style=round-square"></a>
        <a href="https://packagist.org/packages/andalisolutions/oauth2-anaf"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/andalisolutions/oauth2-anaf"></a>
        <a href="https://packagist.org/packages/andalisolutions/oauth2-anaf"><img alt="Latest Version" src="https://img.shields.io/packagist/v/andalisolutions/oauth2-anaf"></a>
        <a href="https://packagist.org/packages/andalisolutions/oauth2-anaf"><img alt="License" src="https://img.shields.io/github/license/andalisolutions/oauth2-anaf"></a>
    </p>
</p>

# ANAF Provider for OAuth 2.0 Client

This package provides [ANAF OAuth 2.0](https://static.anaf.ro/static/10/Anaf/Informatii_R/API/Oauth_procedura_inregistrare_aplicatii_portal_ANAF.pdf) support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

------
## Installation

To install, use composer:

```
composer require andalisolutions/oauth2-anaf
```

## Usage

Usage is the same as The League's OAuth client, using `\Anaf\OAuth2\Client\Provider\AnafProvider` as the provider.

### Authorization Code Flow

```php
$provider = new Anaf\OAuth2\Client\Provider\AnafProvider(
    clientId: '{anaf-client-id}',
    clientSecret: '{anaf-client-secret}',
    redirectUrl: 'https://example.com/callback-url',
);

// Redirect to the authorization URL
$authorizationUrl = $provider->getAuthorizationUrl();
header('Location: ' . $authorizationUrl);

// This part will be in your callback script
if (isset($_GET['code'])) {
    try {
        $accessToken = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code'],
        ]);
        // We have an access token, which we may use in authenticated
        // requests against the service provider's API.
        echo 'Access Token: ' . $accessToken->getToken() . "<br>";
        echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "<br>";
        echo 'Expired in: ' . $accessToken->getExpires() . "<br>";
        echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "<br>";

    } catch (Exception $e) {
        // Handle errors, such as an invalid code
    }
}
```

## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](https://github.com/thephpleague/oauth2-instagram/blob/master/CONTRIBUTING.md) for details.


## Credits

- [Andrei Ciungulete](https://github.com/ciungulete)
- [All Contributors](https://github.com/andalisolutions/oauth2-anaf/contributors)


## License

The MIT License (MIT). Please see [License File](https://github.com/andalisolutions/oauth2-anaf/blob/master/LICENSE) for more information.
