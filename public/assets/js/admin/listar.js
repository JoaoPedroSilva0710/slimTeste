$( async() => 
{
    await constructDataTable();
});

const fetchUsers = async() => 
{
    let response = await fetch(urlUsers);
    let obj = await response.json();
    let data = await obj.data;

    return data;

};


const constructDataTable = async() => {
    let data = fetchUsers();

    let table = new DataTable('#tableUsers', {
        data: await data,
        columns: [
            { data: "name" },
            { data: "cpf" },
            { data: "email" },
            { render: function(data, type, row) {
             return `<div class="divButtonClass">
                            <i class="fa-solid fa-pencil btn_edit_user" data-id="${row.id}"></i>
                            <i class="fa-solid fa-trash btn_del_user" data-id="${row.id}"></i>
                    </div>
                    `;
            }
        }
        ]
});
    return table;
};


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
    $(`#email`).val("");
    $(`#cpf`).val("");
};


$("body").on("click", "#btn_show_cadastrate_user", () => {
    cleanForm();  
    $("#dialogEditaFormulario").modal('show');
});