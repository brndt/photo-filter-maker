<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Infrastructure\Persistence\Elasticsearch;

use DateTimeImmutable;
use Elastica\Result;
use FOS\ElasticaBundle\Elastica\Client;
use LaSalle\Performance\Photo\Domain\Aggregate\Photo;
use LaSalle\Performance\Photo\Domain\Repository\PhotoSearchEngineRepository;
use LaSalle\Performance\Photo\Domain\ValueObject\Filter;
use LaSalle\Performance\Photo\Domain\ValueObject\FiltersToApply;
use LaSalle\Performance\Photo\Domain\ValueObject\Uuid;
use LaSalle\Performance\Shared\Domain\Criteria\Criteria;
use LaSalle\Performance\Shared\Infrastructure\Persistence\Elasticsearch\ElasticsearchCriteriaConverter;

final class ElasticsearchPhotoRepository implements PhotoSearchEngineRepository
{
    private Client $elasticClient;

    public function __construct(Client $elasticClient)
    {
        $this->elasticClient = $elasticClient;
    }

    public function byCriteria(Criteria $criteria): array
    {
        $converter = new ElasticsearchCriteriaConverter();
        $query = $converter->convert($criteria);
        $response = $this->elasticClient->getIndex('photo');
        $elasticResponse = $response->search($query);
        return array_map(fn (Result $photoAsArray) => $this->buildPhotoFromPrimitives($photoAsArray), $elasticResponse->getResults());
    }

    private function buildPhotoFromPrimitives(Result $photoAsArray): Photo
    {
        return new Photo(
            new Uuid($photoAsArray->getData()['id']),
            $photoAsArray->getData()['nameURL'],
            $photoAsArray->getData()['tags'],
            Filter::make($photoAsArray->getData()['filter']),
            $photoAsArray->getData()['description'],
            FiltersToApply::fromArrayOfPrimitives([]),
            new DateTimeImmutable($photoAsArray->getData()['createdAt']),
        );
    }
}
