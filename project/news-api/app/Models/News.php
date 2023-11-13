<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class News extends Model
{
    protected $fillable = ['title', 'content'];

    public static function findNewsOrFail($id)
    {
        try {
            return findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public static function deleteNews($id): bool
    {
        $news = self::findNewsOrFail($id);

        if ($news) {
            $news->delete();
            return true;
        }

        return false;
    }

    public function updateNews(Request $request, $id): JsonResponse
    {
        $news = self::findNewsOrFail($id);

        if ($news) {
            $news->update($request->all());
            return response()->json(['message' => 'News updated successfully']);
        } else {
            return response()->json(['message' => 'News not found'], 404);
        }
    }

    public static function createNews($data): JsonResponse
    {
        return self::create($data);
    }
}
