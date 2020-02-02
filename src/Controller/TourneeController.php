<?php

namespace App\Controller;

use App\Entity\Tournee;
use App\Form\TourneeType;
use App\Repository\TourneeRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/tournee")
 */
class TourneeController extends AbstractController
{
    /**
     * @Route("/", name="tournee_index", methods={"GET"})
     */
    public function index(TourneeRepository $tourneeRepository): Response
    {
        return $this->render('tournee/index.html.twig', [
            'tournees' => $tourneeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tournee_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $tournee = new Tournee();
        $form = $this->createForm(TourneeType::class, $tournee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form['image']->getData();
            if ($image) {
                $imageFile =$fileUploader->upload($image, 'images');
                $tournee->setImage($imageFile);
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tournee);
            $entityManager->flush();

            $this->addFlash(
                'success',
                "Votre nouvel tournee a bien été ajouté"
            );

            return $this->redirectToRoute('tournee_index');
        }

        return $this->render('tournee/new.html.twig', [
            'tournee' => $tournee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tournee_show", methods={"GET"})
     */
    public function show(Tournee $tournee): Response
    {
        return $this->render('tournee/show.html.twig', [
            'tournee' => $tournee,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tournee_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tournee $tournee, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(TourneeType::class, $tournee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form['image']->getData();
            if (!empty($image)) {
                $imageFile = $fileUploader->upload($image, 'images');
                $tournee->setImage($imageFile);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tournee_index');
        }

        return $this->render('tournee/edit.html.twig', [
            'tournee' => $tournee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tournee_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tournee $tournee): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tournee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tournee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tournee_index');
    }
}
