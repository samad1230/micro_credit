
<script src="{{asset('assets/js/plugins/jquery-3.3.1.min.js')}}"></script>

<script src="{{asset('assets/js/plugins/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tooltip.script.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/script_2.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/layout-sidebar-vertical.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/sidebar.script.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>

@yield('page-script')
<script !src="">
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @elseif(count($errors) > 0)
    @foreach($errors->all() as $error)
    toastr.error("{{ $error }}");
    @endforeach
    @endif
</script>
</body>

</html>
