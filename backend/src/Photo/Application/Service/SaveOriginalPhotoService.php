<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Application\Service;

use LaSalle\Performance\Photo\Application\Request\SavePhotoRequest;
use LaSalle\Performance\Photo\Domain\Aggregate\Photo;
use LaSalle\Performance\Photo\Domain\Repository\PhotoRepository;
use LaSalle\Performance\Photo\Domain\ValueObject\Filter;
use LaSalle\Performance\Photo\Domain\ValueObject\FiltersToApply;
use LaSalle\Performance\Shared\Domain\Event\EventBus;

final class SaveOriginalPhotoService
{
    private PhotoRepository $repository;
    private EventBus $eventBus;

    public function __construct(PhotoRepository $repository, EventBus $eventBus)
    {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(SavePhotoRequest $request)
    {
        $id = $this->repository->nextIdentity();
        $tags = $request->getTags();
        $nameURL = $request->getNameURL();
        $description = $request->getDescription();
        $filter = Filter::original();
        $filtersToApply = FiltersToApply::fromArrayOfPrimitives($request->getFilters());

        $photo = Photo::create($id, $nameURL, $tags, $filter, $description, $filtersToApply);
        $this->repository->save($photo);
        foreach ($photo->pullDomainEvents() as $domainEvent) {
            $this->eventBus->dispatch($domainEvent);
        }
    }
}
