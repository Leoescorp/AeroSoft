<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Usuarios | AeroSoft</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS personalizado -->
  <link href="{{ asset('css/lista/lista.css') }}" rel="stylesheet">
</head>
<body>

  <header class="bg-dark text-white text-center py-3 mb-4 shadow-sm">
    <h1 class="h3 m-0">Lista de Usuarios - <span class="text-info">AeroSoft</span></h1>
  </header>

  <main class="container">
    <!-- Filtros -->
    <form action="{{ route('admin_lista') }}" method="get" class="row g-3 mb-4 align-items-end">
      <div class="col-md-4">
        <label for="Buscar" class="form-label">Buscar</label>
        <input type="text" name="Buscar" id="Buscar" class="form-control" value="{{ request('Buscar') }}" placeholder="Nombre o correo...">
      </div>

      <div class="col-md-3">
        <label for="genero" class="form-label">Género</label>
        <select name="genero" id="genero" class="form-select">
          <option>Todos</option>
          <option value="1" {{ request('rol') == 1 ? 'selected': '' }}>Hombre</option>
          <option value="2" {{ request('rol') == 2 ? 'selected': '' }}>Mujer</option>
          <option value="3" {{ request('rol') == 3 ? 'selected': '' }}>Otros</option>
        </select>
      </div>

      <div class="col-md-5 d-flex gap-2">
        <button type="submit" class="btn btn-primary">Buscar</button>
        <button type="submit" class="btn btn-secondary">Filtrar</button>
        <a href="{{ route('admin_lista') }}" class="btn btn-outline-danger">Limpiar</a>
      </div>
    </form>

    <!-- Tabla -->
    <div class="table-responsive shadow-sm">
      <table class="table table-striped table-bordered align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th>Nombres</th>
            <th>Primer Apellido</th>
            <th>Segundo Apellido</th>
            <th>Género</th>
            <th>Tipo Documento</th>
            <th>N° Documento</th>
            <th>Celular</th>
            <th>Correo</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          @forelse($user as $u)
          <tr>
            <td>{{ $u->Nombres }}</td>
            <td>{{ $u->Primer_Apellido }}</td>
            <td>{{ $u->Segundo_Apellido }}</td>
            <td>{{ $u->Genero->Genero }}</td>
            <td>{{ $u->TD->Documento }}</td>
            <td>{{ $u->N_Documento }}</td>
            <td>{{ $u->Celular }}</td>
            <td>{{ $u->Correo }}</td>
            <td>
              @if($u->Activida)
                <span class="badge bg-success">Activo</span>
              @else
                <span class="badge bg-danger">Desactivado</span>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="9" class="text-muted py-3">No se encontraron resultados</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </main>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
