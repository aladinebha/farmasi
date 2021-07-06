<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/Commande")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/", name="Commande_index", methods={"GET"})
     */
    public function index(CommandeRepository $CommandeRepository): Response
    {
        return $this->render('Commande/index.html.twig', [
            'Commandes' => $CommandeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="Commande_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $Commande = new Commande();
        $form = $this->createForm(CommandeType::class, $Commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Commande);
            $entityManager->flush();

            return $this->redirectToRoute('Commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Commande/new.html.twig', [
            'Commande' => $Commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="Commande_show", methods={"GET"})
     */
    public function show(Commande $Commande): Response
    {
        return $this->render('Commande/show.html.twig', [
            'Commande' => $Commande,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="Commande_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commande $Commande): Response
    {
        $form = $this->createForm(CommandeType::class, $Commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Commande/edit.html.twig', [
            'Commande' => $Commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="Commande_delete", methods={"POST"})
     */
    public function delete(Request $request, Commande $Commande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$Commande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($Commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('Commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
