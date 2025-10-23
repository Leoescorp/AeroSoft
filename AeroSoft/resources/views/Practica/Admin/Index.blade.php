<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Administración | AeroSoft</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Estilos personalizados -->
  <link href="{{ asset('css/admin/admin.css') }}" rel="stylesheet">
</head>
<body>

  <header class="admin-header">
    <h1>Panel de Administración</h1>
  </header>

  <main class="admin-container">
    <div class="card admin-card shadow-lg">
      <div class="card-body text-center">

        <h2 class="mb-4">Opciones del Administrador</h2>

        <ul class="list-unstyled d-flex flex-wrap justify-content-center gap-3 mb-5">
          <li>
            <a href="{{ route('admin_lista') }}" class="btn btn-primary px-4 py-2">Lista de editores</a>
          </li>
          <li>
            <a href="{{ route('admin_registrar') }}" class="btn btn-success px-4 py-2">Añadir editor</a>
          </li>
        </ul>

        <form action="{{ route('logout') }}" method="post" class="mt-4">
          @csrf 
          <button type="submit" class="btn btn-danger px-4 py-2">Cerrar sesión</button>
        </form>

      </div>
    </div>
  </main>

  <footer class="text-center py-3 text-muted">
    © {{ date('Y') }} AeroSoft. Todos los derechos reservados.
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
