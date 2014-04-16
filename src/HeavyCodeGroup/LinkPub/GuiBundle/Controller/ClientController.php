<?php

namespace HeavyCodeGroup\LinkPub\GuiBundle\Controller;

use HeavyCodeGroup\LinkPub\GuiBundle\Form\Type\SiteType;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Site;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        return $this->render('LinkPubGuiBundle:Client:dashboard.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function incomingLinksAction()
    {
        return $this->render('LinkPubGuiBundle:Client:incomingLinks.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function outgoingLinksAction()
    {
        return $this->render('LinkPubGuiBundle:Client:outgoingLinks.html.twig');
    }

    /**
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addSiteAction(Request $request)
    {
        $form = $this->createForm(new SiteType());
        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var Site $site */
            $site = $form->getData();
            $site->setOwner($this->getUser());
            $this->getDoctrine()->getManager()->persist($site);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('linkpub_gui_client_sites'));
        }

        return $this->render('LinkPubGuiBundle:Client:addSite.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param $siteId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sitePagesAction($siteId)
    {
        $siteRepository = $this->getDoctrine()->getRepository('LinkPubStorageBundle:Site');
        $site = $siteRepository->findOneByIdOrGuid($siteId);

        return $this->render('LinkPubGuiBundle:Client:sitePages.html.twig');
    }
}
