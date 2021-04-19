
	@include('print_layouts.header')

    @guest

    @else

    @endguest

	<main class="py-4">
	    @yield('content')
	</main>

	@include('print_layouts.footer')
