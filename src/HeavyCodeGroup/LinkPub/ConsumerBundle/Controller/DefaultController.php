<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Controller;

use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function downloadAction(Request $request, $site)
    {
        $format = $request->get('format');
        $implementationName = $request->get('impl');

        if (!in_array($format, array('zip', 'tar.gz', 'tar.bz2')) || !$implementationName) {
            throw new BadRequestHttpException();
        }

        $em = $this->getDoctrine()->getManager();

        /**
         * @var \HeavyCodeGroup\LinkPub\StorageBundle\EntityRepository\SiteRepository $siteRepository
         */
        $siteRepository = $em->getRepository('LinkPubStorageBundle:Site');
        try {
            $site = $siteRepository->findOneByIdOrGuid($site);
        } catch (NoResultException $ex) {
            throw new NotFoundHttpException('Requested site was not found');
        }

        /**
         * @var \HeavyCodeGroup\LinkPub\StorageBundle\EntityRepository\ConsumerRepository $consumerRepository
         */
        $consumerRepository = $em->getRepository('LinkPubStorageBundle:Consumer');
        try {
            $consumer = $consumerRepository->findNewestOneByImplementation($implementationName);
        } catch (NoResultException $ex) {
            throw new NotFoundHttpException('Requested implementation was not found');
        }

        /**
         * @var \HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\BuilderTool $builder
         */
        $builder = $this->get('link_pub_consumer.builder');
        $instance = $builder->getInstance($site, $consumer);

        return new Response($instance->getGuid());
    }
}
