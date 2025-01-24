import * as requests from "./module/requests.js";

$(
async() => 
{
    await constructDataTable();
   
});

const fetchPacients = async() => 
{
    let response = await fetch(requests.urlPacientes);
    let obj = await response.json();
    let data = await obj.data;

    return data;

}


const constructDataTable = async() => {
    let data = fetchPacients();

    let table = new DataTable('#tablePacientes', {
        data: await data,
        columns: [
            { data: "nome" },
            { data: "data_nascimento" },
            { data: "sexo" },
            { data: "nome_mae" },
            { data: "email" },
            { data: "cpf" },
            { data: "cep" },
            { data: "nome_rua" },
            { data: "numero_casa" },
            { data: "bairro" },
            { data: "uf" },
            { render: function(data, type, row) {
             return `<div class="divButtonClass">
                            <i class="fa-solid fa-pencil btn_edit_pacient" data-id="${row.id}"></i>
                            <i class="fa-solid fa-trash btn_del_pacient" data-id="${row.id}"></i>
                    </div>
                    `;
            }
        }
        ]
});
    return table;
}


const populaFormulario = (obj) => {
    Object
    .entries(obj.data[0])
    .forEach(([key, value]) => {
        $(`#${key}`).val(value);
    })
};


const cleanForm = () => {
    $(`#id`).val("");
    $(`#nome`).val("");
    $(`#data_nascimento`).val("");
    $(`#sexo`).val("");
    $(`#nome_mae`).val("");
    $(`#email`).val("");
    $(`#cpf`).val("");
    $(`#cep`).val("");
    $(`#nome_rua`).val("");
    $(`#numero_casa`).val("");
    $(`#bairro`).val("");
    $(`#uf`).val("");
};



let message = (icon, mensagem) => {
    Swal.fire({
        icon: icon,
        text: mensagem,
        showConfirmButton: false,
        timer: 1500
      })};


$("body").on("click", ".btn_edit_pacient", async e => {
    try {
        let id = e.target.dataset.id;

        $("#id").val(`${e.target.dataset.id}`);

        let response = await fetch(`${requests.urlPacientes}/${id}`);

        let obj = await response.json();    

        populaFormulario(obj);

        $("#dialogEditaFormulario").modal('show');
    } catch (exception) {
        alert(exception);
    }
});


$("body").on("click", ".btn_del_pacient", async e => {
    try {
        $("#id").val(`${e.target.dataset.id}`);

        let form = new FormData(document.getElementById("formulario"));

        let request = await fetch(`${requests.urlPacienteDelete}`, {
            method: "POST",
            body: form
        });

        let response = await request.json();

        if (!response.data['icon']) {
            return message('error', 'Erro desconhecido');

        }

        message(response.data['icon'], response.data['msg']);

        if(response.data['icon'] != 'error') {
            return setTimeout(() => {  window.location.reload() }, 1000);
    }

    } catch (exception) {

        message('error', exception);
    }
});


$("body").on("click", "#btn_submit_modal", async (e) => {

    let form = new FormData(document.getElementById("formulario"));

    let request = await fetch(`${requests.urlPacientes}`, {
        method: "POST",
        body: form

    });
    
    let response = await request.json();

    message(response.data['icon'], response.data['msg']);

    if (!response.data['icon']) {
        return message('error', 'Erro desconhecido');

    }

    if(response.data['icon'] != 'error') {
        $("#dialogEditaFormulario").modal('hide');

        return setTimeout(() => {  window.location.reload() }, 1000);     
}

});


$("body").on("click", "#btn_show_cadastrate_pacient", () => {
    cleanForm();  
    $("#dialogEditaFormulario").modal('show');
})