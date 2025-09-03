<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ViewsArticle extends Model
{
    protected $table = "views_articles";

    protected $guarded = [];

    public static function createViewLog($request, $article)
    {
        $result = DB::table('views_articles')->where([
            ['view_type', '=', 'App\Models\Artikel'],
            ['view_id', '=', $article->id],
            ['visitor_ip', $request->ip()],
            ['agent', $request->header('User-Agent')]
        ])->count();

        if ($result == 0) {
            $viewsArticle = new ViewsArticle();
            $viewsArticle->view_id = $article->id;
            $viewsArticle->view_type = 'App\Models\Artikel';
            $viewsArticle->visitor_ip = $request->ip();
            $viewsArticle->agent = $request->header('User-Agent');
            $viewsArticle->save();
        }
    }
}
