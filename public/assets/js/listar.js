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
                        <button class="delete-btn" data-id="${row.id}" id="btn-edit-pacient">
                            <img src="/assets/imgs/editBtnImg.png" class="img-fluid">
                        </button>
                        <button class="edit-btn" data-id="${row.id}" id="btn-del-pacient">
                            <img src="/assets/imgs/deleteBtnImg.png" class="img-fluid">
                        </button>
                    </div>
                    `;
            }
        }
        ]
});

    return table;

}


$("body").on("click", "#btn-edit-pacient", async e => {
        let id = e.target.dataset.id;

        let response = await fetch(`${urlPacientes}/${id}`);

        let obj = await response.json();

        populaFormulario(await obj);

        let modal = document.getElementById("dialogEditaFormulario");
        modal.show();

        alert(id);
        
});


const populaFormulario = async (obj) => {
    Object
    .entries(obj[0])
    .forEach(([key, value]) => {
        console.log(`${key} -- ${value}`);
        $(`#${key}`).val(value);
    })

};





