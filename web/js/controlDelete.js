function controlDelete(path,reservation){
    swal({
        title: "Jsi si jistý?",
        text: "Soubor ["+reservation+"] bude trvale smazán!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                window.location.replace(path);
            }
        });
    return false;
}