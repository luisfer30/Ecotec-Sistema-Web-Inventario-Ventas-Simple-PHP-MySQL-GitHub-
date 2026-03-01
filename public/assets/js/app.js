document.addEventListener("DOMContentLoaded", () => {
    console.log("app.js cargó ✅", typeof Swal);

    // 1) SweetAlert confirm delete

    document.addEventListener("submit", async (e) => {
        const form = e.target;
        if (!(form instanceof HTMLFormElement)) return;

        if (form.dataset.confirm !== "delete") return;

        // Evita doble ejecución si otro handler ya canceló
        if (e.defaultPrevented) return;

        e.preventDefault();
        if (typeof Swal === "undefined") {
            if (confirm("¿Eliminar producto? Esta acción no se puede deshacer.")) {
                form.submit();
            }
            return;
        }

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
    });

    // 2) Buscador (filtra filas)

    const input = document.getElementById("searchProductos");
    const badge = document.getElementById("countVisible");

    if (input && badge) {
        const getRows = () => Array.from(document.querySelectorAll("tbody tr"));

        const updateCount = () => {
            const rows = getRows();
            const visible = rows.filter((r) => r.style.display !== "none").length;
            badge.textContent = `Mostrando: ${visible}`;
        };

        input.addEventListener("input", () => {
            const q = input.value.trim().toLowerCase();
            const rows = getRows();

            rows.forEach((r) => {
                // Columna 2 = Nombre
                const nameCell = r.querySelector("td:nth-child(2)");
                const text = (nameCell?.textContent || "").toLowerCase();
                r.style.display = text.includes(q) ? "" : "none";
            });

            updateCount();
        });

        updateCount();
    }
});