# Imageproxy

Imageproxy is a simple CDN-like proxy service for images with the possibility to resize images on the fly.

## Features

- Caching proxy for images
- Resize images via url parameters
- Convert images to WebP if the browser supports that format

## Usage

- Install Imageproxy on your server
- Configure Imageproxy via the `.env` file: you have to at least set the `IMAGE_SOURCE` variable which should point to
  the base url of your images on the upstream server
- Replace image urls in your application with the proxy urls

### Example

- Your app is running at https://example.com, your images are located at https://example.com/media/
- You have installed Imageproxy at https://imageproxy.example and set `IMAGE_SOURCE=https://example.com/media/` in
  your `.env` file

Now do the following replacement for images in your app's HTML

```html
<img src="/media/products/image.jpg"/>
```

becomes

```html
<img src="https://imageproxy.example/images/products/image.jpg"/>
```

To resize the image on the fly to 200px width, use

```html
<img src="https://imageproxy.example/images/products/image.jpg/200"/>
```

## Configuration

Imageproxy is configured via environment variables (like any other Laravel app). The following variables are available:

| Variable          | Description                                                     | Default |
|-------------------|-----------------------------------------------------------------|---------|
| `IMAGE_SOURCE`    | The base url of the images on the upstream server               | ``      |
| `IMAGE_MAX_SIZE`  | The maximum size of the in pixels                               | `2000`  |
| `IMAGE_DRIVER`    | The image driver to use for resizing images (`gd` or `imagick`) | `gd`    |
| `IMAGE_NO_VERIFY` | Disable SSL certificate verification for the upstream server    | `false` |
| `IMAGE_USE_AVIF`  | Use AVIF format if the browser supports it?                     | `false` |
| `IMAGE_USE_WEBP`  | Use WebP format if the browser supports it?                     | `false` |
