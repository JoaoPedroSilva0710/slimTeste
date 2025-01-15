
$(
async() => 
{
    let response = await fetch('/pacientes');
    let obj = await response.json();
    console.log(obj);
    new DataTable('#tablePacientes', {
        data: await obj,
        columns: [
            { title: "id" },
            { title: "nome" },
            { title: "data_nascimento" },
            { title: "sexo" },
            { title: "nome_mae" },
            { title: "email" },
            { title: "cpf" },
            { title: "cep" },
            { title: "nome_rua" },
            { title: "numero_casa" },
            { title: "bairro" },
            { title: "uf" },
            { title: "ativo" }
        ]
});
});
