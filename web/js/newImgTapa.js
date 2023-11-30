var tipValid =
    [
        'image/jpeg',
        'image/png'
    ];

function validarTip(file){
    for(var i=0;i<tipValid.length;i++){
        if(file.type===tipValid[i]){
            return true;
        }
    }
    return false;
}

function onChange(event){
    var file=event.target.files[0];
    if(validarTip(file)){
        var tapaMiniatura=document.getElementById('tapaThumb');
        tapaThumb.src=window.URL.createObjectURL(file);
    }
}