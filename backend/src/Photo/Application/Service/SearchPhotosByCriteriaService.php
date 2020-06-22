<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Application\Service;

use LaSalle\Performance\Photo\Application\Request\SearchPhotosByCriteriaRequest;
use LaSalle\Performance\Photo\Application\Response\PhotoCollectionResponse;
use LaSalle\Performance\Photo\Application\Response\PhotoResponse;
use LaSalle\Performance\Photo\Domain\Aggregate\Photo;
use LaSalle\Performance\Photo\Domain\Repository\PhotoSearchEngineRepository;
use LaSalle\Performance\Shared\Domain\Criteria\Criteria;
use LaSalle\Performance\Shared\Domain\Criteria\Filters;
use LaSalle\Performance\Shared\Domain\Criteria\Order;

final class SearchPhotosByCriteriaService
{
    private PhotoSearchEngineRepository $repository;

    public function __construct(PhotoSearchEngineRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(SearchPhotosByCriteriaRequest $request): PhotoCollectionResponse
    {
        $criteria = new Criteria(
            Filters::fromValues($request->getFilters()),
            Order::fromValues($request->getOrderBy(), $request->getOrder()),
            $request->getOffset(),
            $request->getLimit()
        );

        $arrayOfPhotos = $this->repository->byCriteria($criteria);

        return new PhotoCollectionResponse(
            array_map(fn(Photo $photo) => $this->buildPhotoResponse($photo), $arrayOfPhotos)
        );
    }

    private function buildPhotoResponse(Photo $photo)
    {
        return new PhotoResponse(
            $photo->getId()->toString(),
            $photo->getNameURL(),
            $photo->getTags(),
            $photo->getFilter()->getValue(),
            $photo->getDescription(),
            $photo->getFiltersToApply()->toArrayOfPrimitives(),
            $photo->getCreatedAt()
        );
    }
}
