<?php

namespace Pixel\Controller;

use Symfony\Component\HttpFoundation\Response;

interface ControllerInterface
{
    /**
     * @param array $parameters
     * @return Response
     */
    public function handle(array $parameters);
}
