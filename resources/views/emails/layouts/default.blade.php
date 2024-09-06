<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#3490fd">
        <title>{{ config('app.name', 'Laravel') }}</title>
    </head>
    <body>
        <header>
            <h1>@yield('title')</h1>
        </header>

        <main>
            @yield('content')
        </main>

        <footer>
            <p>&nbsp;</p>
        </footer>	
    </body>
</html>