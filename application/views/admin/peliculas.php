<?php
require_once 'base.php';
$token = password_hash("token", PASSWORD_DEFAULT);
?>

<?php startblock('title') ?>Peliculas<?php endblock() ?>


<?php startblock('main-content') ?>
<h2 class="text-center" style="background-color: #E91E63; color: #fff; text-transform: uppercase;">Lista de
    peliculas</h2>
<hr>
<div class="container">
    <table id="data-table" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Año</th>
            <th>Categorias</th>
            <th>Editar/Eliminar</th>
        </tr>
        </thead>

        <tfoot>
        <tr>
            <th><input style="max-width: 60px;" type="text"></th>
            <th><input type="text"></th>
            <th><input style="max-width: 70px;" type="text" type="text"></th>
            <th><select name="" id="">
                    <option value="">TODAS</option>
                    <?php foreach (json_decode($categories) as $category) { ?>
                        <option
                            value="<?php echo $category->category_name ?>"><?php echo $category->category_name ?></option>
                    <?php } ?>
                </select></th>
            <th></th>


        </tr>
        </tfoot>
    </table>

    <hr>


</div>


<?php endblock() ?>

<?php startblock('scripts') ?>
<script>
    var table;
    var running = false;
    $(function () {
        table = $('#data-table').DataTable({


            "ajax": {
                "aLengthMenu": [25],
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,
                "url": "<?php echo base_url('admin/peliculas/list')?>",
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


    });


    function update() {
        table.ajax.reload();
    }


    function delete_item(id) {

        //mira la documentacion de jquery confirm https://craftpip.github.io/jquery-confirm/
        $.confirm({
            title: 'Eliminar Pelicula?',
            content: 'Se eliminaran tambien los enlaces relacionados',
            autoClose: 'cancel|6000',
            confirmButton: 'ELIMINAR',
            cancelButton: 'CANCELAR',
            confirm: function () {


                if (!running) {
                    running = true;
                    $.ajax({
                        url: '<?php echo base_url('admin/peliculas/delete') ?>',
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
