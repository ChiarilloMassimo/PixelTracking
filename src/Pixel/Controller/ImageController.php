<?php

namespace Pixel\Controller;

use Symfony\Component\HttpFoundation\Response;

class ImageController extends BaseController
{
    /**
     * @param array $parameters
     * @return Response
     */
    public function handle(array $parameters)
    {
        return new Response(
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII='),
            Response::HTTP_OK,
            ['Content-Type' => 'image/png']
        );
    }
}
