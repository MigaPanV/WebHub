// Confirmación antes de eliminar estudiantes.
document.addEventListener("submit", function (evento) {
    const formularioEliminar = evento.target.closest(".form-eliminar");

    if (formularioEliminar) {
        const confirmar = confirm("¿Desea eliminar este estudiante?");

        if (!confirmar) {
            evento.preventDefault();
        }
    }
});

// Validación del formulario de registro.
const formulario = document.getElementById("formEstudiante");

if (formulario) {
    const campoNombre = document.getElementById("nombre");
    const campoApellido = document.getElementById("apellido");
    const campoEdad = document.getElementById("edad");
    const campoCorreo = document.getElementById("correo");
    const mensaje = document.getElementById("mensajeError");
    const contador = document.getElementById("contadorNombre");

    // Contador de caracteres: se actualiza mientras el usuario escribe.
    if (campoNombre && contador) {
        campoNombre.addEventListener("input", function () {
            contador.textContent = campoNombre.value.length + " / 100 caracteres";
            campoNombre.classList.remove("is-invalid");
        });
    }

    formulario.addEventListener("submit", function (evento) {
        let errores = [];

        [campoNombre, campoApellido, campoEdad, campoCorreo].forEach(function (campo) {
            if (campo) {
                campo.classList.remove("is-invalid");
            }
        });

        const nombre = campoNombre ? campoNombre.value.trim() : "";
        const apellido = campoApellido ? campoApellido.value.trim() : "";
        const edad = campoEdad ? Number(campoEdad.value) : NaN;
        const correo = campoCorreo ? campoCorreo.value.trim() : "";

        if (nombre === "") {
            errores.push("Debe ingresar el nombre del estudiante.");
            campoNombre.classList.add("is-invalid");
        }

        if (apellido === "") {
            errores.push("Debe ingresar el apellido del estudiante.");
            campoApellido.classList.add("is-invalid");
        }

        if (!campoEdad.value || !Number.isFinite(edad) || edad < 1 || edad > 100) {
            errores.push("La edad debe estar entre 1 y 100 años.");
            campoEdad.classList.add("is-invalid");
        }

        if (correo === "" || !campoCorreo.checkValidity()) {
            errores.push("Debe ingresar un correo electrónico válido.");
            campoCorreo.classList.add("is-invalid");
        }

        if (errores.length > 0) {
            evento.preventDefault();
            mensaje.textContent = errores.join(" ");
            mensaje.classList.remove("d-none");
            return;
        }

        mensaje.textContent = "";
        mensaje.classList.add("d-none");
    });
}

