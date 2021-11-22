<?php

namespace App\Actions\Article;

use App\Models\Article;
use Lorisleiva\Actions\Concerns\AsAction;

class Publish
{
    use AsAction;

    public function handle(Article $article): string
    {
        $response = '';

        if ($article->is_published) {
            $article->update([
                'is_published' => false,
            ]);

            $response = 'An article has been unpublished';
        } else {
            $article->update([
                'is_published' => true,
            ]);

            $response = 'An article has been published';
        }

        return $response;
    }
}
