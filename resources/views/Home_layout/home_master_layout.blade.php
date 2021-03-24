@include('Common_Section.header')



@guest

@else





@endguest


@yield('content')


@include('Common_Section.footer')