// Comunicación dinámica: solo se ejecuta en listar.php, donde existe el tbody.
function cargarEstudiantes() {
    const tabla = document.getElementById("tabla-estudiantes");

    if (!tabla) {
        return;
    }

    const cantidad = document.getElementById("cantidadEstudiantes");
    const mensaje = document.getElementById("mensajeListado");

    // Se conserva la búsqueda y el orden seleccionados en listar.php.
    const parametros = window.location.search;
    const url = "obtener_estudiantes.php" + parametros;

    fetch(url)
        .then(function (respuesta) {
            if (!respuesta.ok) {
                throw new Error("El servidor respondió con un error HTTP: " + respuesta.status);
            }
            return respuesta.json();
        })
        .then(function (datos) {
            tabla.textContent = "";
            mensaje.classList.add("d-none");

            if (!Array.isArray(datos)) {
                throw new Error("La respuesta del servidor no contiene una lista de estudiantes.");
            }

            cantidad.textContent = datos.length;

            if (datos.length === 0) {
                const filaVacia = document.createElement("tr");
                const celdaVacia = document.createElement("td");
                celdaVacia.colSpan = 7;
                celdaVacia.className = "text-center";
                celdaVacia.textContent = "No se encontraron estudiantes.";
                filaVacia.appendChild(celdaVacia);
                tabla.appendChild(filaVacia);
                return;
            }

            datos.forEach(function (estudiante) {
                const fila = document.createElement("tr");

                const celdaNombre = document.createElement("td");
                const celdaApellido = document.createElement("td");
                const celdaEdad = document.createElement("td");
                const celdaCorreo = document.createElement("td");
                const celdaDocumento = document.createElement("td");
                const celdaPrograma = document.createElement("td");
                const celdaAcciones = document.createElement("td");

                // textContent inserta texto sin interpretarlo como HTML.
                celdaNombre.textContent = estudiante.nombre ?? "";
                celdaApellido.textContent = estudiante.apellido ?? "";
                celdaEdad.textContent = estudiante.edad ?? "";
                celdaCorreo.textContent = estudiante.correo ?? "";
                celdaDocumento.textContent = estudiante.ID ?? "";
                celdaPrograma.textContent = estudiante.programa ?? "";

                const formularioEliminar = document.createElement("form");
                formularioEliminar.action = "eliminar.php";
                formularioEliminar.method = "POST";
                formularioEliminar.className = "form-eliminar mb-2";

                const campoId = document.createElement("input");
                campoId.type = "hidden";
                campoId.name = "id";
                campoId.value = estudiante.ID;

                const botonEliminar = document.createElement("button");
                botonEliminar.type = "submit";
                botonEliminar.className = "btn btn-danger btn-sm";
                botonEliminar.textContent = "Eliminar";

                formularioEliminar.appendChild(campoId);
                formularioEliminar.appendChild(botonEliminar);
                celdaAcciones.appendChild(formularioEliminar);

                const enlaceEditar = document.createElement("a");
                enlaceEditar.href = "editar.php?id=" + encodeURIComponent(estudiante.ID);
                enlaceEditar.className = "btn btn-warning btn-sm";
                enlaceEditar.textContent = "Editar";
                celdaAcciones.appendChild(enlaceEditar);

                fila.appendChild(celdaNombre);
                fila.appendChild(celdaApellido);
                fila.appendChild(celdaEdad);
                fila.appendChild(celdaCorreo);
                fila.appendChild(celdaDocumento);
                fila.appendChild(celdaPrograma);
                fila.appendChild(celdaAcciones);
                tabla.appendChild(fila);
            });

        })
        .catch(function (error) {
            console.error("Error al obtener los estudiantes:", error);
            cantidad.textContent = "—";
            tabla.textContent = "";

            const filaError = document.createElement("tr");
            const celdaError = document.createElement("td");
            celdaError.colSpan = 7;
            celdaError.className = "text-center";
            celdaError.textContent = "No fue posible cargar los estudiantes. Verifica la conexión con el servidor.";
            filaError.appendChild(celdaError);
            tabla.appendChild(filaError);

            mensaje.textContent = "Error al consultar los estudiantes. Revisa que Apache y MySQL estén activos y que obtener_estudiantes.php funcione.";
            mensaje.classList.remove("d-none");
        });
}

cargarEstudiantes();


function mostrarNotificacion(mensaje, tipo = "success") {
    const contenedor =
        document.getElementById("mensajeNotificacion") ||
        document.getElementById("mensajeListado");

    if (!contenedor) {
        return;
    }

    contenedor.textContent = mensaje;
    contenedor.className = `alert alert-${tipo}`;
    contenedor.setAttribute("role", "alert");
    contenedor.scrollIntoView({ behavior: "smooth", block: "center" });
}

document.addEventListener("DOMContentLoaded", function () {
    const parametros = new URLSearchParams(window.location.search);
    const estado = parametros.get("estado");

    const mensajes = {
        guardado: {
            texto: "Registro guardado exitosamente.",
            tipo: "success"
        },
        eliminado: {
            texto: "Estudiante eliminado correctamente.",
            tipo: "success"
        },
        error_guardar: {
            texto: "No fue posible guardar el registro.",
            tipo: "danger"
        },
        error_eliminar: {
            texto: "No fue posible eliminar el estudiante.",
            tipo: "danger"
        },
        datos_invalidos: {
            texto: "Por favor, verifica todos los datos ingresados.",
            tipo: "warning"
        },
        correo_invalido: {
            texto: "El formato del correo electrónico no es válido.",
            tipo: "warning"
        },
        edad_invalida: {
            texto: "La edad debe ser un número entre 1 y 100.",
            tipo: "warning"
        },
        programa_invalido: {
            texto: "El programa seleccionado no es válido.",
            tipo: "warning"
        },
        correo_repetido: {
            texto: "El correo ya está registrado.",
            tipo: "warning"
        },

        id_invalido: {
            texto: "El identificador del estudiante no es válido.",
            tipo: "warning"
        },
        
        no_encontrado: {
            texto: "El estudiante no existe o ya fue eliminado.",
            tipo: "warning"
        }
    };

    if (estado && mensajes[estado]) {
        mostrarNotificacion(
            mensajes[estado].texto,
            mensajes[estado].tipo
        );

        // Quita el parámetro de la dirección para no repetir la alerta.
        parametros.delete("estado");
        const nuevaQuery = parametros.toString();
        const nuevaUrl = window.location.pathname +
            (nuevaQuery ? "?" + nuevaQuery : "") +
            window.location.hash;

        window.history.replaceState({}, document.title, nuevaUrl);
    }
});


