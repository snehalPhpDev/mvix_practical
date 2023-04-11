<html>
    <head></head>
    <body>
        <h1>Welcome <a href="{{route('logout')}}">Logout</a></h1>
        <hr>
        @php
            echo '<code  >',json_encode($response),'</code>';
        @endphp
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script>
            
            
        </script>
    </body>
</html>