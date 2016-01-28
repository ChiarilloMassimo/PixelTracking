<?php

namespace Pixel\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseController
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValidRequest()
    {
        $key = $this->getRequest()->get('key');

        if (!$key || $key !== APP_KEY) {
            return false;
        }

        return true;
    }

    /**
     * @return Response
     */
    public static function createNotFoundResponse()
    {
        return new Response('Not found.', Response::HTTP_NOT_FOUND);
    }

    /**
     * @return Response
     */
    public function createAccessDeniedResponse()
    {
        return new Response('Forbidden.', Response::HTTP_FORBIDDEN);
    }
}
