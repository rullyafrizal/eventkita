<?php

namespace App\Http\Controllers;

use App\Actions\Article\Publish;
use App\Actions\UploadFile;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Requests\Article\UploadThumbnailRequest;
use App\Http\Resources\Article\ArticleCollection;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-articles');
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status', 'trashed']);

        return Inertia::render('Articles/Index', [
            'filters' => $filters,
            'articles' => new ArticleCollection(
                Article::query()
                    ->orderByDesc('id')
                    ->filter($filters)
                    ->paginate()
            )
        ]);
    }

    public function create()
    {
        $this->authorize('create-article', Article::class);

        return Inertia::render('Articles/Create');
    }

    public function store(StoreArticleRequest $request)
    {
        Article::query()
            ->create([
                'title' => $request->title,
                'body' => $request->body,
                'thumbnail' => $request->thumbnail ?
                    $request->thumbnail[0]['path'] : null,
                'is_published' => false,
            ]);

        return redirect()
            ->route('articles.index')
            ->with('success', 'An article has been created');
    }

    public function show(Article $article)
    {
        $this->authorize('show-article', Article::class);

        return Inertia::render('Articles/Show', [
            'article' => new ArticleResource(
                $article
            )
        ]);
    }

    public function edit(Article $article)
    {
        $this->authorize('edit-article', Article::class);

        return Inertia::render('Articles/Edit', [
            'article' => new ArticleResource($article)
        ]);
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        DB::transaction(function() use ($request, $article) {
            if ($request->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);

                $article->update([
                    'title' => $request->title,
                    'body' => $request->body,
                    'thumbnail' => $request->thumbnail ?
                        $request->thumbnail[0]['path'] : null,
                ]);
            } else {
                $article->update([
                    'title' => $request->title,
                    'body' => $request->body,
                ]);
            }
        });

        return redirect()
            ->route('articles.show', $article->id)
            ->with('success', 'An article has been updated');
    }

    public function publish(Article $article)
    {
        $this->authorize('edit-article');

        $response = Publish::run($article);

        return redirect()
            ->route('articles.index')
            ->with('success', $response);
    }

    public function upload(UploadThumbnailRequest $request)
    {
        $new_path = UploadFile::run($request);

        return response()->json([
            'url' => photo_url($new_path),
            'path' => $new_path,
        ]);
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete-article', Article::class);

        DB::transaction(function () use ($article) {
            Storage::disk('local')->delete($article->thumbnail);

            $article->forceDelete();
        });


        return redirect()
            ->route('articles.index')
            ->with('success', 'An article has been deleted');
    }

    public function restore(Article $article)
    {
        $this->authorize('restore-article', Article::class);

        $article->restore();

        return redirect()
            ->route('articles.index')
            ->with('success', 'An article has been restored');
    }
}
