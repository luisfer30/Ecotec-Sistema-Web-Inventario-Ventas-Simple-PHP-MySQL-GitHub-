document.addEventListener("submit", async (e) => {
    const form = e.target;

    if (form.querySelector("input[name='accion'][value='eliminar']")) {
        e.preventDefault();

        const result = await Swal.fire({
            title: "¿Eliminar producto?",
            text: "Esta acción no se puede deshacer.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
        });

        if (result.isConfirmed) {
            form.submit();
        }
    }
});