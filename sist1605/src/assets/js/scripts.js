$(document).ready(function() {
    // Cargar datos en el modal Ver Médico
    $('#viewMedicoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var medicoId = button.data('id');

        $.ajax({
            url: 'agremiados/view_medico.php',
            type: 'GET',
            data: { id: medicoId },
            success: function(response) {
                $('#viewMedicoModal .modal-body').html(response);
            }
        });
    });

    // Cargar datos en el modal Editar Médico
    $('#editMedicoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var medicoId = button.data('id');

        $.ajax({
            url: 'agremiados/edit_medico.php',
            type: 'GET',
            data: { id: medicoId },
            success: function(response) {
                $('#editMedicoModal .modal-body').html(response);
            }
        });
    });

    // Eliminar médico
    $('#deleteMedicoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var medicoId = button.data('id');

        $('#deleteMedicoModal button.btn-danger').click(function() {
            $.ajax({
                url: 'agremiados/delete_medico.php',
                type: 'POST',
                data: { id: medicoId },
                success: function(response) {
                    location.reload();
                }
            });
        });
    });
});
