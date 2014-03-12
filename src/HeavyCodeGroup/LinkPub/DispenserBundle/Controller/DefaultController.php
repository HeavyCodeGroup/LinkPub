<?php

namespace HeavyCodeGroup\LinkPub\DispenserBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    public function indexAction(Request $request)
    {
        return new JsonResponse("Test response");
    }
}
