<?php

namespace App\Controller;

use App\Entity\WebsiteHandler;
use App\Form\WebsiteHandlerType;
use App\Repository\WebsiteHandlerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/websitehandler")
 */
class WebsiteHandlerController extends AbstractController
{
    /**
     * @Route("/", name="websitehandler_index", methods={"GET"})
     */
    public function index(WebsiteHandlerRepository $websiteHandlerRepository): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('website_handler/index.html.twig', [
            'website_handlers' => $websiteHandlerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="websitehandler_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $websiteHandler = new WebsiteHandler();
        $form = $this->createForm(WebsiteHandlerType::class, $websiteHandler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($websiteHandler);
            $entityManager->flush();

            return $this->redirectToRoute('websitehandler_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('website_handler/new.html.twig', [
            'website_handler' => $websiteHandler,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="websitehandler_show", methods={"GET"})
     */
    public function show(WebsiteHandler $websiteHandler): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('website_handler/show.html.twig', [
            'website_handler' => $websiteHandler,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="websitehandler_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, WebsiteHandler $websiteHandler, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(WebsiteHandlerType::class, $websiteHandler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('websitehandler_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('website_handler/edit.html.twig', [
            'website_handler' => $websiteHandler,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="websitehandler_delete", methods={"POST"})
     */
    public function delete(Request $request, WebsiteHandler $websiteHandler, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->isCsrfTokenValid('delete'.$websiteHandler->getId(), $request->request->get('_token'))) {
            $entityManager->remove($websiteHandler);
            $entityManager->flush();
        }

        return $this->redirectToRoute('websitehandler_index', [], Response::HTTP_SEE_OTHER);
    }
}
