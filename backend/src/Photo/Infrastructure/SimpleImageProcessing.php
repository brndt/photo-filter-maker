<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Infrastructure;

use claviska\SimpleImage;
use Exception;
use LaSalle\Performance\Photo\Domain\ImageProcessing;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class SimpleImageProcessing implements ImageProcessing
{
    private ParameterBagInterface $parameters;

    public function __construct(ParameterBagInterface $parameters)
    {
        $this->parameters = $parameters;
    }

    public function applySepia(string $imageUrl)
    {
        $newImageUrl = $this->parameters->get('imagesDirectory') . '1' . $imageUrl;

        try {
            $image = new SimpleImage();
            $image
                ->fromFile(
                    $this->parameters->get('imagesDirectory') . $imageUrl
                )
                ->sepia()
                ->toFile(
                    $newImageUrl
                );      // convert to PNG and save a copy to new-image.png
            // And much more! 💪
        } catch (Exception $err) {
            // Handle errors
        }
        return $newImageUrl;
    }

    public function applyDesaturate(string $imageUrl)
    {
        $newImageUrl = $this->parameters->get('imagesDirectory') . '2' . $imageUrl;

        try {
            $image = new SimpleImage();
            $image
                ->fromFile(
                    $this->parameters->get('imagesDirectory') . $imageUrl
                )
                ->desaturate()
                ->toFile(
                    $newImageUrl
                );      // convert to PNG and save a copy to new-image.png
            // And much more! 💪
        } catch (Exception $err) {
            // Handle errors
        }
        return $newImageUrl;
    }
}
