<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Infrastructure\Framework;

use claviska\SimpleImage;
use Doctrine\Common\Cache\PredisCache;
use Doctrine\Common\Cache\RedisCache;
use Exception;
use LaSalle\Performance\Photo\Domain\Photo;
use LaSalle\Performance\Photo\Domain\ValueObject\Uuid;
use LaSalle\Performance\Photo\Infrastructure\Persistence\Doctrine\Repository\DoctrineMysqlRepository;
use LaSalle\Performance\Shared\Domain\EventBus;
use Predis\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SaveImageController extends AbstractController
{
    private DoctrineMysqlRepository $repository;
    private EventBus $eventBus;

    public function __construct(DoctrineMysqlRepository $repository, EventBus $eventBus)
    {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }

    /**
     * @Route("/image", methods={"POST"})
     */
    public function postAction(Request $request, Client $redis)
    {
        $file = $request->files->get('file');
        $name = $file->getClientOriginalName();
        $file->move(
            $this->getParameter('imagesDirectory'),
            $name
        );

        $id = new Uuid($request->request->get('id'));
        $tags = $request->request->get('tags');
        $description = $request->request->get('description');

        $tags = explode(",", $tags);
        $photo = Photo::create($id, $name, $tags, $description);

        foreach ($photo->pullDomainEvents() as $domainEvent) {
            $this->eventBus->dispatch($domainEvent);
        }

        //$this->repository->save($photo);
        //$photo1 = $this->repository->ofId($id);

        $redis->set('hola', 'mundo');
        return new JsonResponse($photo->getTags(), Response::HTTP_OK);
    }
}
