<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('partials._head')
    <body>
        <div id="app">
            <div class="container">
                <cosmonauts></cosmonauts>
            </div>
        </div>
        @include('partials._scripts')
    </body>
</html>
