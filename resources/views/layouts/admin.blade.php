<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="SPK Pemilihan Siswa Berprestasi" />
    <meta name="author" content="Zidan Reksa Pratama" />
    <title>SPK | {{ $title ?? 'Untitled' }}</title>


    {{-- style --}}
    @include('includes.admin.style')
</head>

<body class="layout-fixed">
    <div class="wrapper d-flex flex-column min-vh-100">

        {{-- navbar --}}
        @include('includes.admin.navbar')

        {{-- sidenav --}}
        @include('includes.admin.sidenav')

        {{-- content --}}
        <div class="content-wrapper flex-grow-1">
            {{-- content --}}
            @yield('content')
        </div>

        {{-- footer --}}
        @include('includes.admin.footer')

    </div>

    @include('includes.admin.script')
</body>

</html>
