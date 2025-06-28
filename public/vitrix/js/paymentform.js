
$(document).ready(function() {
    $(".compra_validacion").click(function() {
        let efectivo_mio = $(this).data("efectivo"); // Obtener el balance del usuario
        let efectivo_precio = $(this).data("precio");
        let url = $(this).data("url");
        let url_balances= $(this).data("balances");
        let id_precio = $(this).data("id");
        OpenValidation(efectivo_mio,efectivo_precio,id_precio,url,url_balances);
    });
});
function OpenValidation(a, b, id_precio, url, url_balances) {
    let titulo = "";
    let tipo = "";
    let descripcion = "";
    let metodo = 0;

    if (b < a) {
        titulo = window.trans.realizar_compra;
        tipo = "info";
        descripcion = window.trans.saldo_disponible;
        metodo = 1;
    } else {
        metodo = 0;
        tipo = "error";
        titulo = window.trans.saldo_insuficiente;
        descripcion = window.trans.no_saldo;
    }

    Modal(titulo, tipo, descripcion, url, metodo, url_balances);
}

function Modal(titulo,tipo,descripcion,url,metodo,url_balances){
    let decicion=metodo==1?"Comprar":"Recargar";
    Swal.fire({
        title: titulo,
        text: descripcion,
        icon: tipo, // "success", "error", "warning", "info" o "question"
        showCancelButton: true, // Muestra el botón de cancelar
        confirmButtonText: decicion,
        cancelButtonText: window.trans.cancelar,
         confirmButtonText: window.trans.comprar,
        confirmButtonColor: "#28a745", // Verde
        cancelButtonColor: "#dc3545"   // Rojo
    }).then((result) => {
        if (result.isConfirmed) {
            if(metodo==0){
                window.location.href = url;  
            }else{
                Swal.fire({
                    title: window.trans.proceso,
                    text: window.trans.espera,
                    icon: "info",
                    allowOutsideClick: false, // No permitir cerrar haciendo clic afuera
                    allowEscapeKey: false, // No permitir cerrar con tecla ESC
                    showConfirmButton: false, // Ocultar botón de confirmar
                    didOpen: () => {
                        Swal.showLoading(); // Mostrar icono de carga
                    }
                });
                compra_balances(url_balances);
              
            }
           
            //console.log("El usuario aceptó.");
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            console.log("El usuario canceló.");
        }
    });;
}

function compra_balances(url_balances){
   let token=window.csrf = document.querySelector("meta[name='csrf-token']").getAttribute("content");
    
    fetch(url_balances, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": token 
        }
       
    })
    .then(response => response.json())
    .then(data => {
        console.log("Respuesta:", data);
        // Redirigir después del POST
       window.location.href = "/dashboard";
    })
    .catch(error => console.error("Error:", error));
    
}

