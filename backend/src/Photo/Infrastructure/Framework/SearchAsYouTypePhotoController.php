<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Infrastructure\Framework;

use FOS\ElasticaBundle\Elastica\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SearchAsYouTypePhotoController extends AbstractController
{
    private Client $elasticClient;

    public function __construct(Client $elasticClient)
    {
        $this->elasticClient = $elasticClient;
    }

    /**
     * @Route("/photo", methods={"GET"})
     */
    public function getAction(Request $request)
    {
        $keyword = $request->get('keyword');

        $params = [
                'query' => [
                    'match' => [
                        'nameURL' => [
                            'query' => $keyword,
                            'operator' => 'and'
                        ]
                    ]
                ]
        ];

        $response = $this->elasticClient->getIndex('photo');
        $elasticResponse = $response->search($params);
        $arrayResponse = array_map(fn($result) => $result->getData(), $elasticResponse->getResults());
        return new JsonResponse($arrayResponse, Response::HTTP_OK);
    }
}
