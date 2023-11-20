function abrirModalEditarUsuario(element) {
    var id = $(element).data('id');
    var nombre = $(element).data('nombre');
    var usuario = $(element).data('usuario');
    var contrasenia = $(element).data('contrasenia');
    var privilegio = $(element).data('privilegio');

    $('#idUsuarioEditar').val(id);
    $('#nombreUsuario').val(nombre);
    $('#usuarioUsuario').val(usuario);
    $('#usuarioContrasenia').val(contrasenia);
    $('#privilegioUsuario').val(privilegio);

    $('#editarUsuarioModal').modal('show');
}

function editarUsuario() {
    var id = $('#idUsuarioEditar').val();
    var nuevoNombre = $('#nombreUsuario').val();
    var nuevoUsuario = $('#usuarioUsuario').val();
    var nuevaContrasenia = $('#usuarioContrasenia').val();
    var nuevoPrivilegio = $('#privilegioUsuario').val();

    // Validar campos
    if (nuevoNombre.length === 0 || nuevoNombre.length > 120) {
        alert('Error: El nombre debe tener entre 1 y 120 caracteres.');
        return;
    }

    if (nuevoUsuario.length === 0 || nuevoUsuario.length > 50 || !/^[a-zA-Z0-9]+$/.test(nuevoUsuario)) {
        alert('Error: El usuario debe tener entre 1 y 50 caracteres y solo se permiten letras y números.');
        return;
    }

    if (nuevaContrasenia.length === 0 || nuevaContrasenia.length > 50) {
        alert('Error: La contraseña debe tener entre 1 y 50 caracteres.');
        return;
    }

    $.ajax({
        url: '../modelo/editar_usuario.php',
        type: 'POST',
        data: {
            id: id,
            nuevoNombre: nuevoNombre,
            nuevoUsuario: nuevoUsuario,
            nuevaContrasenia: nuevaContrasenia,
            nuevoPrivilegio: nuevoPrivilegio
        },
        success: function(response) {
            if (response === 'success') {
                location.href = 'usuarios.php?mensaje=success_update';
            } else {
                alert('Error al editar el usuario.');
            }
        }
    });
}