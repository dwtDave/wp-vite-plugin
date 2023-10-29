
# Vite Integration for WordPress

This plugin integrates Vite into WordPress, it handles of SCSS and JavaScript. It's specifically designed to work with WordPress and Bricks Builder, providing an optimized development and production workflow.

## Features

- Vite integration for WordPress, enhancing the handling of SCSS and JavaScript.
- Support for hot module replacement during development.
- Optimized asset loading in production with manifest-based management.
- Customizable settings with a dedicated admin page for toggling development mode.
- Compatibility with Bricks Builder, ensuring scripts are not enqueued while using the builder.

## Installation

1. Clone or download this repository into your WordPress `plugins` directory.
2. Navigate to your WordPress admin panel and activate the "Vite Integration for WordPress" plugin.
3. Access the "Vite Integration" settings in the admin menu to configure the plugin.

## Usage

- For development, enable 'Dev Mode' in the plugin settings. This directs the plugin to use your local Vite server.
- For production, disable 'Dev Mode'. The plugin will serve assets from the `assets/dist` directory.

## Development

- Start your Vite server with `npm run dev` or an equivalent command.
- While 'Dev Mode' is active, the plugin will utilize assets from your local Vite server.

## Production

- Build your assets using `npm run build` or your preferred command.
- With 'Dev Mode' disabled, the plugin automatically serves assets from the `assets/dist` directory.

## Project Setup

Install the necessary dependencies by running:

```sh
npm install
```

This will install Vite and Sass, which are essential for development.

### Available Scripts

- `npm run dev` - Starts the Vite server for development.
- `npm run build` - Builds the assets for production.
- `npm run serve` - Serves the built assets for preview.


## Structure

```plaintext
.
├── LICENCE
├── assets
│   ├── dist (Production build files)
│   └── src (Source files for development)
├── package.json
├── vite.config.js (Vite configuration)
└── wp-vite-plugin.php (Main plugin file)
```

## Contributing

Feel free to contribute! Any issues, feature requests, or contributions are welcome.

## License

This project is licensed under the GPL3 License.
