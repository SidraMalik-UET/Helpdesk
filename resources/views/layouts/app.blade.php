<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'HelpDesk')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <nav class="navbar">

        <div class="container nav-content">

            {{-- HelpDesk Logo --}}
            <a href="{{ route('helpdesk') }}" class="logo">
                Help<span>Desk</span>
            </a>

            <div class="nav-links">

                {{-- Home --}}
                <a href="{{ route('helpdesk') }}">
                    Home
                </a>

                @auth

                    {{-- Dashboard --}}
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>

                    {{-- Tickets --}}
                    <a href="{{ route('tickets.index') }}">
                        Tickets
                    </a>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}">
                            Admin Panel
                        </a>
                    @endif

                    {{-- Logout --}}
                    <form method="POST"
                          action="{{ route('logout') }}"
                          class="logout-form">

                        @csrf

                        <button type="submit" class="nav-logout">
                            Logout
                        </button>

                    </form>

                @else

                    {{-- Login --}}
                    <a href="{{ route('login') }}">
                        Login
                    </a>

                    {{-- Register --}}
                    <a href="{{ route('register.form') }}"
                       class="nav-register">
                        Get Started
                    </a>

                @endauth

            </div>

        </div>

    </nav>


    {{-- Validation Errors --}}
    @if (isset($errors) && $errors->any())

        <div class="container">

            <div class="alert error">

                <strong>Please fix the following:</strong>

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        </div>

    @endif


    {{-- Success Message --}}
    @if (session('success'))

        <div class="container">

            <div class="alert success">
                {{ session('success') }}
            </div>

        </div>

    @endif


    {{-- Page Content --}}
    <main>

        @yield('content')

    </main>


    {{-- Footer --}}
    <footer>

        <div class="container">

            <p>
                © {{ date('Y') }} HelpDesk.
                Support made simple.
            </p>

        </div>

    </footer>

</body>

</html>
