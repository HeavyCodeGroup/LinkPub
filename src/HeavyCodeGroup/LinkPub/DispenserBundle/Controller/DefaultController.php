<?php

namespace HeavyCodeGroup\LinkPub\DispenserBundle\Controller;

use HeavyCodeGroup\LinkPub\DispenserBundle\Repository;
use HeavyCodeGroup\LinkPub\DispenserBundle\Site;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends AbstractController
{
    /**
     * @var integer
     */
    protected $dispenseInterval;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @param Repository $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $dispenseInterval
     */
    public function setDispenseInterval($dispenseInterval)
    {
        $this->dispenseInterval = $dispenseInterval;
    }

    public function indexAction(Request $request)
    {
        $guid = $request->get('guid');
        $siteGuid = $request->get('site_guid');
        $consumerVersionGuid = $request->get('consumer_guid');

        if ($guid) {
            $site = $this->repository->getSiteByConsumerInstanceGuid($guid);
        } elseif ($siteGuid && $consumerVersionGuid) {
            $site = $this->repository->getSiteByGuid($siteGuid);
        } else {
            throw new BadRequestHttpException();
        }

        if (!($site instanceof Site)) {
            throw new NotFoundHttpException();
        }

        if (!$site->isAllowedToDispense($this->dispenseInterval)) {
            throw new AccessDeniedHttpException();
        }

        $response = new JsonResponse();
        if ($site->getDateLastUpdated() instanceof \DateTime) {
            $response->setLastModified($site->getDateLastUpdated());
        }
        if ($response->isNotModified($request)) {
            return $response;
        }

        $response->setData($site->getLinkData());

        return $response;
    }
}
