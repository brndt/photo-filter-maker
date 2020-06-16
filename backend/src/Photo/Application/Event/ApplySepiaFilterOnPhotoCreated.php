<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Application\Event;

use claviska\SimpleImage;
use Exception;
use LaSalle\Performance\Photo\Domain\Event\PhotoCreatedDomainEvent;
use LaSalle\Performance\Photo\Domain\ImageProcessing;
use Monolog\Logger;

final class ApplySepiaFilterOnPhotoCreated
{
    private ImageProcessing $imageProcessing;

    public function __construct(ImageProcessing $imageProcessing)
    {
        $this->imageProcessing = $imageProcessing;
    }

    public function __invoke(PhotoCreatedDomainEvent $event)
    {
        $newImageUrl = $this->imageProcessing->applySepia($event->getUrl());
    }
}
