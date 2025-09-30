<?php

namespace App\Services;

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Exception;

class HelloAssoService
{
    private GenericProvider $provider;
    private string $organizationSlug;
    private string $baseApiUrl;

    public function __construct()
    {
        $env = config('helloasso.environment');

        // URLs selon l'environnement
        if ($env === 'sandbox') {
            $this->baseApiUrl = 'https://api.helloasso-sandbox.com/v5';
            $oauthUrl = 'https://api.helloasso-sandbox.com/oauth2/token';
        } else {
            $this->baseApiUrl = 'https://api.helloasso.com/v5';
            $oauthUrl = 'https://api.helloasso.com/oauth2/token';
        }

        $this->provider = new GenericProvider([
            'clientId'                => config('helloasso.client_id'),
            'clientSecret'            => config('helloasso.client_secret'),
            'urlAccessToken'          => $oauthUrl,
            'urlAuthorize'            => '',
            'urlResourceOwnerDetails' => ''
        ]);

        $this->organizationSlug = config('helloasso.organization_slug');
    }

    /**
     * Obtenir un token d'accès
     */
    public function getAccessToken(): string
    {
        $cacheKey = config('helloasso.cache.token_key');

        // Vérifier le cache
        $cachedToken = Cache::get($cacheKey);
        if ($cachedToken) {
            return $cachedToken;
        }

        try {
            // Obtenir un nouveau token
            $accessToken = $this->provider->getAccessToken('client_credentials');

            $token = $accessToken->getToken();
            $expiresIn = $accessToken->getExpires() - time();

            // Cache avec marge de sécurité
            Cache::put($cacheKey, $token, now()->addSeconds($expiresIn * 0.9));

            return $token;
        } catch (IdentityProviderException $e) {
            throw new Exception('Erreur authentification HelloAsso: ' . $e->getMessage());
        }
    }

    /**
     * Faire un appel API
     */
    public function apiCall(string $endpoint, string $method = 'GET', array $data = []): array
    {
        $token = $this->getAccessToken();
        $url = $this->baseApiUrl . '/' . ltrim($endpoint, '/');

        $request = Http::timeout(30)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        $response = match (strtoupper($method)) {
            'GET' => $request->get($url, $data),
            'POST' => $request->post($url, $data),
            'PUT' => $request->put($url, $data),
            'PATCH' => $request->patch($url, $data),
            'DELETE' => $request->delete($url),
            default => throw new Exception("Méthode HTTP non supportée: {$method}")
        };

        if ($response->status() === 429) {
            throw new Exception('Rate limit HelloAsso atteint. Réessayez plus tard.');
        }

        if (!$response->successful()) {
            throw new Exception("Erreur API HelloAsso: {$response->status()} - {$response->body()}");
        }

        return $response->json();
    }

    /**
     * Tester la connexion
     */
    public function testConnection(): array
    {
        try {
            $token = $this->getAccessToken();

            // Test API : récupérer les infos de l'organisation
            $orgData = $this->apiCall("organizations/{$this->organizationSlug}");

            return [
                'success' => true,
                'message' => 'Connexion HelloAsso réussie !',
                'organization_name' => $orgData['name'] ?? 'N/A',
                'organization_slug' => $this->organizationSlug,
                'environment' => config('helloasso.environment'),
                'token_preview' => substr($token, 0, 20) . '...',
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur connexion: ' . $e->getMessage(),
                'environment' => config('helloasso.environment'),
            ];
        }
    }

    /**
     * Créer un checkout intent HelloAsso
     */
    public function createOrder(array $orderData): array
    {
        return $this->apiCall("organizations/{$this->organizationSlug}/checkout-intents", 'POST', $orderData);
    }

    /**
     * Obtenir une commande par ID
     */
    public function getOrder(int $orderId): array
    {
        return $this->apiCall("orders/{$orderId}");
    }

    /**
     * Obtenir les formulaires de checkout disponibles
     */
    public function getCheckoutForms(): array
    {
        $forms = $this->apiCall("organizations/{$this->organizationSlug}/forms");

        // Filtrer seulement les formulaires de type "Checkout"
        $checkoutForms = array_filter($forms['data'] ?? [], function ($form) {
            return $form['formType'] === 'Checkout';
        });

        return array_values($checkoutForms);
    }
}
