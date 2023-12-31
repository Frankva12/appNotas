<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../controlador/agregar_usuario.js"></script>
    <title>Agregar Usuario</title>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Agregar Usuario</h1>
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-12">
                <div id="mensaje"></div> <!-- Element to display messages -->
                <form>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" pattern="^[a-zA-Z0-9]{3,80}$" required>
                    </div>
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" pattern="^[a-zA-Z0-9]{3,40}$" required>
                    </div>
                    <div class=" form-group">
                        <label for="contrasenia">Contraseña</label>
                        <input type="password" class="form-control" id="contrasenia" name="contrasenia" placeholder="Contraseña" required>
                    </div>
                    <div class="form-group">
                        <label for="privilegio">Privilegio</label>
                        <select class="form-control" id="privilegio" name="privilegio">
                            <option value="administrador">Administrador</option>
                            <option value="cliente">Cliente</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block mt-3">Agregar Usuario</button>
                        <a href="usuarios.php" class="btn btn-secondary btn-block mt-3">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>