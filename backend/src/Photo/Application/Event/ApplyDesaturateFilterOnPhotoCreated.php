<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Application\Event;

use LaSalle\Performance\Photo\Domain\Aggregate\Photo;
use LaSalle\Performance\Photo\Domain\Event\PhotoCreatedDomainEvent;
use LaSalle\Performance\Photo\Domain\ImageProcessing;
use LaSalle\Performance\Photo\Domain\Repository\PhotoRepository;
use LaSalle\Performance\Photo\Domain\ValueObject\Filter;

final class ApplyDesaturateFilterOnPhotoCreated
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
        if (false === in_array(Filter::desaturate()->getValue(), $event->getFiltersToApply())) {
            return;
        }

        $newImageURL = $this->imageProcessing->applyDesaturate($event->getNameURL());
        $id = $this->repository->nextIdentity();
        $tags = $event->getTags();
        $description = $event->getDescription();
        $processedPhoto = new Photo($id, $newImageURL, $tags, Filter::desaturate(), $description, null);
        $this->repository->save($processedPhoto);
    }
}
