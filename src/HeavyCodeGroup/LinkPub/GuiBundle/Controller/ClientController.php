<?php

namespace HeavyCodeGroup\LinkPub\GuiBundle\Controller;

use HeavyCodeGroup\LinkPub\BaseBundle\Controller\BaseController;
use HeavyCodeGroup\LinkPub\GuiBundle\Form\Type\SearchPartnersType;
use HeavyCodeGroup\LinkPub\GuiBundle\Form\Type\SiteType;
use HeavyCodeGroup\LinkPub\StorageBundle\Doctrine\DBAL\PageStatusType;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Site;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClientController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        return $this->render('LinkPubGuiBundle:Client:dashboard.html.twig');
    }

    /**
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sitesAction($page)
    {
        $sitesRepository = $this->getDoctrine()->getRepository('LinkPubStorageBundle:Site');
        $sitesUser = $sitesRepository->findAllByUserQuery($this->getUser());
        $pagerfanta = $this->getPagerfanta($sitesUser, $page);

        return $this->render('LinkPubGuiBundle:Client:sites.html.twig', [
           'sites' => $pagerfanta->getCurrentPageResults(),
           'pagerfanta' => $pagerfanta,
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
            $site->setRootUrl(rtrim($site->getRootUrl(), '/'));
            $site->setOwner($this->getUser());
            $this->getDoctrine()->getManager()->persist($site);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('linkpub_gui_client_sites'));
        }

        return $this->render('LinkPubGuiBundle:Client:addSite.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @param $page
     * @param $siteId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sitePagesAction($siteId, $page)
    {
        $site = $this->getSite($siteId);

        $pageRepository = $this->getDoctrine()->getRepository('LinkPubStorageBundle:Page');
        $pages = $pageRepository->getPagesBySiteQuery($site);

        $pagerfanta = $this->getPagerfanta($pages, $page);

        return $this->render('LinkPubGuiBundle:Client:sitePages.html.twig', [
            'pages' => $pagerfanta->getCurrentPageResults(),
            'pagerfanta' => $pagerfanta,
        ]);
    }

    /**
     * @param $siteId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function siteInfoAction($siteId)
    {
        $consumer = $this->get('link_pub_consumer.builder');

        return $this->render('LinkPubGuiBundle:Client:siteInfo.html.twig', [
            'site' => $this->getSite($siteId),
            'consumerImplementationNames' => $consumer->getAvailableImplementationNames(),
            'consumerFormats' => $consumer->getAvailableFormats(),
        ]);
    }

    public function searchPartnersAction($siteId, $page, Request $request)
    {
        $site = $this->getSite($siteId);

        $form = $this->createForm(new SearchPartnersType());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $criteria = $form->getData();
            $criteria['state'] = PageStatusType::STATUS_ACTIVE;
            $criteria['user'] = $this->getUser();

            $pagesRepository = $this->getDoctrine()->getRepository('LinkPubStorageBundle:Page');
            $pagesQuery = $pagesRepository->getPagesByCriteriaQuery($criteria);
            $pagerfanta = $this->getPagerfanta($pagesQuery, $page);

            return $this->render('LinkPubGuiBundle:Client:searchPartnersFoundPages.html.twig', [
                'pages' => $pagerfanta->getCurrentPageResults(),
                'pagerfanta' => $pagerfanta,
            ]);

        }

        return $this->render('LinkPubGuiBundle:Client:searchPartners.html.twig', ['form' => $form->createView()]);
    }

    public function siteInComingLinksAction($siteId, $page)
    {
        $site = $this->getSite($siteId);
        $pageRepository = $this->getDoctrine()->getRepository('LinkPubStorageBundle:Link');
        $links = $pageRepository->getInComingBySiteQuery($site);

        return $this->renderLinks($links, $page, $siteId);
    }

    public function siteOutGoingLinksAction($siteId, $page)
    {
        $site = $this->getSite($siteId);
        $pageRepository = $this->getDoctrine()->getRepository('LinkPubStorageBundle:Link');
        $links = $pageRepository->getOutGoingBySiteQuery($site);

        return $this->renderLinks($links, $page);
    }

    public function inComingLinksAction($page)
    {

    }

    public function outGoingLinksAction($page)
    {
        return $this->render('LinkPubGuiBundle:Client:links.html.twig');
    }

    public function addIncomingLinkAction($siteId)
    {
        $site = $this->getSite($siteId);

        return $this->render('LinkPubGuiBundle:Client:addIncomingLink.html.twig');
    }

    /**
     * @param $siteId
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    private function getSite($siteId)
    {
        $siteRepository = $this->getDoctrine()->getRepository('LinkPubStorageBundle:Site');
        $site = $siteRepository->findOneByIdOrGuid($siteId);

        if (!$site) {
            throw new NotFoundHttpException("Site with id $siteId not found");
        }

        return $site;
    }

    private function renderLinks($links, $page, $siteId = null)
    {
        $pagerfanta = $this->getPagerfanta($links, $page);

        return $this->render('LinkPubGuiBundle:Client:links.html.twig', [
            'links' => $pagerfanta->getCurrentPageResults(),
            'pagerfanta' => $pagerfanta,
            'siteId' => $siteId,
        ]);
    }
}
