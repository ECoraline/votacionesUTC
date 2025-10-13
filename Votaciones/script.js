const contenedorParticipantes = document.getElementById('contenedorProductos');

const Participante= [
  {
    nombre: "cmaron",
    imagen: "Imagenes/WhatsApp Image 2025-10-12 at 11.36.54_1b4236a2.jpg",
    descripcion: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos quas perspiciatis possimus illum sequi quis numquam ea maiores ratione, facilis fugiat ipsam aliquam! Corporis laudantium molestias, ipsum ex dolorem est."
  },
  {
    nombre: "io",
    imagen: "Imagenes/WhatsApp Image 2025-10-12 at 11.37.39_22fa5192.jpg",
    descripcion: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos quas perspiciatis possimus illum sequi quis numquam ea maiores ratione, facilis fugiat ipsam aliquam! Corporis laudantium molestias, ipsum ex dolorem est."
  },
  {
    nombre: "dios segun la biblia",
    imagen: "Imagenes/WhatsApp Image 2025-10-12 at 11.37.19_fd348b4f.jpg",
    descripcion: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos quas perspiciatis possimus illum sequi quis numquam ea maiores ratione, facilis fugiat ipsam aliquam! Corporis laudantium molestias, ipsum ex dolorem est."
  },
  {
    nombre: "dios segun la biblia",
    imagen: "Imagenes/WhatsApp Image 2025-10-12 at 11.37.19_fd348b4f.jpg",
    descripcion: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos quas perspiciatis possimus illum sequi quis numquam ea maiores ratione, facilis fugiat ipsam aliquam! Corporis laudantium molestias, ipsum ex dolorem est."
  },
  {
    nombre: "dios segun la biblia",
    imagen: "Imagenes/WhatsApp Image 2025-10-12 at 11.37.19_fd348b4f.jpg",
    descripcion: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos quas perspiciatis possimus illum sequi quis numquam ea maiores ratione, facilis fugiat ipsam aliquam! Corporis laudantium molestias, ipsum ex dolorem est."
  },
  {
    nombre: "dios segun la biblia",
    imagen: "Imagenes/WhatsApp Image 2025-10-12 at 11.37.19_fd348b4f.jpg",
    descripcion: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos quas perspiciatis possimus illum sequi quis numquam ea maiores ratione, facilis fugiat ipsam aliquam! Corporis laudantium molestias, ipsum ex dolorem est."
  },
  {
    nombre: "dios segun la biblia",
    imagen: "Imagenes/WhatsApp Image 2025-10-12 at 11.37.19_fd348b4f.jpg",
    descripcion: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos quas perspiciatis possimus illum sequi quis numquam ea maiores ratione, facilis fugiat ipsam aliquam! Corporis laudantium molestias, ipsum ex dolorem est."
  },
  {
    nombre: "dios segun la biblia",
    imagen: "Imagenes/WhatsApp Image 2025-10-12 at 11.37.19_fd348b4f.jpg",
    descripcion: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos quas perspiciatis possimus illum sequi quis numquam ea maiores ratione, facilis fugiat ipsam aliquam! Corporis laudantium molestias, ipsum ex dolorem est."
  },
  {
    nombre: "dios segun la biblia",
    imagen: "Imagenes/WhatsApp Image 2025-10-12 at 11.37.19_fd348b4f.jpg",
    descripcion: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos quas perspiciatis possimus illum sequi quis numquam ea maiores ratione, facilis fugiat ipsam aliquam! Corporis laudantium molestias, ipsum ex dolorem est."
  },
  {
    nombre: "dios segun la biblia",
    imagen: "Imagenes/WhatsApp Image 2025-10-12 at 11.37.19_fd348b4f.jpg",
    descripcion: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos quas perspiciatis possimus illum sequi quis numquam ea maiores ratione, facilis fugiat ipsam aliquam! Corporis laudantium molestias, ipsum ex dolorem est."
  },
  {
    nombre: "dios segun la biblia",
    imagen: "Imagenes/WhatsApp Image 2025-10-12 at 11.37.19_fd348b4f.jpg",
    descripcion: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos quas perspiciatis possimus illum sequi quis numquam ea maiores ratione, facilis fugiat ipsam aliquam! Corporis laudantium molestias, ipsum ex dolorem est."
  },
  {
    nombre: "dios segun la biblia",
    imagen: "Imagenes/WhatsApp Image 2025-10-12 at 11.37.19_fd348b4f.jpg",
    descripcion: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos quas perspiciatis possimus illum sequi quis numquam ea maiores ratione, facilis fugiat ipsam aliquam! Corporis laudantium molestias, ipsum ex dolorem est."
  },
];

function crearTarjetaParticipante(Participante) {
  const tarjeta = document.createElement('div');
  tarjeta.classList.add('tarjetaParticipante');

  tarjeta.innerHTML = `
    <img src="${Participante.imagen}" alt="${Participante.nombre}">
    <div class="infoParticipante">
      <h4>${Participante.nombre}</h4>
    </div>
    <div class="descripcionParticipante">
      <p>${Participante.descripcion}</p>
    </div>
  `;

  tarjeta.addEventListener('click', () => {
    tarjeta.classList.toggle('expandida');
  });

  contenedorParticipante.appendChild(tarjeta);
}

Participante.forEach(Participante => crearTarjetaParticipante(Participante));
