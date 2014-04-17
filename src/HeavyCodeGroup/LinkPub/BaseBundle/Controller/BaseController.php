<?php

namespace HeavyCodeGroup\LinkPub\BaseBundle\Controller;

use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    /**
     * @param $query
     * @param $page
     * @return Pagerfanta
     */
    protected function getPagerfanta($query, $page)
    {
        $adapter = new DoctrineORMAdapter($query);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($this->container->getParameter('per_page'));

        return $pagerfanta->setCurrentPage($page);
    }
}
 