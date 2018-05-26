<!DOCTYPE html>
<html>
<head>
	<title>Tienda | SUN NAO CASINO</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
</head>
<body  style="background-image: url('{{ Storage::url('LOGOSUN.png')}}')">
<div id="app">

	@yield('content')

</div>
	<script src="{{ asset('js/app.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/jquery.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/pinterest_grid.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-number-input.js') }}"></script>
	@yield('js')
</body>
</html>
