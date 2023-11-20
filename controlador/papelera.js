function restaurarNota(idNota) {
    if (confirm("¿Estás seguro que quieres restaurar esta nota?")) {
        // Realizar la petición AJAX para cambiar el estado de la nota a activo (estado = 1)
        $.ajax({
            type: "POST",
            url: "../modelo/restaurar_nota.php",
            data: {
                id: idNota
            },
            dataType: "json",
            encode: true
        }).done(function(data) {
            if (data.status === "success") {
                window.location.href = 'papelera.php?mensaje=success_restore';
            } else {
                console.log("Error al restaurar la nota");
            }
        }).fail(function(data) {
            console.log("Error en la solicitud AJAX");
        });
    }
}

function eliminarNota(idNota) {
    if (confirm("¿Estás seguro que quieres eliminar permanentemente esta nota?")) {
        $.ajax({
            type: "POST",
            url: "../modelo/eliminar_nota.php",
            data: {
                id: idNota
            },
            dataType: "json",
            encode: true
        }).done(function(data) {
            if (data.status === "success") {
                window.location.href = 'papelera.php?mensaje=success_permanent_delete';
            } else {
                console.log("Error al eliminar permanentemente la nota");
            }
        }).fail(function(data) {
            console.log("Error en la solicitud AJAX");
        });
    }
}