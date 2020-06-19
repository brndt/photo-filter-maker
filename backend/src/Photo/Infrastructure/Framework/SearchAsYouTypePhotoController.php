<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Infrastructure\Framework;

use FOS\ElasticaBundle\Elastica\Client;
use LaSalle\Performance\Photo\Application\Request\SearchPhotosByCriteriaRequest;
use LaSalle\Performance\Photo\Application\Service\SearchPhotosByCriteriaService;
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
use Symfony\Component\Serializer\SerializerInterface;

final class SearchAsYouTypePhotoController extends AbstractController
{
    private SearchPhotosByCriteriaService $searchPhotos;

    public function __construct(SearchPhotosByCriteriaService $searchPhotos)
    {
        $this->searchPhotos = $searchPhotos;
    }

    /**
     * @Route("/photo", methods={"GET"})
     */
    public function getAction(Request $request, SerializerInterface $serializer)
    {
        $filters = $request->query->get('filters') ?? [];
        $validatedFilters = $this->validateFilters($filters);
        $transformedFilters = $this->transformFilters($validatedFilters);
        $orderBy = $request->get('orderBy') ?? null;
        $order = $request->get('order') ?? 'none';
        $offset = (int) $request->get('offset') ?? 0;
        $limit = (int) $request->get('limit') ?? 10;

        $photoCollection = ($this->searchPhotos)(new SearchPhotosByCriteriaRequest($transformedFilters, $orderBy, $order, $offset, $limit));
        $serializer->serialize($photoCollection, 'json');
        return JsonResponse::fromJsonString($serializer->serialize($photoCollection, 'json'), Response::HTTP_OK);
    }

    private function validateFilters($filters) {
        return array_filter($filters, fn(string $key) => in_array($key, ['filter', 'tags', 'description']),ARRAY_FILTER_USE_KEY);
    }

    private function transformFilters($filters) {
        return array_map(fn(string $key, string $value) => ['field' => $key, 'operator' => 'equal', 'value' => $value], array_keys($filters), $filters);
    }
}
