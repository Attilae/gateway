<?php

namespace App\Service;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\ClientInterface;
use App\Factory\LoggerFactory;

final class ProfileService
{
    public static function filters(): array
    {
        $client = self::getClient();

        try {
            $response = $client->get('/profile/metadata/filters');

            return ['response' => json_decode($response->getBody(), true)];
        } catch (RequestException $e) {
            return ['error' => [
                'statusCode' => $e->getResponse()->getStatusCode(),
                'response' => json_decode($e->getResponse()->getBody(), true)
            ]];
        }
    }

    public static function filter(int $page, array $filters): array
    {
        $client = self::getClient();

        try {
            $response = $client->post("/profiles/$page", [
                'body' => json_encode($filters)
            ]);

            return ['response' => json_decode($response->getBody(), true)];
        } catch (RequestException $e) {
            return ['error' => [
                'statusCode' => $e->getResponse()->getStatusCode(),
                'response' => json_decode($e->getResponse()->getBody(), true)
            ]];
        }
    }

    public static function show(string $identifier): array
    {
        $client = self::getClient();

        try {
            $response = $client->get("/profile/$identifier");

            return ['response' => json_decode($response->getBody(), true)];
        } catch (RequestException $e) {
            return ['error' => [
                'statusCode' => $e->getResponse()->getStatusCode(),
                'response' => json_decode($e->getResponse()->getBody(), true)
            ]];
        }
    }

    public static function profilesOnline(): array
    {
        $client = self::getClient();

        try {
            $response = $client->get("/profiles/online");
            
            return ['response' => json_decode($response->getBody(), true)];
        } catch (RequestException $e) {
            return ['error' => [
                'statusCode' => $e->getResponse()->getStatusCode(),
                'response' => json_decode($e->getResponse()->getBody(), true)
            ]];
        }
    }

    public static function getProfile(string $identifier, string $type): array
    {
        $client = self::getClient();

        try {
            $response = $client->get("/management/profile/$identifier/$type");
            
            return ['response' => json_decode($response->getBody(), true)];
        } catch (RequestException $e) {
            return ['error' => [
                'statusCode' => $e->getResponse()->getStatusCode(),
                'response' => json_decode($e->getResponse()->getBody(), true)
            ]];
        }
    }

    public static function save($identifier, array $data): array 
    {
        $client = self::getClient();

        try {
            if($identifier) {
                $response = $client->post("/management/profile/$identifier", [
                    'body' => json_encode($data)
                ]);
            } else {
                $response = $client->post("/management/profile", [
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

    public static function online($identifier, $type): array 
    {
        $client = self::getClient();

        try {
            
            $response = $client->post("/management/profile/$identifier/online/$type");

            return ['response' => json_decode($response->getBody(), true)];
        } catch (RequestException $e) {
            return ['error' => [
                'statusCode' => $e->getResponse()->getStatusCode(),
                'response' => json_decode($e->getResponse()->getBody(), true)
            ]];
        }
    }

    public static function offline($identifier, $type): array 
    {
        $client = self::getClient();

        try {
            
            $response = $client->post("/management/profile/$identifier/offline/$type");

            return ['response' => json_decode($response->getBody(), true)];
        } catch (RequestException $e) {
            return ['error' => [
                'statusCode' => $e->getResponse()->getStatusCode(),
                'response' => json_decode($e->getResponse()->getBody(), true)
            ]];
        }
    }

    public static function avatar($identifier, $type, $avatar): array 
    {
        $client = self::getClient();

        try {
            
            $response = $client->post("/management/profile/$identifier/avatar/$type",
            [
                'body' => json_encode([
                    'avatar' => $avatar
                ])
            ]);

            return ['response' => json_decode($response->getBody(), true)];
        } catch (RequestException $e) {
            return ['error' => [
                'statusCode' => $e->getResponse()->getStatusCode(),
                'response' => json_decode($e->getResponse()->getBody(), true)
            ]];
        }
    }

    public static function cover($identifier, $type, $cover): array 
    {
        $client = self::getClient();

        try {
            
            $response = $client->post("/management/profile/$identifier/cover/$type",
            [
                'body' => json_encode([
                    'cover' => $cover
                ])
            ]);

            return ['response' => json_decode($response->getBody(), true)];
        } catch (RequestException $e) {
            return ['error' => [
                'statusCode' => $e->getResponse()->getStatusCode(),
                'response' => json_decode($e->getResponse()->getBody(), true)
            ]];
        }
    }

    public static function updateProfileProductTypes(string $identifier, string $type, array $data): array 
    {
        $client = self::getClient();

        try {
            $response = $client->post(
                "/management/profile/$identifier/update-product-types/merchant",
                [
                    'body' => json_encode($data)
                ]
            );

            return ['response' => json_decode($response->getBody(), true)];
        } catch (RequestException $e) {
            return ['error' => [
                'statusCode' => $e->getResponse()->getStatusCode(),
                'response' => json_decode($e->getResponse()->getBody(), true)
            ]];
        }
    }

    public static function exchangeId(string $identifier): array
    {
        $client = self::getClient();

        try {
            $response = $client->get("/profile/exchange/id/$identifier");

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
        return new GuzzleClient([
            'base_uri' => \getenv('PROFILE_SERVICE_URI'),
            'headers' => [
                'Authorization' => 'Bearer ' . \getenv('PROFILE_SERVICE_ACCESS_TOKEN')
            ]
        ]);
    }
}
