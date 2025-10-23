<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Admin</h1>
<ul>
    <li><a href="{{ route('admin_lista') }}"><button type="submit">Lista de editores</button></a></li>
    <li><a href="{{ route('admin_registrar') }}"><button type="submit">Añadir editor</button></a></li>
</ul>


    <form action="{{ route('logout') }}" method="post">
        @csrf 
        <button type="submit">cerrar sesión</button>
    </form>
</body>
</html>