<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Agregar Nota</title>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Agregar Nota</h1>
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-12">
                <form>
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="titulo" placeholder="Título" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" rows="4" placeholder="Descripción" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoría</label>
                        <select class="form-control" id="categoria">
                            <option value="categoria1">Categoría 1</option>
                            <option value="categoria2">Categoría 2</option>
                            <option value="categoria3">Categoría 3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="date" class="form-control" id="fecha" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block mt-3">Agregar Nota</button>
                        <a href="notas.php" class="btn btn-secondary btn-block mt-3">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>