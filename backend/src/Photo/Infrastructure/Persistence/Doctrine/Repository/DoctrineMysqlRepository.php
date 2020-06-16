<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use LaSalle\Performance\Photo\Domain\Photo;
use LaSalle\Performance\Photo\Domain\Repository\PhotoRepository;
use LaSalle\Performance\Photo\Domain\ValueObject\Uuid;

final class DoctrineMysqlRepository implements PhotoRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Photo $photo): void
    {
        $this->entityManager->persist($photo);
        $this->entityManager->flush();
    }

    /**
     * @return object|Photo|null
     */
    public function ofId(Uuid $id): ?Photo
    {
        return $this->entityManager->getRepository(Photo::class)->find($id);
    }
}
