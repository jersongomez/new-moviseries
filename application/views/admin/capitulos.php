<?php
require_once 'base.php';
$token = password_hash("token", PASSWORD_DEFAULT);
?>

<?php startblock('title') ?>Temporadas serie<?php endblock() ?>


<?php startblock('main-content') ?>
<h2 class="text-center" style="background-color: #E91E63; color: #fff; padding: 5px; ">
    <?php echo $serie->serie_name ?> : Temporada <?php echo $temporada->number ?> </h2>
<hr>
<div class="container">

    <div class="w-100">
        <button href="#modal-new-link" data-toggle="modal" class="btn btn-primary">
            <i class="icon-list-add"></i> Nuevo Episodio
        </button>
        <a class="btn btn-info" href="<?php echo base_url('admin/series/'.$serie->serie_id.'/temporadas') ?>"><i class="icon-left"></i> Volver a temporadas</a>
    </div>
    <hr>


    <table id="data-table" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>URL ID</th>
            <th>Episodio #</th>
            <th>Nombre</th>
            <th>file_id</th>
            <th>Idioma</th>
            <th>calidad</th>
            <th>Servidor</th>
            <th>Editar/Eliminar</th>
        </tr>
        </thead>
    </table>
    <hr>

    <div class="modal fade" id="modal-new-link">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form id="form-new-link" action="<?php echo base_url('admin/serie/insert-enlaces') ?>"
                      enctype="multipart/form-data">

                    <input name="season_id" type="text" value="<?php echo $temporada->season_id ?>" hidden>

                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo Enalce</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--Body-->
                        <div class="md-form text-left">

                            <label for="">Nombre</label>
                            <input required name="episode_name" type="text" class="form-control">

                            <br>


                            <div class="row">
                                <div class="col-3">
                                    <label for=""># episodio</label>
                                    <input required name="episode" type="number" value="1" class="form-control">
                                </div>

                                <div class="col-9">
                                    <label><i class="icon-link-4 prefix"></i> File ID: </label>
                                    <input required type="text" name="link" class="form-control"
                                           placeholder="id del archivo openload, stream moe, google drive">
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-4">
                                    <select class="form-control w-100" name="idioma" id="">
                                        <option value="latino">latino</option>
                                        <option value="castellano">castellano</option>
                                        <option value="ingles">ingles</option>
                                        <option value="subtitulado">subtitulado</option>
                                    </select>

                                </div>
                                <div class="col-4">


                                    <select class="form-control w-100" name="calidad" id="">
                                        <option value="HD720p">HD720p</option>
                                        <option value="HD1080p">HD1080p</option>
                                        <option value="Dvdrip">Dvdrip</option>
                                        <option value="HQ">HQ</option>
                                        <option value="Cam">Cam</option>
                                    </select>
                                </div>

                                <div class="col-4">


                                    <select class="form-control w-100" name="servidor" id="">
                                        <option value="stream.moe">Streammoe</option>
                                        <option value="openload">Openload</option>
                                        <option value="google drive">Google Drive</option>
                                    </select>
                                </div>
                            </div>

                            <br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">CREAR ENLACE</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>


            </div>
        </div>
    </div>


</div>


<?php endblock() ?>

<?php startblock('scripts') ?>
<script>
    var table;
    var img64;
    var running = false;
    $(function () {
        table = $('#data-table').DataTable({
            "ajax": {
                "bProcessing": true,
                "url": "<?php echo base_url('admin/capitulos-temporada')?>",
                "data": {
                    "_token": "<?php echo $token ?>",
                    "temp_id": "<?php echo $temporada->season_id ?>"
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




        $('#form-new-link').submit(function () {

            if (!running) {
                $.notify(
                    "cargando...",
                    {
                        className: "info",
                        position: "bottom left",
                    });
                running = true;

                $.ajax({
                    url: $('#form-new-link').attr('action'),
                    type: 'post',
                    data: $('#form-new-link').serialize(),
                    success: function (data) {
                        $('#modal-new-link').modal('hide');
                        running = false;
                        if ($.trim(data) === 'exito') {
                            $.notify(
                                "EXITO",
                                {
                                    className: "success",
                                    position: "bottom left",
                                });
                            $('#form-new-link').trigger('reset');
                            update();
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


    function delete_item(id) {

        //mira la documentacion de jquery confirm https://craftpip.github.io/jquery-confirm/
        $.confirm({
            title: 'Eliminar Capitulo?',
            content: 'Se eliminaran tambien los enlaces relacionados',
            autoClose: 'cancel|6000',
            confirmButton: 'ELIMINAR',
            cancelButton: 'CANCELAR',
            confirm: function () {


                if (!running) {
                    running = true;
                    $.ajax({
                        url: '<?php echo base_url('admin/eliminar-capitulo') ?>',
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
