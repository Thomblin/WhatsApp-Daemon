<html>
<head>
    <title>App Name - @yield('title')</title>

    @section('css')
    @show
</head>
<body>
@section('sidebar')
    <div class="sidebar">

    </div>
@show

<div class="container">
    @yield('content')
</div>

@section('js')
<script type="application/javascript" src="js/jquery.js"></script>
@show
</body>
</html>