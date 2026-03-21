document.addEventListener("DOMContentLoaded", () => {

  const botonesEditar = document.querySelectorAll(".btn_modificar");

  botonesEditar.forEach(btn => {
    btn.addEventListener("click", () => {
      const fila = btn.closest("tr");
      if (!fila) return;

      const filaEdit = fila.nextElementSibling;
      if (!filaEdit || !filaEdit.classList.contains("fila_edit")) return;

      document.querySelectorAll(".fila_edit").forEach(f => {
        if (f !== filaEdit) f.classList.add("hidden");
      });

      filaEdit.classList.toggle("hidden");
    });
  });

  document.querySelectorAll(".btn_cancel").forEach(btn => {
    btn.addEventListener("click", () => {
      const filaEdit = btn.closest("tr");
      if (!filaEdit) return;
      filaEdit.classList.add("hidden");
    });
  });
});

/***** RESETEAR FORMULARIO Y ESTILOS DE ERROR *****/
document.addEventListener("DOMContentLoaded", function () {

    const forms = document.querySelectorAll("form");

    forms.forEach(form => {

        form.addEventListener("reset", function () {

            // Esperamos un micro-tick para que el reset limpie valores primero
            setTimeout(() => {

                const inputs = form.querySelectorAll(".input-error");
                const smalls = form.querySelectorAll(".error-visible");

                inputs.forEach(input => {
                    input.classList.remove("input-error");
                });

                smalls.forEach(small => {
                    small.classList.remove("error-visible");
                    small.textContent = "";
                });

            }, 0);

        });

    });

});



/*************** VALIDACION DE FORMULARIO "BORRAR SOLICITUD"*************/
document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.btn_borrar').forEach(btn => {

        btn.addEventListener('click', function (e) {

            const confirmar = confirm('¿Seguro que deseas borrar esta solicitud?');

            if (!confirmar) {
                e.preventDefault();
            }
        });
    });

});
