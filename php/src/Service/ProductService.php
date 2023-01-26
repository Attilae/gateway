<?php

namespace App\Service;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;

final class ProductService
{
    public static function profileProducts(string $identifier): array
    {
        $client = self::getClient();

        try {
            $response = $client->get("/products/$identifier");

            return ['response' => json_decode($response->getBody(), true)];
        } catch (RequestException $e) {
            return ['error' => [
                'statusCode' => $e->getResponse()->getStatusCode(),
                'response' => json_decode($e->getResponse()->getBody(), true)
            ]];
        }
    }

    public static function save($identifier, string $type, array $data): array
    {
        $client = self::getClient();

        try {
            if ($identifier) {
                $response = $client->post("/management/product/$identifier/$type", [
                    'body' => json_encode($data)
                ]);
            } else {
                $response = $client->post("/management/product", [
                    'body' => json_encode($data)
                ]);
            }

            return ['response' => json_decode($response->getBody(), true)];
        } catch (RequestException $e) {
            return ['error' => [
                'statusCode' => $e->getResponse()->getStatusCode(),
                'response' => json_decode($e->getResponse()->getBody(), true)
            ]];
        }
    }

    public static function delete(string $identifier, string $type): array
    {
        $client = self::getClient();

        try {
            $response = $client->post("/management/product/$identifier/delete/$type");                        

            return ['response' => json_decode($response->getBody(), true)];
        } catch (RequestException $e) {
            return ['error' => [
                'statusCode' => $e->getResponse()->getStatusCode(),
                'response' => json_decode($e->getResponse()->getBody(), true)
            ]];
        }
    }

    private static function getClient(): ClientInterface
    {
        return new GuzzleClient(
            ['base_uri' => \getenv('PRODUCT_SERVICE_URI'),
            'headers' => [
                'Authorization' => 'Bearer ' . \getenv('PRODUCT_SERVICE_ACCESS_TOKEN')
            ]
            ]
        );
    }
}
