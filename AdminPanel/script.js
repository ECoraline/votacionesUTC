function cambiarEstado(boton) {
    if (boton.classList.contains("pagado")) {
        boton.classList.remove("pagado");
        boton.classList.add("adeudo");
        boton.textContent = "Con Adeudo";
    } else {
        boton.classList.remove("adeudo");
        boton.classList.add("pagado");
        boton.textContent = "Pagado";
    }
}
