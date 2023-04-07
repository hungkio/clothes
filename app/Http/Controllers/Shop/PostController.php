<?php
namespace App\Http\Controllers\Shop;

use App\Domain\Post\Models\Post;
use App\Enums\PostState;
use App\Http\Controllers\Controller;
use Spatie\SchemaOrg\Schema;

class PostController extends Controller
{
    public function index()
    {
        abort(404);
    }

    public function show($unuse, Post $post)
    {
        $post->increment('view');
        $taxons = self::taxons();
        $postNews = self::newEstPost();
        $relatedPosts = collect([]);
        $postSchemaMarkup = $this->schemaMarkup($post);
        if (! empty($post->related_posts)) {
            $relatedPosts = Post::query()
                ->whereIntegerInRaw('id', $post->related_posts)
                ->get();
        }

        return view('shop.post.show', compact('post', 'postNews', 'taxons', 'relatedPosts', 'postSchemaMarkup'));
    }

    public function taxons(){

    }

    public function newEstPost(){

    }

    public function schemaMarkup($post)
    {
        return Schema::article()
            ->url(route('post.show', [$post->taxons->first()->slug ?? 'bai-viet', $post->slug]))
            ->author($post->user->fullname ?? null)
            ->mainEntityOfPage(
                Schema::WebPage()
                    ->id(route('post.show', [$post->taxons->first()->slug ?? 'bai-viet', $post->slug]))
            )
            ->image(
                Schema::imageObject()
                    ->url($post->getFirstMediaUrl('image'))
                    ->width('700')
                    ->height('438')
            )
            ->description($post->description)
            ->datePublished($post->created_at)
            ->dateModified($post->created_at)
            ->publisher(
                Schema::Organization()
                    ->name(config('app.url'))
                    ->logo(
                        Schema::imageObject()
                            ->url(\Storage::url(setting('store_logo')))
                            ->width('60')
                            ->height('60')
                    )
            );
    }

}
