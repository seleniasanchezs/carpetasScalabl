init_modal_resultado();
let fecha_elegida;
btn = document.querySelectorAll(".btn_inscribirme");
if ( btn != null ) {
    btn.forEach(b => {
        b.addEventListener("click", () => {
            fecha_elegida = b.dataset.fecha;
            $("#modal_registro").modal("show");
        });
    })
}

let btn_enviar = document.querySelector("#btn_enviar");

if ( btn_enviar != null ) {
    btn_enviar.addEventListener("click", () => {
        ocultar_alertas();
        let nombre = document.querySelector("#tb_nombre").value;
        let apellido = document.querySelector("#tb_apellido").value;
        let email = document.querySelector("#tb_email").value;
        let flag = true;

        if ( nombre == "" ) {
            $("#alerta_nombre").show();
            flag = false;
        }
        if ( apellido == "" ) {
            $("#alerta_apellido").show();
            flag = false;
        }
        if ( email == "" ) {
            $("#alerta_email").show();
            flag = false;
        }

        if ( flag ) {
            let datos = [nombre, apellido, email, fecha_elegida]
            btn_enviar.innerHTML = "Enviando";
            btn_enviar.disabled = true;
            guardar_registro(datos);
        }
    });
}

function guardar_registro(datos) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let respuesta = this.responseText;
            $("#modal_registro").modal("hide");
            if ( respuesta == 1 ) {
                $("#modal_registro_resultado").modal("show");
            } else {
                $(".modal-title-registro-resultado").html("¡Error!")
                $(".modal-body-registro-resultado").html("Ha ocurrido un error. Por favor, contáctanos.")
                $("#modal_registro_resultado").modal("show");
            }
            btn_enviar.innerHTML = "Enviar";
            btn_enviar.disabled = false;
        }
    };
    xhttp.open("POST", "funciones.php?", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("guardar_registro&nombre=" + datos[0] + "&apellido=" + datos[1] + "&email=" + datos[2] + "&fecha_elegida=" + datos[3]);
}




function ocultar_alertas() {
    $("#alerta_nombre").hide();
    $("#alerta_apellido").hide();
    $("#alerta_email").hide();
}

function validar_email(email){
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if (reg.test(email.value) == false) {
        $("#alerta_email").show();
        return false;
    }
    return true;
}

function init_modal_resultado() {
    $(".modal-title-registro-resultado").html("¡Listo!")
    $(".modal-body-registro-resultado").html("El formulario se ha enviado correctamente. Te contactaremos por email para brindarte más información sobre el inicio de la cursada.")
}