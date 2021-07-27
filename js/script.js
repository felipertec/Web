
function validar(){

    var cNCategory = formulario.cNCategory;
    var cDescription = formulario.cDescription;

    if(cNCategory.value == ""){
        alert("Nome não informado!");

        cNCategory.focus();
    }

    if(cDescription.value == ""){
        alert("Descrição não informada!");

        cDescription.focus();
    }
}
