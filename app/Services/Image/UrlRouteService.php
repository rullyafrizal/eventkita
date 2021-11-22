<?php

namespace App\Services\Image;

use AM\InterventionRequest\Configuration;
use AM\InterventionRequest\InterventionRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UrlRouteService
{
    /**
     * Show image with dynamic optimize
     * Documentation link: https://github.com/ambroisemaupate/intervention-request#available-operations
     *
     * @param Request $request
     * @param $path
     * @return Response
     * @throws \Exception
     */
    public function show(Request $request, $path): Response
    {
        $request->request->add([
            'image' => $path
        ]);

        $conf = new Configuration();
        $conf->setCachePath(storage_path('app/public/.cache'));
        $conf->setImagesPath(config('filesystems.disks.public.root'));

        $intRequest = new InterventionRequest($conf);
        $intRequest->handleRequest($request);
        return $intRequest->getResponse($request);
    }
}
