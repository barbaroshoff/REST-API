<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private News $news;

    public function __construct(News $news)
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->news = $news;
    }

    public function index(): JsonResponse
    {
        $news = $this->news->all();
        return response()->json($news);
    }

    public function show($id): JsonResponse
    {
        $news = $this->news->findNewsOrFail($id);
        return response()->json($news);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', News::class);

        $news = $this->news->createNews($request->all());

        return response()->json($news, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $this->authorize('update', News::class);

        return $this->news->updateNews($request, $id)
            ? response()->json(['message' => 'News updated successfully'])
            : response()->json(['message' => 'News not found']);
    }

    public function destroy($id): JsonResponse
    {
        $this->authorize('delete', News::class);

        return $this->news->deleteNews($id)
            ? response()->json(['message' => 'News deleted successfully'])
            : response()->json(['message' => 'News not found']);
    }
}
