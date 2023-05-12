<!DOCTYPE html>
<html lang="en">

<head>

    @include('partials.head')

</head>
    <body id="page-top">

        <div id="wrapper">

            @include('partials.side')

            <div id="content-wrapper" class="d-flex flex-column">

                <div id="content">

                    @include('partials.nav')

                    @yield('content')
                    
                </div>

                @include('partials.footer')

            </div>

        </div>

        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js"> </script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
        <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
        <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!-- CKeditor -->
        <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

        <script src="{{ asset('js/time.js') }}"></script>
        <script src="{{ asset('js/notification.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        
        @yield('scripts')

    </body>

</html>