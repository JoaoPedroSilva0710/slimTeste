

$("body").on("click", "#btnSubmit" , async () => {
    const form = new FormData(document.getElementById("formulario"));

    const response = await fetch('/login', {
        method: 'POST',
        body: form
    });
    const obj = response.json();
    console.log(obj);



});