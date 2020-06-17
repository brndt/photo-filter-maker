<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use LaSalle\Performance\Photo\Domain\Aggregate\Photo;
use LaSalle\Performance\Photo\Domain\Repository\PhotoRepository;
use LaSalle\Performance\Photo\Domain\ValueObject\Filter;
use LaSalle\Performance\Photo\Domain\ValueObject\Uuid;
use Predis\Client;

final class DoctrineMysqlRepository implements PhotoRepository
{
    private EntityManagerInterface $entityManager;
    private Client $redis;

    public function __construct(EntityManagerInterface $entityManager, Client $redis)
    {
        $this->entityManager = $entityManager;
        $this->redis = $redis;
    }

    public function save(Photo $photo): void
    {
        $this->redis->set($photo->getId()->toString(), json_encode($photo->toPrimitives()));
        $this->entityManager->persist($photo);
        $this->entityManager->flush();
    }

    /**
     * @return object|Photo|null
     */
    public function ofId(Uuid $id): ?Photo
    {
        $photoAsJson = $this->redis->get($id->toString());
        if (null !== $photoAsJson) {
            return $this->buildPhotoFromPrimitives(json_decode($photoAsJson, true));
        }
        return $this->entityManager->getRepository(Photo::class)->find($id);
    }

    public function nextIdentity(): Uuid
    {
        return Uuid::generate();
    }

    private function buildPhotoFromPrimitives(array $photoAsArray): Photo
    {
        return new Photo(
            new Uuid($photoAsArray['id']),
            $photoAsArray['nameURL'],
            $photoAsArray['tags'],
            Filter::make($photoAsArray['filter']),
            $photoAsArray['description'],
            $photoAsArray['filtersToApply']
        );
    }
}
