<?php

declare(strict_types=1);

namespace App\Providers;

use App\Strategies\FormatStrategyInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use League\Glide\Server;

/**
 * Service provider for Glide
 */
class GlideServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register source filesystem.
        $this->app->singleton(
            'image.source',
            function (): \League\Flysystem\FilesystemOperator {
                return new \League\Flysystem\Filesystem(
                    new \Netzarbeiter\FlysystemHttp\HttpAdapterPsr($this->getClient())
                );
            }
        );

        // Register Glide server.
        $this->app->singleton(
            Server::class,
            function (Application $app): Server {
                // Set up filesystems.
                $source = $app->make('image.source');
                $cache = new \League\Flysystem\Filesystem(
                    new \League\Flysystem\Local\LocalFilesystemAdapter(config('image.cache'))
                );

                // Set up manipulators.
                $manipulators = [
                    new \League\Glide\Manipulators\Size(pow(config('image.max_size'), 2)),
                    new \League\Glide\Manipulators\Encode(),
                ];

                // Set up image manager instance.
                $imageManager = new \Intervention\Image\ImageManager([
                    'driver' => config('image.driver'),
                ]);

                // Set up API.
                $api = new \League\Glide\Api\Api($imageManager, $manipulators);

                // Create server.
                $server = new Server($source, $cache, $api);

                // Set response factory.
                $server->setResponseFactory(new \League\Glide\Responses\LaravelResponseFactory());

                // Cache images with file extensions (easier for debugging).
                $server->setCacheWithFileExtensions(true);

                return $server;
            }
        );

        // Register format stragegy.
        $this->app->singleton(
            FormatStrategyInterface::class,
            function (Application $app): FormatStrategyInterface {
                return new \App\Strategies\SimpleFormatStrategy($app->make('image.source'));
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Get the HTTP client.
     */
    protected function getClient(): \Psr\Http\Client\ClientInterface
    {
        $options = [
            'base_uri' => config('image.source'),
            'follow_redirects' => true,
        ];

        if (config('image.no_verify')) {
            $options['verify'] = false;
        }

        return new \GuzzleHttp\Client($options);
    }
}
