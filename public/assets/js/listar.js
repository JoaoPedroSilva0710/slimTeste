$(document).ready( function () {
    $('#tablePacientes').DataTable();
} );

let response = await fetch('/pacientes');
let obj = response.json();

new DataTable('#tablePacientes', {
    "ajax": obj
});

