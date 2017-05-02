<?php
require_once 'base.php';
$token = password_hash("token", PASSWORD_DEFAULT);
?>

<?php startblock('title') ?>Admin generos<?php endblock() ?>


<?php startblock('main-content') ?>
<h2 class="text-center" style="background-color: #E91E63; color: #fff; padding: 5px;">
    Generos para peliculas y series</h2>
<hr>
<div class="container text-center">

    <button href="#modal-new" data-toggle="modal" class="btn btn-primary"><i class="icon-list-add"></i> Nuevo Genero o
        Categoria
    </button>
    <hr>

    <div id="generos"></div>
    <hr>


    <div class="modal fade" id="modal-new">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form id="form-new" action="<?php echo base_url('admin/nueva-categoria') ?>">


                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo Genero o Categoria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--Body-->
                        <div class="md-form text-left">
                            <label for="nombre_n"><i class="icon-link-4 prefix"></i> Nombre genero </label>
                            <input required type="text" name="name" class="form-control">
                            <br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">CREAR GENERO</button>
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

    var running = false;
    $(function () {

        update();

        $('#form-new').submit(function () {

            if (!running) {
                $.notify(
                    "Creando ...",
                    {
                        className: "info",
                        position: "bottom left",
                    });
                running = true;

                $.ajax({
                    url: $('#form-new').attr('action'),
                    type: 'post',
                    data: $('#form-new').serialize(),
                    success: function (data) {
                        $('#modal-new').modal('hide');
                        running = false;
                        if ($.trim(data) === 'exito') {
                            $.notify(
                                "EXITO",
                                {
                                    className: "success",
                                    position: "bottom left",
                                });
                            $('#form-new').trigger('reset');
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
        $.ajax({
            url: '<?php echo base_url('admin/get-generos') ?>',
            type: 'post',
            success: function (result) {
                $('#generos').html(result);
            }
        });
    }


    function delete_item(id) {

        //mira la documentacion de jquery confirm https://craftpip.github.io/jquery-confirm/
        $.confirm({
            title: 'Eliminar Genero?',
            content: 'Se eliminaran tambien los enlaces relacionados',
            autoClose: 'cancel|6000',
            confirmButton: 'ELIMINAR',
            cancelButton: 'CANCELAR',
            confirm: function () {


                if (!running) {
                    running = true;
                    $.ajax({
                        url: '<?php echo base_url('admin/eliminar-genero') ?>',
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
