<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Domain;

interface ImageProcessing
{
    public function applySepia(string $imageUrl);
    public function applyBlur(string $imageUrl);
    public function applySharpen(string $imageUrl);
    public function applyDesaturate(string $imageUrl);
    public function applySketch(string $imageUrl);
}
