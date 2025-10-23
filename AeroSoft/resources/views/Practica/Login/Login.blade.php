<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administración</title>
    <link href="{{ asset('css/login/login.css') }}" rel="stylesheet">
</head>
<body>

    <div class="login-container">
        <h1>Login de Administración</h1>

        @if($errors->any())
            <p class="error">{{ $errors->first() }}</p>
        @endif

        <form action="{{ route('loguear') }}" method="post">
            @csrf 

            <div class="form-group">
                <label for="Correo">Correo</label>
                <input type="email" name="Correo" value="{{ old('Correo') }}" required>
            </div>

            <div class="form-group">
                <label for="Password">Contraseña</label>
                <input type="password" name="Password" required>
            </div>

            <div class="buttons">
                <button type="submit">Iniciar sesión</button>
                <button type="reset" class="secondary">Cancelar</button>
            </div>
        </form>
    </div>

</body>
</html>
