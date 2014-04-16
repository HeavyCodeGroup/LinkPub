<?php

namespace HeavyCodeGroup\LinkPub\GuiBundle\Controller;

use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClientController extends Controller
{
    public function dashboardAction()
    {
        return $this->render('LinkPubGuiBundle:Client:dashboard.html.twig');
    }

    public function sitesAction($page)
    {
        $sitesRepository = $this->getDoctrine()->getRepository('LinkPubStorageBundle:Site');
        $sitesUser = $sitesRepository->findAllByUserQuery($this->getUser());

        $adapter = new DoctrineORMAdapter($sitesUser);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($this->container->getParameter('sites_per_page'));
        $pagerfanta->setCurrentPage($page);

        return $this->render('LinkPubGuiBundle:Client:sites.html.twig', [
           'sites' => $pagerfanta->getCurrentPageResults(),
           'pagerfanta' => $pagerfanta
        ]);
    }

    public function incomingLinksAction()
    {
        return $this->render('LinkPubGuiBundle:Client:incomingLinks.html.twig');
    }

    public function outgoingLinksAction()
    {
        return $this->render('LinkPubGuiBundle:Client:outgoingLinks.html.twig');
    }
}
