<?php

namespace Pixel\Controller;

use Symfony\Component\HttpFoundation\Response;

class ImageHandlerController extends BaseHandler
{
    /**
     * @return Response
     */
    public function handle()
    {
        return new Response(
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII='),
            Response::HTTP_OK,
            ['Content-Type' => 'image/png']
        );
    }
}

