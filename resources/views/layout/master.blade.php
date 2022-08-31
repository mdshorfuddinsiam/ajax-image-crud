<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ajax Image Crud</title>
	<link rel="stylesheet" href="{{ asset('/') }}css/bootstrap.min.css">
	<!-- CSS -->
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
	<!-- Default theme -->
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
</head>
<body>
	
	<section>
		<div class="py-5">
			@yield('body')
		</div>
	</section>

	<script src="{{ asset('/') }}js/jquery-3.6.0.min.js"></script>
	<script src="{{ asset('/') }}js/bootstrap.min.js"></script>
	<script src="{{ asset('/') }}js/bootstrap.bundle.min.js"></script>

	<!-- JavaScript -->
	<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

	@yield('scripts')

</body>
</html>