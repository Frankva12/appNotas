<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Inicio de Sesión</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">Inicio de Sesión</h3>
                        <form>
                            <div class="form-group">
                                <label for="username">Usuario</label>
                                <input type="text" class="form-control" id="username" placeholder="Usuario" required maxlength="40">
                                <div class="invalid-feedback">Usuario inválido. Debe tener entre 1 y 40 caracteres.</div>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" placeholder="Contraseña" required minlength="3" maxlength="40">
                                <div class="invalid-feedback">Contraseña inválida. Debe tener entre 3 y 40 caracteres.</div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
