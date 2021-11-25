<?php

namespace App\Controller;

use App\Entity\WebsiteHandler;
use App\Entity\WebsiteStatus;
use App\Form\WebsiteHandlerType;
use App\Repository\WebsiteHandlerRepository;
use App\Repository\WebsiteStatusRepository; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\AreaChart;

use Symfony\Component\Validator\Constraints\DateTime;; 

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

        $date = new \DateTime('@'.strtotime('now'));

        $client = HttpClient::create();

        $websiteHandler = new WebsiteHandler();
        $websiteStatus = new WebsiteStatus();
        $form = $this->createForm(WebsiteHandlerType::class, $websiteHandler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
            $response = $client->request('GET', $websiteHandler->getUrl());
            $websiteHandler->setStatus($response->getStatusCode()); 
            
            $response = $client->request('GET', $websiteHandler->getUrl());
            $websiteStatus->setWebsite($websiteHandler); 
            $websiteStatus->setStatus($response->getStatusCode()); 
            $websiteStatus->setCreatedAt($date); 

            $entityManager->persist($websiteStatus);
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
    public function show(WebsiteHandler $websiteHandler, WebsiteStatusRepository $websiteStatusRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $query = $websiteStatusRepository->findAllCreatedAtByWebsiteId($websiteHandler);
        $area = new AreaChart();

        foreach($query as $v) {
            $area->getData()->setArrayToDataTable(
            [
                ['Date', 'Response'],
                [$v['created_at'],$v['status']]
            ]);
        }

        $area->getOptions()->setTitle('HTTP Status');
        $area->getOptions()->getHAxis()->setTitle('Date');
        $area->getOptions()->getHAxis()->setFormat('h:mm a yyyy');
        $area->getOptions()->getHAxis()->getTitleTextStyle()->setColor('#333');
        $area->getOptions()->getVAxis()->setMinValue(0);
        $area->getOptions()->getVAxis()->setMaxValue(524);

        return $this->render('website_handler/show.html.twig', [
            'website_handler' => $websiteHandler,
            'area' => $area
        ]);
    }

    /**
     * @Route("/{id}/edit", name="websitehandler_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, WebsiteHandler $websiteHandler, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $date = new \DateTime('@'.strtotime('now'));

        $client = HttpClient::create();

        $websiteStatus = new WebsiteStatus();

        $form = $this->createForm(WebsiteHandlerType::class, $websiteHandler);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {

            $response = $client->request('GET', $websiteHandler->getUrl());
            
            $websiteHandler->setStatus($response->getStatusCode()); 

            $websiteStatus->setWebsite($websiteHandler); 
            $websiteStatus->setStatus($response->getStatusCode()); 
            $websiteStatus->setCreatedAt($date); 

            $entityManager->persist($websiteStatus);
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

        if ($this->isCsrfTokenValid('delete' . $websiteHandler->getId(), $request->request->get('_token'))) {
            $entityManager->remove($websiteHandler);
            $entityManager->flush();
        }

        return $this->redirectToRoute('websitehandler_index', [], Response::HTTP_SEE_OTHER);
    }

}
