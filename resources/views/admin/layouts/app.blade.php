<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GXD CRM</title>

    <!-- Global stylesheets -->

    <base href="{{asset('')}}">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('limitless/global_assets/css/icons/icomoon/styles.css')}}">
    <link rel="stylesheet" href="{{asset('limitless/global_assets/css/icons/fontawesome/styles.min.css')}}">
    <link href="{{asset('limitless/global_assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('limitless/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('limitless/assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('limitless/assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('limitless/assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('limitless/assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    @yield('css')

    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{asset('limitless/global_assets/js/main/jquery.min.js')}}"></script>
    @yield('js')
    <script src="{{asset('limitless/global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('limitless/global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
    <!-- /core JS files -->

    <script>
        function debounce(func, wait, immediate) {
            var timeout;
            return function() {
                var context = this, args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        };
    </script>

    <!-- Theme JS files -->
    <script src="{{asset('limitless/global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>

    <script src="{{asset('limitless/assets/js/app.js')}}"></script>
    <!-- /theme JS files -->

</head>

<body>

@include('admin.layouts.partitals.header')

<!-- Page content -->
<div class="page-content">

    @include('admin.layouts.partitals.sidebar')


    <!-- Main content -->
    <div class="content-wrapper">
        @yield('content')

        @include('admin.layouts.partitals.footer')

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->
<script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
</script>
</body>
</html>
