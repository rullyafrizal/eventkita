<?php

namespace App\Http\Controllers\Api;

use App\Enums\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleCollection;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $paginate = $request->paginate ? (float)$request->paginate : 6;

        return new ArticleCollection(
            Article::query()
                ->wherePublished()
                ->paginate($paginate)
        );
    }

    public function show(Article $article)
    {
        return api_response(
            HttpStatus::OK,
            'Success fetching article',
            new ArticleResource($article)
        );
    }
}
