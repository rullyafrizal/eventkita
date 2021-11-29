<?php

namespace App\Http\Controllers;

use App\Services\Image\UrlRouteService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    private $url_route;

    /**
     * @param UrlRouteService $url_route
     */
    public function __construct(UrlRouteService $url_route)
    {
        $this->url_route = $url_route;
    }

    public function show(Request $request, $path)
    {
        return $this->url_route->show($request, $path);
    }
}
