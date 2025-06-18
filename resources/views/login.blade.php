<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon"href="{{ asset('myfavicon.ico') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login</title>

</head>
<body class="d-flex flex-column justify-content-center align-items-center vh-100" style="margin-top: -50px;">

    <!-- Logo -->
    <div class="d-flex justify-content-center mb-3">
        <img src="/img/logo.png" alt="Logo" width="170" height="170">
    </div>

    <!-- Form Login -->
    <div class="container border rounded px-4 py-4 shadow-lg" style="max-width: 320px;">
        <h3 class="text-center">Login</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="" method="POST">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="username" value="{{ old('username') }}" name="username" class="form-control">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3 d-grid">
                <button name="submit" type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
