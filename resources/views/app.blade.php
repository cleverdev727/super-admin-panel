<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <link rel="icon" href="{{ asset('favicon.ico') }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>How To Install Vue 3 in Laravel 9 with Vite</title>

	@vite('resources/css/app.css')
</head>
<body>
	<div id="app"></div>
	<script>
		window.app = {!! json_encode([
			'url' => url('/'),
			'name' => env('APP_NAME'),
		], JSON_THROW_ON_ERROR) !!}
	</script>
	@vite('resources/js/app.js')
</body>
</html>