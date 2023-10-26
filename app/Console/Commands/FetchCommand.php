<?php

namespace App\Console\Commands;

class FetchCommand extends \Illuminate\Console\Command
{
    /**
     * {@inheritDoc}
     */
    protected $signature = 'fetch {filename}';

    /**
     * {@inheritDoc}
     */
    protected $description = 'Fetch an image from the upstream server and show its metadata';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Get the filename and print title.
        $filename = $this->argument('filename');
        $this->output->title("Fetching {$filename}");

        // Get the image source filesystem.
        /** @var \League\Flysystem\FilesystemOperator $source */
        $source = app('image.source');

        // Check if the image exists.
        if (! $source->fileExists($filename)) {
            $this->error("Image {$filename} does not exist");

            return;
        }

        // Get the image metadata.
        $this->info('Image metadata');
        $metadata = [
            ['Size', $source->fileSize($filename)],
            ['Timestamp', $source->lastModified($filename)],
            ['MimeType', $source->mimeType($filename)],
        ];
        $this->table(['Property', 'Value'], $metadata);
    }
}
