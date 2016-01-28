<?php

namespace Pixel\Controller;

use Symfony\Component\HttpFoundation\Response;
use Pixel\Notifier\Notifier;

class ImageController extends BaseController implements ControllerInterface
{
    /**
     * @param array $parameters
     * @param Notifier|null $notifier
     * @return Response
     */
    public function handle(array $parameters, Notifier $notifier = null)
    {
        if (!$this->isValidRequest()) {
            return $this->createAccessDeniedResponse();
        }

        if ($notifier) {
            $notifier->notify(
                sprintf(
                    'Pixel: %s, open at %s',
                    $this->getRequest()->get('object', 'Not Tracked'),
                    (new \DateTime())->format('Y-m-d H:i:s')
                )
            );
        }

        return new Response(
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII='),
            Response::HTTP_OK,
            ['Content-Type' => 'image/png']
        );
    }
}
