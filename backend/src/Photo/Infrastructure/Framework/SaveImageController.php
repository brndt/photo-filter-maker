<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Infrastructure\Framework;

use Doctrine\Common\Cache\PredisCache;
use Doctrine\Common\Cache\RedisCache;
use LaSalle\Performance\Photo\Domain\Photo;
use LaSalle\Performance\Photo\Domain\ValueObject\Uuid;
use LaSalle\Performance\Photo\Infrastructure\Persistence\Doctrine\Repository\DoctrineMysqlRepository;
use Predis\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SaveImageController extends AbstractController
{
    private DoctrineMysqlRepository $repository;

    public function __construct(DoctrineMysqlRepository $repository)
    {
        $this->repository = $repository;
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
        $photo = new Photo($id, $name, $tags, $description);
        $this->repository->save($photo);
        $photo1 = $this->repository->ofId($id);

        $redis->set('hola', 'mundo');
        return new JsonResponse($photo1->getTags(), Response::HTTP_OK);
    }
}
