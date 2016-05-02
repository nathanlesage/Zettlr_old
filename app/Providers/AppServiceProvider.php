<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

use Less_Parser;
use App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $appCss = public_path() . '/css/app.min.css';
        // Only compile if there is no app.min.css or we
        // are in debug
        if((!File::exists($appCss)) || App::environment('local'))
        {
            // Create a new minifying parser
            $parser = new Less_Parser([ 'compress' => true ]);

            // As some may want to run this locally, check the server port as well!
            $app_url = ($_SERVER['SERVER_PORT'] != 80) ? rtrim(getenv('APP_URL'), '/') . ':' . $_SERVER['SERVER_PORT'] . '/' : getenv('APP_URL');

            // Parse the bootstrap.less-file
            $parser->parseFile(base_path() . '/resources/assets/less/bootstrap.less', $app_url);
            // (over-)write app.css
            $bytes_written = File::put($appCss, $parser->getCss());

            if(!$bytes_written)
                throw new Exception('Could not write new CSS file!');

        }
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
