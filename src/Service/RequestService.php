<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class RequestService
{
    public function __construct(private readonly HttpClientInterface $client) {}

    /**
     * Effectue une requête HTTP GET et retourne le résultat sous forme de JSON, XML ou texte brut.
     */
    public function fetch(string $url, array $options = []): array|string|\SimpleXMLElement
    {
        try {
            $response = $this->client->request('GET', $url, $options);
            $content = $response->getContent();
            $contentType = $response->getHeaders(false)['content-type'][0] ?? '';

            if (str_contains($contentType, 'application/json')) {
                $json = json_decode($content, true);
                return $json ?? $content;
            }

            if (str_contains($contentType, 'xml')) {
                $xml = simplexml_load_string($content);
                return $xml ?: ['error' => 'XML mal formé ou vide'];
            }

            return $content; // fallback texte brut
        } catch (\Throwable $e) {
            throw new \RuntimeException("Erreur lors de la requête : " . $e->getMessage(), 0, $e);
        }
    }
}
