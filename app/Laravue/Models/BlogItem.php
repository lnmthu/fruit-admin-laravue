<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class BlogItem extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    use HasMediaTrait;

    protected $fillable = [
        'title', 'description', 'body', 'sort', 'user_id', 'blog_category_id', 'status'
    ];

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id')->orderBy('sort', 'ASC');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('blog')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('blog')
                    ->width(150)
                    ->height(120);
            });
    }

    // public function registerMediaConversions()
    // {
    //     $this->addMediaConversion('blog')
    //         ->width(368)
    //         ->height(232);
    // }
}