<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbApiService
{
    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->apiKey = getenv(name: "");
    }

    public function searchMovies(string $title):array
    {
        $response = $this->client->request(method: 'GET', url:'http://www.omdbapi.com',options: [
            'query' => [
                's' => $title,
                'apiKey' => $this->apiKey
            ]
        ]);
        if ($response->getStatusCode() !== 200) {
            throw new \Eception(message: 'Erreur lors de la requête API');
        }

        $data = $response->toArray();

        if (isset($data['Error'])) {
            throw new \Eception(message: $data['Error']);
        }
        return $data['Search'] ?? [];
    }

    public function getMovie(string $title):array
    {
        $response = $this->client->request(method: 'GET', url:'http://www.omdbapi.com',options: [
            'query' => [
                'apiKey' =>  $this->apiKey,
                't' => $title
            ]
        ]);
        
        return $response->toArray();
    }
}