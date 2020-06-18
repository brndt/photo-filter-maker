<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Infrastructure\Framework;

use FOS\ElasticaBundle\Elastica\Client;
use LaSalle\Performance\Shared\Domain\Criteria\Criteria;
use LaSalle\Performance\Shared\Domain\Criteria\FilterOperator;
use LaSalle\Performance\Shared\Domain\Criteria\Filters;
use LaSalle\Performance\Shared\Domain\Criteria\Order;
use LaSalle\Performance\Shared\Infrastructure\Persistence\Elasticsearch\ElasticsearchCriteriaConverter;
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

        $criteria = new Criteria(Filters::fromValues([['field' => 'tags', 'operator' => 'equal', 'value' => $keyword]]),Order::fromValues('filter', 'desc'),null,10);
        $converter = new ElasticsearchCriteriaConverter();

        $query = $converter->convert($criteria);

        $response = $this->elasticClient->getIndex('photo');
        $elasticResponse = $response->search($query);
        $arrayResponse = array_map(fn($result) => $result->getData(), $elasticResponse->getResults());
        return new JsonResponse($arrayResponse, Response::HTTP_OK);
    }
}
