const urlPacientes = '/pacientes';

$(
async() => 
{
    await constructDataTable();
   
});

const fetchPacients = async() => 
{
    let response = await fetch(urlPacientes);
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
            { data: "ativo" },
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

// function populaFormulario(obj){
//     console.log(`Dentro da função ${JSON.stringify(obj)}`);
// }

const populaFormulario = (obj) => {
    Object
    .entries(obj.data[0])
    .forEach(([key, value]) => {
        $(`#${key}`).val(value);
    })

    // Object.keys(obj.data[0]).forEach(e => {
    //     console.log(e);
    // })

};



let message = (icon, mensagem) => {
    Swal.fire({
        position: "top-end",
        icon: icon,
        title: mensagem,
        showConfirmButton: false,
        timer: 1500
      })};


$("body").on("click", ".btn_edit_pacient", async e => {
    try {

        let id = e.target.dataset.id;
        $("#id").val(`${e.target.dataset.id}`);

        let response = await fetch(`${urlPacientes}/${id}`);

        let obj = await response.json();    

        populaFormulario(obj);

        let modal = document.getElementById("dialogEditaFormulario");

        modal.show();


    } catch (exception) {

        alert(exception);
    }

        
});

$("body").on("click", ".btn_del_pacient", async e => {
    try {
        $("#id").val(`${e.target.dataset.id}`);

        $("#ativo").val("TRUE");

        let request = await fetch(`${urlPacientes}`, {
            method: "POST",
            body: form
        });

        let obj = await request.json();

        console.log(obj);

        window.location.reload();

    } catch (exception) {

        alert(exception);
    }

    
});


$("body").on("click", "#btn_submit_modal", async (e) => {

    let form = new FormData(document.getElementById("formulario"));

    let request = await fetch(`${urlPacientes}`, {
        method: "POST",
        body: form

    });
    
    let response = await request.json();

    console.log(await response.data['icon']);

    message(response.data['icon'], response.data['msg']);

   
});


$("body").on("click", "#btn_close_modal", () => {
    let modal = document.getElementById("dialogEditaFormulario");

    modal.close();

})








