/*
const votos = {
  "Paco": 3,
  "paco2": 2,
  "paco3": 5,
  "paco4": 1
};

const maximoVotos = Math.max(...Object.values(votos));

const grafica = document.getElementById("grafica");

for (const [nombre, cantidad] of Object.entries(votos)) {
  const porcentaje = (cantidad / maximoVotos) * 100;

  const contenedor = document.createElement("div");
  contenedor.className = "contenedorBarra";

  const etiqueta = document.createElement("div");
  etiqueta.className = "etiqueta";
  etiqueta.textContent = `${nombre} `;
  
  const cantidadVotos = document.createElement("span");
  cantidadVotos.className = "cantidadVotos";
  cantidadVotos.textContent = `(${cantidad} votos)`;

  etiqueta.appendChild(cantidadVotos);

  const contenedorRelleno = document.createElement("div");
  contenedorRelleno.className = "contenedorRelleno";

  const barra = document.createElement("div");
  barra.className = "barra";
  barra.style.width = `${porcentaje}%`;

  contenedorRelleno.appendChild(barra);
  contenedor.appendChild(etiqueta);
  contenedor.appendChild(contenedorRelleno);
  grafica.appendChild(contenedor);
}
*/
fetch("get_results.php")
  .then(res => res.json())
  .then(data => {
    const container = document.getElementById("resultadosContainer"); 

    data.forEach(item => {
      const barra = document.createElement("div");
      barra.className = "barraResultado";

      const porcentaje = item.votos * 10; 

      barra.innerHTML = `
        <label>${item.nombre}: ${item.votos} votos</label>
        <div class="barraResultado" style="width: ${porcentaje}px;"></div>
      `;

      container.appendChild(barra);
    });
  })
  .catch(error => {
    console.error("Error al cargar resultados:", error);
  });