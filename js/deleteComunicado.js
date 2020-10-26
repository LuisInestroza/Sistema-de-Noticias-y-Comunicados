// Alerta para eliminar un comunicado
$('.btn-deleteComunicado').on('click', function (e) {
    e.preventDefault();

    const href = $(this).attr('href')
    Swal.fire({
        title: 'Estas seguro de eliminar este comunicado?',
        text: "No podras recuperar este comunicado!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((result) => {
        if (result.value) {
            document.location.href = href;
        }
    })
})

const flashdata = $('.flash-dataComunicado').data('flashdatacomunicado')
if (flashdata) {
    Swal.fire(
        'Eliminado!',
        'Comunicado Eliminado Correctamente.',
        'success'
    )
}