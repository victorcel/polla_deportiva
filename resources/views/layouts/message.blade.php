@if(count($message))
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script type="text/javascript">

        swal({
            title: "{{ $message }}",
            icon: "info",
        })

    </script>

@endif