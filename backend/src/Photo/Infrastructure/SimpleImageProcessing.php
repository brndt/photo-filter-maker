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

    public function applyDesaturate(string $imageUrl)
    {
        $newImageUrl = $this->parameters->get('imagesDirectory') . 'desaturate-' . $imageUrl;
        try {
            $image = new SimpleImage();
            $image
                ->fromFile($this->parameters->get('imagesDirectory') . $imageUrl)
                ->desaturate()
                ->toFile($newImageUrl);
        } catch (Exception $err) {
        }
        return 'desaturate-' . $imageUrl;
    }

    public function applySepia(string $imageUrl)
    {
        $newImageUrl = $this->parameters->get('imagesDirectory') . 'sepia-' . $imageUrl;
        try {
            $image = new SimpleImage();
            $image
                ->fromFile($this->parameters->get('imagesDirectory') . $imageUrl)
                ->sepia()
                ->toFile($newImageUrl);
        } catch (Exception $err) {
        }
        return 'sepia-' . $imageUrl;
    }

    public function applySharpen(string $imageUrl)
    {
        $newImageUrl = $this->parameters->get('imagesDirectory') . 'sharpen-' . $imageUrl;
        try {
            $image = new SimpleImage();
            $image
                ->fromFile($this->parameters->get('imagesDirectory') . $imageUrl)
                ->sharpen()
                ->toFile($newImageUrl);
        } catch (Exception $err) {
        }
        return 'sharpen-' . $imageUrl;
    }

    public function applySketch(string $imageUrl)
    {
        $newImageUrl = $this->parameters->get('imagesDirectory') . 'sketch-' . $imageUrl;
        try {
            $image = new SimpleImage();
            $image
                ->fromFile($this->parameters->get('imagesDirectory') . $imageUrl)
                ->sketch()
                ->toFile($newImageUrl);
        } catch (Exception $err) {
        }
        return 'sketch-' . $imageUrl;
    }

    public function applyBlur(string $imageUrl)
    {
        $newImageUrl = $this->parameters->get('imagesDirectory') . 'blur-' . $imageUrl;
        try {
            $image = new SimpleImage();
            $image
                ->fromFile($this->parameters->get('imagesDirectory') . $imageUrl)
                ->blur('selective', 50)
                ->toFile($newImageUrl);
        } catch (Exception $err) {
        }
        return 'blur-' . $imageUrl;
    }
}
