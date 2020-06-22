<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Application\Event;

use DateTimeImmutable;
use LaSalle\Performance\Photo\Domain\Aggregate\Photo;
use LaSalle\Performance\Photo\Domain\Event\PhotoCreatedDomainEvent;
use LaSalle\Performance\Photo\Domain\ImageProcessing;
use LaSalle\Performance\Photo\Domain\Repository\PhotoRepository;
use LaSalle\Performance\Photo\Domain\ValueObject\Filter;
use LaSalle\Performance\Photo\Domain\ValueObject\FiltersToApply;

final class ApplyBlurFilterOnPhotoCreated
{
    private ImageProcessing $imageProcessing;
    private PhotoRepository $repository;

    public function __construct(PhotoRepository $repository, ImageProcessing $imageProcessing)
    {
        $this->imageProcessing = $imageProcessing;
        $this->repository = $repository;
    }

    public function __invoke(PhotoCreatedDomainEvent $event)
    {
        if (false === in_array(Filter::blur()->getValue(), $event->getFiltersToApply())) {
            return;
        }

        $newImageURL = $this->imageProcessing->applyBlur($event->getNameURL());
        $id = $this->repository->nextIdentity();
        $tags = $event->getTags();
        $description = $event->getDescription();
        $createdAt = new DateTimeImmutable();

        $processedPhoto = new Photo(
            $id,
            $newImageURL,
            $tags,
            Filter::blur(),
            $description,
            FiltersToApply::fromArrayOfPrimitives([]),
            $createdAt
        );
        $this->repository->save($processedPhoto);
    }
}
