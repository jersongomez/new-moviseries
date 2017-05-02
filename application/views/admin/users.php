<?php
require_once 'base.php';
$token = password_hash("token", PASSWORD_DEFAULT);
?>

<?php startblock('title') ?>Usuarios<?php endblock() ?>


<?php startblock('main-content') ?>
<h2 class="text-center" style="background-color: #E91E63; color: #fff; text-transform: uppercase;">Usuarios
    Moviseries</h2>
<hr>
<div class="container">
    <table id="data-table" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Email</th>
            <th>Tipo</th>
            <th>Editar/Eliminar</th>
        </tr>
        </thead>

        <tfoot>
        <tr>

            <th><input style="max-width: 60px;" type="text"></th>
            <th><input type="text"></th>
            <th><input type="text" type="text"></th>
            <th><select name="" id="">
                    <option value="">TODAS</option>
                    <option value="admin">Administrador</option>
                    <option value="free">Free</option>
                    <option value="pro">pro</option>

                </select></th>
            <th></th>


        </tr>
        </tfoot>

    </table>

    <hr>


    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog" role="document">
            <div class="modal-content">


                <div class="modal-header">
                    <h5 class="modal-title">Actualizar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-edit" action="">
                        <div id="body-edit"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>


</div>


<?php endblock() ?>

<?php startblock('scripts') ?>
<script>
    var table;
    var running = false;
    $(function () {
        table = $('#data-table').DataTable({
            "ajax": {
                "bProcessing": true,
                "url": "<?php echo base_url('admin/get-users')?>",
                "data": {
                    "_token": "<?php echo $token ?>"
                },
                "type": "POST"
            },
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
        });


        // Apply the search
        table.columns().every(function () {
            var that = this;

            $('input,select', this.footer()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });


        $('#form-n').submit(function () {

            if (running == false) {
                running = true;
                $.notify(
                    "cargando...",
                    {
                        className: "info",
                        position: "bottom left",
                    });

                var file_data = $('#icon').prop('files')[0];
                var form_data = new FormData();
                form_data.append('img', file_data);
                form_data.append('name', $('#nombre_n').val());

                $.ajax({
                    url: $('#form-n').attr('action'),
                    dataType: 'text',  // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function (data) {

                        running = false;
                        if ($.trim(data) === 'exito') {
                            $.notify(
                                "IDIOMA CREADO",
                                {
                                    className: "success",
                                    position: "bottom left",
                                });
                            update();
                            $('#form-n').trigger('reset');

                            $('#modal-nuevo-idioma').modal('hide');

                        } else {
                            alert(data);
                        }
                    }
                });

            }


            return false;
        });


        $('#form-edit').submit(function () {

            if (running == false) {
                running = true;
                $.notify(
                    "cargando...",
                    {
                        className: "info",
                        position: "bottom left",
                    });


                $.ajax({
                    url: '<?php echo base_url('admin/edit-user') ?>',
                    data: $('#form-edit').serialize(),
                    type: 'post',
                    success: function (data) {

                        running = false;
                        if ($.trim(data) === 'exito') {
                            $.notify(
                                "USUARIO ACTUALIZADO",
                                {
                                    className: "success",
                                    position: "bottom left",
                                });
                            update();
                            $('#modal-edit').modal('hide');

                        } else {
                            alert(data);
                        }
                    }
                });

            }


            return false;
        });


    });


    function update() {
        table.ajax.reload();
    }

    function edit(id) {
        $('#modal-edit').modal('show');
        $.ajax({
            url: '<?php echo base_url('admin/datos-usuario') ?>',
            type: 'post',
            data: 'id=' + id,
            success: function (result) {

                $('#body-edit').html(result);
            }
        });
    }


    function delete_item(id) {

        //mira la documentacion de jquery confirm https://craftpip.github.io/jquery-confirm/
        $.confirm({
            title: 'Eliminar Usuario?',
            content: 'Esta operación no es reversible',
            autoClose: 'cancel|6000',
            confirmButton: 'ELIMINAR',
            cancelButton: 'CANCELAR',
            confirm: function () {


                if (!running) {
                    running = true;
                    $.ajax({
                        url: '<?php echo base_url('admin/eliminar-usuario') ?>',
                        type: 'post',
                        data: 'id=' + id,
                        success: function (result) {
                            running = false;

                            if ($.trim(result) === 'exito') {
                                $.notify(
                                    "Eliminado",
                                    {
                                        className: "success",
                                        position: "bottom left",
                                    });

                                update();

                            } else {
                                alert(result);
                            }
                        }
                    });
                } else {
                    alert("espere a uqe termine la tarea en curso");
                }


            },
            cancel: function () {

            }
        });
    }

</script>
<?php endblock() ?>
