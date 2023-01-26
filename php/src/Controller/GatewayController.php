<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\ProfileService;
use App\Service\ProductService;

class GatewayController extends Controller
{
    public function options(Request $request, JsonResponse $response): JsonResponse
    {
        return $response;
    }

    public function profileFilters(Request $request, JsonResponse $response): JsonResponse
    {
        return $this->setResponse(
            $response,
            ProfileService::filters()
        );
    }

    public function filterProfiles(Request $request, JsonResponse $response): JsonResponse
    {
        return $this->setResponse(
            $response,
            ProfileService::filter(
                $request->query->get('page', 1),
                $request->request->all()
            )
        );
    }

    public function profilesOnline(Request $request, JsonResponse $response): JsonResponse
    {
        return $this->setResponse(
            $response,
            ProfileService::profilesOnline()
        );
    }

    public function showProfile(Request $request, JsonResponse $response): JsonResponse
    {
        return $this->setResponse(
            $response,
            ProfileService::show($request->query->get('identifier'))
        );
    }

    public function getProfile(Request $request, JsonResponse $response): JsonResponse
    {
        return $this->setResponse(
            $response,
            ProfileService::getProfile($request->query->get('identifier'), $request->query->get('type'))
        );
    }

    public function saveProfile(Request $request, JsonResponse $response): JsonResponse
    {
        return $this->setResponse(
            $response,
            ProfileService::save(
                $request->query->get('identifier'),
                $request->request->all()
            )
        );
    }

    public function online(Request $request, JsonResponse $response): JsonResponse
    {
        return $this->setResponse(
            $response,
            ProfileService::online($request->query->get('identifier'), $request->query->get('type'))
        );
    }

    public function offline(Request $request, JsonResponse $response): JsonResponse
    {
        return $this->setResponse(
            $response,
            ProfileService::offline($request->query->get('identifier'), $request->query->get('type'))
        );
    }

    public function avatar(Request $request, JsonResponse $response): JsonResponse
    {
        return $this->setResponse(
            $response,
            ProfileService::avatar($request->query->get('identifier'), $request->query->get('type'), $request->request->get('avatar'))
        );
    }

    public function cover(Request $request, JsonResponse $response): JsonResponse
    {
        return $this->setResponse(
            $response,
            ProfileService::cover($request->query->get('identifier'), $request->query->get('type'), $request->request->get('cover'))
        );
    }

    public function updateProfileProductTypes(Request $request, JsonResponse $response): JsonResponse
    {
        return $this->setResponse(
            $response,
            ProfileService::updateProfileProductTypes(
                $request->query->get('identifier'),
                $request->query->get('type'),
                $request->request->all())
        );
    }

    public function saveProduct(Request $request, JsonResponse $response): JsonResponse
    {
        return $this->setResponse(
            $response,
            ProductService::save(
                $request->query->get('identifier'),
                $request->query->get('type'),
                $request->request->all()
            )
        );
    }

    public function deleteProduct(Request $request, JsonResponse $response): JsonResponse
    {
        return $this->setResponse(
            $response,
            ProductService::delete(
                $request->query->get('identifier'),
                $request->query->get('type')
            )
        );
    }

    public function profileProducts(Request $request, JsonResponse $response): JsonResponse
    {
        $data = ProfileService::exchangeId($request->query->get('identifier'));

        if (isset($data['error'])) {
            return $response
                ->setStatusCode($data['error']['statusCode'])
                ->setData($data['error']['response'])
            ;
        }

        return $this->setResponse(
            $response,
            ProductService::profileProducts($data['response'])
        );
    }

    private function setResponse(JsonResponse $response, array $data): JsonResponse
    {
        if (isset($data['error'])) {
            return $response
                ->setStatusCode($data['error']['statusCode'])
                ->setData($data['error']['response'])
            ;
        }

        return $response->setData($data['response']);
    }

}
