<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Libraries\EsEngine;
use Laravel\Scout\EngineManager;
use Elasticsearch\ClientBuilder as ElasticBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //重新定义了搜索引擎为 es
        resolve(EngineManager::class)->extend('es', function($app) {
            return new EsEngine(ElasticBuilder::create()
                ->setHosts(config('scout.elasticsearch.hosts'))
                ->build(),
                config('scout.elasticsearch.index')
            );
        });
        //
        Schema::defaultStringLength(191);

        \View::composer('layout.nav', function($view){
            $user = \Auth::user();
            $view->with('user', $user);
        });

        \View::composer('layout.sidebar', function($view){
            $topics = \App\Topic::all();
            $view->with('topics', $topics);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
