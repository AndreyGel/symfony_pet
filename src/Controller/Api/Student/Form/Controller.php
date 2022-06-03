<?php

namespace App\Controller\Api\Student\Form;

use App\DTO\CreateStudentDTO;
use App\Entity\Student;
use App\Manager\StudentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

class Controller extends AbstractController
{
    private StudentManager $studentManager;
    private Environment $twig;

    public function __construct(StudentManager $studentManager, Environment $twig)
    {
        $this->studentManager = $studentManager;
        $this->twig = $twig;
    }

    /**
     * @Route("/form/student", methods={"GET"})
     */
    public function getForm(): Response
    {
        $form = $this->studentManager->getSaveForm();
        $content = $this->twig->render('form.twig', [
            'form' => $form->createView(),
        ]);

        return new Response($content);
    }

    /**
     * @Route("/form/student", methods={"POST"})
     */
    public function saveStudentFormAction(Request $request, ValidatorInterface $validator): Response
    {
        $form = $this->studentManager->getSaveForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($dto = new CreateStudentDTO($form->getData()));

            if (count($errors) > 0) {
                return new JsonResponse(['success' => false, 'errorMessage' => (string)$errors], 400);
            }

            $studentId = $this->studentManager->saveStudentFromDTO(new Student(), $dto);

            if ($studentId === null) {
                return new JsonResponse(['success' => false], 400);
            }

            return  new JsonResponse(['id' => $studentId]);
        }
        $content = $this->twig->render('form.twig', [
            'form' => $form->createView(),
        ]);

        return new Response($content);
    }
}
