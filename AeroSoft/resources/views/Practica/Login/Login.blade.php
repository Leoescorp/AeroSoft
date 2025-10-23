<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Login</h1>

    @if($errors->any())
    <p>{{ $errors->first() }}</p>
    @endif
    
    <form action="{{ route('loguear') }}" method="post">
        @csrf 
        <label for="Correo">Correo</label><input type="email" name="Correo" value="{{ old('Correo') }}" required><br>
        <label for="Password">Contraseña</label><input type="password" name="Password" required><br>
        <button type="submit">Iniciar sesión</button>
        <button type="reset">Cancelar</button>
    </form>
</body>
</html>