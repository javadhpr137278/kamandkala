<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title'];

    public static function CreateTag($request): void
    {
        Tag::create([
            'title' => $request->title,
        ]);
    }

    public static function updateTag($request, $id)
    {
        $tag = self::findOrFail($id);
        $data = [
            'title' => $request->input('title'),
        ];
        $tag->update($data);

        return $tag;
    }
}
