// --- CONFIGURACIÓN ---
const titulosCategorias = {
    'HAL': 'Categoría Halloween',
    'MUER': 'Catrinas y Día de Muertos',
    'LIB': 'Categoría Libre'
};

// --- LÓGICA DE VOTACIÓN ---

/**
 * Función que se ejecuta cuando el usuario hace clic en un botón de "VOTAR".
 * @param {string} idConcursante - El ID del concursante por el que se vota.
 * @param {string} codigoCategoria - El código de la categoría (ej: 'HAL', 'MUER').
 * @param {HTMLElement} botonPresionado - El botón específico que se presionó.
 */
async function registrarVoto(idConcursante, codigoCategoria, botonPresionado) {
    try {
        // 1. Enviamos el ID al script PHP usando fetch con el método POST.
        const response = await fetch('../php/registrar_voto.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ concursante_id: idConcursante })
        });

        const resultado = await response.json();

        // 2. Si el servidor confirma que el voto se guardó...
        if (response.ok) {
            console.log(resultado.mensaje); // "Voto registrado exitosamente."

            // 3. Guardamos en la memoria del navegador que ya se votó en esta categoría.
            localStorage.setItem(`voto_categoria_${codigoCategoria}`, 'true');

            // 4. Damos retroalimentación visual al usuario.
            deshabilitarCategoria(codigoCategoria, botonPresionado);
        } else {
            // Si el servidor da un error, lo mostramos.
            throw new Error(resultado.error || 'Error desconocido del servidor.');
        }

    } catch (error) {
        console.error('Error al registrar el voto:', error);
        alert('Hubo un problema al registrar tu voto. Por favor, inténtalo de nuevo.');
    }
}

/**
 * Deshabilita todos los botones de una categoría después de un voto exitoso.
 * @param {string} codigoCategoria - El código de la categoría a deshabilitar.
 * @param {HTMLElement} botonVotado - El botón específico que se votó.
 */
function deshabilitarCategoria(codigoCategoria, botonVotado) {
    // Buscamos el contenedor de la categoría correcta
    const contenedor = document.getElementById(`categoria-${codigoCategoria}`);
    if (!contenedor) return;

    // Obtenemos TODOS los botones de votar dentro de esa categoría.
    const todosLosBotones = contenedor.querySelectorAll('.boton-votar');
    
    // Los deshabilitamos todos.
    todosLosBotones.forEach(boton => {
        boton.disabled = true;
        boton.textContent = 'Ya votaste aquí';
        boton.style.backgroundColor = '#6c757d'; // Color gris
    });

    // Cambiamos el estilo del botón específico que se votó para que destaque.
    if (botonVotado) {
        botonVotado.textContent = '¡VOTO ENVIADO!';
        botonVotado.style.backgroundColor = '#007bff'; // Color azul
    }
}

// --- LÓGICA PARA CREAR LA PÁGINA ---

/**
 * Función que crea una tarjeta de concursante.
 */
function crearTarjetaParticipante(concursante, contenedor, codigoCategoria) {
    const tarjeta = document.createElement('div');
    tarjeta.classList.add('tarjetaParticipante');
    tarjeta.innerHTML = `
        <img src="../${concursante.ruta_foto}" alt="Foto de ${concursante.nombre_disfraz}">
        <div class="infoParticipante"><h4>${concursante.nombre_disfraz}</h4></div>
        <div class="descripcionParticipante"><p>${concursante.descripcion_disfraz}</p></div>
        <button class="boton-votar" data-id="${concursante.id}">VOTAR POR ESTE</button>
    `;

    tarjeta.addEventListener('click', () => {
        const actualSeleccionada = contenedor.querySelector('.tarjetaParticipante.seleccionada');
        if (actualSeleccionada && actualSeleccionada !== tarjeta) {
            actualSeleccionada.classList.remove('seleccionada');
        }
        tarjeta.classList.toggle('seleccionada');
    });

    // Añadimos el evento al botón de votar
    const botonVotar = tarjeta.querySelector('.boton-votar');
    botonVotar.addEventListener('click', (evento) => {
        evento.stopPropagation();
        registrarVoto(concursante.id, codigoCategoria, botonVotar); // Llamamos a la nueva función
    });

    contenedor.appendChild(tarjeta);
}

/**
 * Función principal que obtiene los datos y construye la página.
 */
async function obtenerYMostrarConcursantes() {
    const contenedorPrincipal = document.getElementById('contenedor-principal');
    try {
        const response = await fetch('../php/obtener_concursantes.php');
        if (!response.ok) throw new Error(`Error: ${response.status}`);
        const categorias = await response.json();

        contenedorPrincipal.innerHTML = '';

        for (const codigoCategoria in categorias) {
            const titulo = document.createElement('h2');
            titulo.className = 'titulo-categoria';
            titulo.textContent = titulosCategorias[codigoCategoria] || codigoCategoria;
            contenedorPrincipal.appendChild(titulo);

            const contenedorCategoria = document.createElement('div');
            contenedorCategoria.className = 'contenedorParticipante';
            // Le añadimos un ID único al contenedor de la categoría
            contenedorCategoria.id = `categoria-${codigoCategoria}`;
            contenedorPrincipal.appendChild(contenedorCategoria);

            const concursantesDeCategoria = categorias[codigoCategoria];
            concursantesDeCategoria.forEach(concursante => {
                crearTarjetaParticipante(concursante, contenedorCategoria, codigoCategoria);
            });

            // --- REVISIÓN DE VOTOS ANTERIORES ---
            // Después de crear la categoría, revisamos si ya se votó aquí.
            if (localStorage.getItem(`voto_categoria_${codigoCategoria}`) === 'true') {
                deshabilitarCategoria(codigoCategoria, null); // Pasamos null porque no hay un botón específico
            }
        }
    } catch (error) {
        console.error('No se pudieron obtener los concursantes:', error);
        contenedorPrincipal.innerHTML = '<p style="color: white; text-align: center;">Error al cargar los participantes.</p>';
    }
}

// Ejecutamos la función al cargar la página.
obtenerYMostrarConcursantes();
