<?php

namespace App\Http\Controllers\Content;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Models\Content\Article;
use App\Http\Resources\Content\ArticleResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ArticleController extends Controller
{
    public function getArticle(Request $request, int $id)
    {
        $article = Article::find($id);
        
        if (!$article) {
            throw new ModelNotFoundException('Article not found', 404);
        }

        return new ArticleResource($article);
    }

    public function getArticles(Request $request)
    {
        $articles = Article::get();

        return ArticleResource::collection($articles);
    }

    public function createArticle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException('Validation failed');
        }

        $newArticle = new Article;

        $newArticle->content = $request->content; // TODO HTML PURIFYING
        $newArticle->save();

        if (!$newArticle) {
            throw new HttpException(500, 'Error creating new article');
        }

        return response()->json([
            'data' => [],
            'message' => 'Article has been successfully created',
            'status_code' => 200
        ], 200);
    }

    public function editArticle(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException('Validation failed');
        }

        $article = Article::find($id);
        
        if (!$article) {
            throw new ModelNotFoundException('Article not found', 404);
        }

        $article->content = $request->content; // TODO HTML PURIFYING
        $article->save();

        return response()->json([
            'data' => [],
            'message' => 'Article has been successfully edited',
            'status_code' => 200
        ], 200);
    }

    public function deleteArticle(Request $request, int $id)
    {
        $article = Article::find($id);
        
        if (!$article) {
            throw new ModelNotFoundException('Article not found', 404);
        }

        return response()->json([
            'data' => [],
            'message' => 'Article has been successfully deleted',
            'status_code' => 200
        ], 200);
    }
}
