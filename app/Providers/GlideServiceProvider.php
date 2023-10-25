<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
            \League\Glide\Server::class,
            function (\Illuminate\Contracts\Foundation\Application $app): \League\Glide\Server {
                // Set up filesystems.
                $source = $app->make('image.source');
                $cache = new \League\Flysystem\Filesystem(
                    new \League\Flysystem\Local\LocalFilesystemAdapter(config('image.cache'))
                );

                // Set up manipulators.
                $manipulators = [
                    new \League\Glide\Manipulators\Size(config('image.max_size')),
                ];

                // Set up image manager instance.
                $imageManager = new \Intervention\Image\ImageManager([
                    'driver' => config('image.driver'),
                ]);

                // Set up API.
                $api = new \League\Glide\Api\Api($imageManager, $manipulators);

                // Create server.
                $server = new \League\Glide\Server($source, $cache, $api);

                // Set response factory.
                $server->setResponseFactory(new \League\Glide\Responses\LaravelResponseFactory());

                return $server;
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
     *
     * @return \Psr\Http\Client\ClientInterface
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
