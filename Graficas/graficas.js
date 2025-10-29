// Objeto para traducir los códigos de categoría a títulos
const titulosCategorias = {
    'HAL': 'Resultados Categoría Halloween',
    'MUER': 'Resultados Catrinas y Día de Muertos',
    'LIB': 'Resultados Categoría Libre'
};

/**
 * Función que crea la visualización para un solo concursante.
 */
function crearFilaResultado(concursante, concursanteConMasVotos) {
    const item = document.createElement('div');
    item.className = 'resultado-item';

    // Calculamos el ancho de la barra como un porcentaje relativo al ganador
    const anchoBarra = concursanteConMasVotos > 0 ? (concursante.total_votos / concursanteConMasVotos) * 100 : 0;

    item.innerHTML = `
        <img src="../${concursante.ruta_foto}" alt="Foto de ${concursante.nombre_disfraz}">
        <div class="info-votacion">
            <h4>${concursante.nombre_disfraz}</h4>
            <div class="barra-fondo">
                <div class="barra-progreso" style="width: 0%;"></div>
                <span class="texto-votos">${concursante.total_votos} Votos</span>
            </div>
        </div>
    `;

    // Usamos un pequeño retraso para que la animación de la barra se vea al cargar
    setTimeout(() => {
        const barra = item.querySelector('.barra-progreso');
        if (barra) {
            barra.style.width = `${anchoBarra}%`;
        }
    }, 100);

    return item;
}

/**
 * Función principal que obtiene los resultados y construye la página.
 */
async function obtenerYMostrarResultados() {
    const contenedorResultados = document.getElementById('contenedor-resultados');
    try {
        const response = await fetch('../php/obtener_resultados.php');
        if (!response.ok) throw new Error(`Error: ${response.status}`);
        const categorias = await response.json();

        contenedorResultados.innerHTML = '';

        for (const codigoCategoria in categorias) {
            const concursantes = categorias[codigoCategoria];
            if (concursantes.length === 0) continue; // Si no hay concursantes, saltar categoría

            // Crear el título de la categoría
            const titulo = document.createElement('h2');
            titulo.className = 'titulo-categoria';
            titulo.textContent = titulosCategorias[codigoCategoria] || codigoCategoria;
            contenedorResultados.appendChild(titulo);

            // Encontrar el concursante con más votos en esta categoría para la escala de la barra
            const concursanteGanador = concursantes.reduce((max, p) => p.total_votos > max ? p.total_votos : max, 0);

            // Crear una fila para cada concursante
            concursantes.forEach(concursante => {
                const fila = crearFilaResultado(concursante, concursanteGanador);
                contenedorResultados.appendChild(fila);
            });
        }
    } catch (error) {
        console.error('No se pudieron obtener los resultados:', error);
        contenedorResultados.innerHTML = '<p style="color: white; text-align: center;">Error al cargar los resultados.</p>';
    }
}

// Ejecutamos la función al cargar la página.
obtenerYMostrarResultados();