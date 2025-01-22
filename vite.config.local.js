import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import livewire from '@defstudio/vite-livewire-plugin'; // <-- import

export default defineConfig({
	server: {
		hmr: {
			host: 'localhost'
		}
	},
	plugins: [
		laravel({
			input: [ 'resources/css/app.css', 'resources/js/app.js', 'resources/css/filament.css' ],
			refresh: false
		}),

		livewire({
			// <-- add livewire plugin
			refresh: [ 'resources/css/app.css' ] // <-- will refresh css (tailwind ) as well
		}),
	],
	build: { assetsInlineLimit: 0 }
});
