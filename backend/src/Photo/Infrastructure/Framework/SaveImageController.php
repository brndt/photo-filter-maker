<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Infrastructure\Framework;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SaveImageController extends AbstractController
{
    /**
     * @Route("/image", methods={"POST"})
     */
    public function postAction(Request $request)
    {
        $file = $request->files->get('file');
        $name = $file->getClientOriginalName();
        $file->move(
            $this->getParameter('imagesDirectory'),
            $name
        );
        $something = $request->files->get('file');
        $file = $request->request->all();
        return new JsonResponse($name, Response::HTTP_OK);
    }
}
