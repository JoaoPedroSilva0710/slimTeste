import * as requests from "/assets/js/module/requests.js";
import { message } from "/assets/js/module/ownFunctions.js";

$("body").on("click", "#btn_submit", async () => {

    $('#id').val("");                   

    let form = new FormData(document.getElementById("formulario"));
    
    let request = await fetch(`${requests.urlUsers}`, {
        method: "POST",
        body: form
    });
    
    let response = await request.json();
    console.log(await response);
    
    if (response.statusCode === 500) {
        return message('error', 'Erro desconhecido');
    }
    
    
    console.log(`$('#privileges').val()`)

    if(response.data['icon'] != 'error') {
        $("#dialogEditaFormulario").modal('hide');
        
        message(response.data['icon'], response.data['msg']);
    
        return setTimeout(() => {  window.location.reload() }, 1000);  
        }
        else{

            return message(response.data['icon'], response.data['msg']);
        }   


});
