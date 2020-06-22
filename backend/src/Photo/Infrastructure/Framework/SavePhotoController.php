<?php

declare(strict_types=1);

namespace LaSalle\Performance\Photo\Infrastructure\Framework;

use LaSalle\Performance\Photo\Application\Request\SavePhotoRequest;
use LaSalle\Performance\Photo\Application\Service\SaveOriginalPhotoService;
use LaSalle\Performance\Photo\Domain\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class SavePhotoController extends AbstractController
{
    private SaveOriginalPhotoService $savePhotoService;
    private PhotoRepository $photoRepository;
    private ValidatorInterface $validator;

    public function __construct(
        SaveOriginalPhotoService $savePhotoService,
        PhotoRepository $photoRepository,
        ValidatorInterface $validator
    ) {
        $this->savePhotoService = $savePhotoService;
        $this->photoRepository = $photoRepository;
        $this->validator = $validator;
    }

    /**
     * @Route("/photo", methods={"POST"})
     */
    public function postAction(Request $request)
    {
        $image = $request->files->get('file');

        $violations = $this->validator->validate($image, [new Image(['maxSize' => '3M'])]);

        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $response[] = $violation->getMessage();
            }
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $imageURL = $image->getClientOriginalName();
        $image->move($this->getParameter('imagesDirectory'), $imageURL);

        $tags = explode(",", $request->request->get('tags'));
        $filters = true === empty($request->request->get('filters')) ? [] : explode(
            ",",
            $request->request->get('filters')
        );
        $description = $request->request->get('description');

        ($this->savePhotoService)(new SavePhotoRequest($imageURL, $tags, $description, $filters));

        return new JsonResponse('Photo has been successfully saved', Response::HTTP_OK);
    }
}
