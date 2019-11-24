<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title> {{ $settings[0]['value'] }} @yield('title')</title>

	<!-- Meta Informations -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="_token" content="{{ csrf_token() }}">
	<meta property="og:site_name" content="{{ config('app.name', 'LaraMailer') }}" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="{{ url('/') }}" />
	<meta property="og:image" content="{{ asset($settings[1]['value']) }}" />
	<meta property="og:title" content="{{ $settings[8]['value'] }}" />
	<meta property="og:description" content="{{ $settings[9]['value'] }}" />

	<!-- Favicon -->
	<link rel="shortcut icon" href="{{ asset($settings[2]['value']) }}" type="image/x-icon">
	
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
	
	@include('layouts.partials.links')
	
	@yield('links')
</head>
<body class="hold-transition {{ $settings[5]['value'] }} sidebar-mini fixed">

	<div class="wrapper">

		@include('layouts.partials.header')

		@include('layouts.partials.sidebar')

		<div class="content-wrapper">
		    <!-- Content Header (Page header) -->
		    <section class="content-header">
		        <h1> @yield('content-header') </h1>		        
				<ol class="breadcrumb">
				    <li><a href="{{ url('/') }}"><i class="fa fa-connectdevelop "></i> Home</a></li>
					@yield('breadcrumb')
				</ol>
		    </section>

			@yield('content')

		</div>

		@include('layouts.partials.footer')

	</div>
	<!-- ./wrapper -->

	@include('layouts.partials.scripts')

	@yield('scripts')
	
    @include('sweet::alert')

</body>
</html>