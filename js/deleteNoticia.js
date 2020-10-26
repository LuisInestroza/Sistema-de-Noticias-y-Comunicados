// Alerta para eliminar una noticia
$('.btn-deleteNoticia').on('click', function (e) {
    e.preventDefault();

    const href = $(this).attr('href')
    Swal.fire({
        title: 'Estas seguro de eliminar esta noticia?',
        text: "No podras recuperar este noticia!",
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

const flashdata = $('.flash-data').data('flashdata')
if (flashdata) {
    Swal.fire(
        'Eliminado!',
        'Noticia Eliminada Correctamente.',
        'success'
    )
}

