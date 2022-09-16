$(document).ready(function() {
    $('#btn-open-file').on('click', function (){
        $('.card-footer').remove();
        $('#documento').trigger('click');
    });
    //var $nameForm = frmDocumento
    $('#frmDocumento').submit(function(e){
        let alert = $('.card-footer'),
            input = $('#documento');
        alert.remove();
        if (input.get(0).files.length !== 0) {//valida si el input type file no esta vacio antes de enviar 0 = vacio
            if (input.prop("files")[0].type !== 'application/pdf') {
                e.preventDefault();
                $('#card-body').after('<div class="card-footer"><p class="fs-1"><span class="text-danger">Por favor sube un archivo de tipo PDF :))</span></p></div>');
            }
        }
    });
});