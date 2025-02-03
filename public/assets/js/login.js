$("body").on("click", "#btnSubmit" , async () => {
    const form = new FormData(document.getElementById("formulario"));

    const response = await fetch(urlLogin, {
        method: 'POST',
        body: form
    });

    const obj = await response.json();
    const data = await obj.data;

    if(obj.statusCode != 200){
        message(data['icon'], data['msg']);
    }

    else{
        window.location.href = urlSender;
    }

});