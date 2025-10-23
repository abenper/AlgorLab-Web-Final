const formularioAjax=document.querySelectorAll(".FormularioAjax");

function enviarFormuAjax(e){
    e.preventDefault();
    let env=confirm("¿Estás seguro de enviar el Formulario?");
    if(env==true){
        let data= new FormData(this);
        let method=this.getAttribute("method");
        let action=this.getAttribute("action");
        let encabezado = new Headers();
        let config={
            method:method,
            headers:encabezado,
            mode:'cors',
            cache: 'no-cache',
            body:data
        };

        fetch(action,config)
        .then(respuesta => respuesta.text())
        .then(respuesta => {
            let conte=document.querySelector(".form-rest");
            conte.innerHTML = respuesta;
        });
    }
}

formularioAjax.forEach(formul =>{
    formul.addEventListener("submit",enviarFormuAjax);
});