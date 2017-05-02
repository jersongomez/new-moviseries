<?php
require_once 'base.php';
$token = password_hash("token", PASSWORD_DEFAULT);
?>

<?php startblock('title') ?>Temporadas serie<?php endblock() ?>


<?php startblock('main-content') ?>
<h2 class="text-center" style="background-color: #E91E63; color: #fff; padding: 5px; ">
    temporadas <?php echo $serie->serie_name ?> </h2>
<hr>
<div class="container">

    <div class="text-lg-left">
        <a class="btn btn-info active" href="<?php echo base_url('admin/series') ?>"><i class="icon-left"></i> Volver
            a series</a>

        <button href="#modal-new-link" data-toggle="modal" class="btn btn-primary"><i class="icon-list-add"></i>
            Nueva Temporada
        </button>
    </div>
    <hr>

    <table id="data-table" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>Temporada</th>
            <th>trailer</th>
            <th>Actualizada</th>
            <th>Editar/Eliminar</th>
        </tr>
        </thead>
    </table>

    <hr>

    <div class="modal fade" id="modal-new-link">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <form id="form-new" action="<?php echo base_url('admin/serie/insert-temporada') ?>"
                      enctype="multipart/form-data">

                    <input name="serie_id" type="text" value="<?php echo $serie->serie_id ?>" hidden>

                    <div class="modal-header">
                        <h5 class="modal-title">Nueva temporada</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--Body-->
                        <div class="md-form text-left">


                            <div class="row">
                                <div class="col-4">
                                    <label># de temporada: </label>
                                    <input id="input-number" required type="number" name="number" class="form-control"
                                           value="1">
                                </div>
                                <div class="col-4">
                                    <label>Trailer ID: </label>
                                    <input id="input-trailer" type="text" class="form-control"
                                           placeholder="Youtube videoID">
                                </div>
                                <div class="col-4">
                                    <label>Imagen de portada</label>
                                    <button type="button" class="btn btn-link w-100" href="#modallogo"
                                            data-toggle="modal"><i
                                            class="icon-file-image"></i> Portada
                                    </button>

                                </div>

                            </div>

                            <br>

                            <div class="row">
                                <div class="col-12">
                                    <label>palabras clave: </label>
                                    <input id="key_words" required type="text" class="form-control"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">CREAR TEMPORADA</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>


            </div>
        </div>
    </div>


</div>


<div class="modal fade" id="modallogo" tabindex="-1" role="dialog" aria-labelledby="label1">
    <div class="modal-dialog" role="document" style="margin-top: 0%;">
        <div class="modal-content">
            <div class="modal-header"
                 style="text-align: center; font-weight: bold; background-color: #0099cc;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalLabel" style="color: #fff;">Subir imagen Principal</h4>
            </div>
            <div class="modal-body">
                <div style="max-height: 400px;">
                    <img id="image" src="/assets/img/logo.png">
                </div>

                <div class="clearfix"></div>
                <small>Cuando terminte de recortar la imagen clic en guardar</small>
            </div>
            <div class="modal-footer docs-buttons" style="padding-top: 0; margin-top: 0;">


                <label style="margin-top: 10px;" class="btn btn-primary btn-upload" for="inputImage"
                       title="Upload image file">
                    <input type="file" class="sr-only" id="inputImage">
            <span class="docs-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
              <span class="icon-upload"></span>
            </span>
                </label>

                <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1"
                            title="Zoom In">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, 0.1)">
              <span class="icon-zoom-in"></span>
            </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1"
                            title="Zoom Out">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, -0.1)">
              <span class="icon-zoom-out"></span>
            </span>
                    </button>
                </div>
                <button id="getDataURL" type="button" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div id="modal-upload" class="modal">
    <div class="modal-body text-center" style="background-color: #fff;">
        <h3>Publicando Temporada</h3>
        <img src="/assets/img/loading2.gif" alt="" width="100">
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
                "url": "<?php echo base_url('admin/serie-temporadas')?>",
                "data": {
                    "_token": "<?php echo $token ?>",
                    "id": "<?php echo $serie->serie_id ?>"
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


        var $image = $('#image');
        var cropBoxData;
        var canvasData;

        $('#modallogo').on('shown.bs.modal', function () {
            $image.cropper({
                aspectRatio: 4 / 6,
                autoCropArea: 0.8,
                built: function () {
                    $image.cropper('setCanvasData', canvasData);
                    $image.cropper('setCropBoxData', cropBoxData);
                }
            });
        }).on('hidden.bs.modal', function () {
            cropBoxData = $image.cropper('getCropBoxData');
            canvasData = $image.cropper('getCanvasData');
            //$image.cropper('destroy');
        });

        var dataURLView = $("#dataURLView");
        $("#getDataURL").click(function () {

            // $canvas.toBlob($image.cropper('getCroppedCanvas'),"image/jpeg", 0.95);
            // alert($image.cropper('getCroppedCanvas').toDataURL());

            //img64 = $image.cropper('getCroppedCanvas').toDataURL();
            img64 = $image.cropper('getCroppedCanvas', {width: 351, height: 696}).toDataURL();
            $('#modallogo').modal('hide');


            $.notify(
                "Imagen Selecionada",
                {
                    className: "info",
                    position: "bottom left",
                });

        });


        // Import image
        var $inputImage = $('#inputImage');
        var URL = window.URL || window.webkitURL;
        var blobURL;

        if (URL) {
            $inputImage.change(function () {
                var files = this.files;
                var file;

                if (!$image.data('cropper')) {
                    return;
                }

                if (files && files.length) {
                    file = files[0];

                    if (/^image\/\w+$/.test(file.type)) {
                        blobURL = URL.createObjectURL(file);
                        $image.one('built.cropper', function () {

                            // Revoke when load complete
                            URL.revokeObjectURL(blobURL);
                        }).cropper('reset').cropper('replace', blobURL);
                        $inputImage.val('');
                    } else {
                        window.alert('Please choose an image file.');
                    }
                }
            });
        } else {
            $inputImage.prop('disabled', true).parent().addClass('disabled');
        }

        $('.docs-buttons').on('click', '[data-method]', function () {
            var $this = $(this);
            var data = $this.data();
            var $target;
            var result;

            if ($this.prop('disabled') || $this.hasClass('disabled')) {
                return;
            }

            if ($image.data('cropper') && data.method) {
                data = $.extend({}, data); // Clone a new one

                if (typeof data.target !== 'undefined') {
                    $target = $(data.target);

                    if (typeof data.option === 'undefined') {
                        try {
                            data.option = JSON.parse($target.val());
                        } catch (e) {
                            console.log(e.message);
                        }
                    }
                }

                if (data.method === 'rotate') {
                    $image.cropper('clear');
                }

                result = $image.cropper(data.method, data.option, data.secondOption);

                if (data.method === 'rotate') {
                    $image.cropper('crop');
                }

                switch (data.method) {
                    case 'scaleX':
                    case 'scaleY':
                        $(this).data('option', -data.option);
                        break;

                }


            }
        });


        $('#form-new').submit(function () {


            if (img64 != null) {
                if (!running) {
                    $('#modal-upload').modal('show');
                    running = true;


                    var number = $('#input-number').val();
                    var trailer = $('#input-trailer').val();
                    var fd = new FormData();

                    fd.append('number', number);
                    fd.append('serie_id', <?php echo $serie->serie_id ?>);
                    fd.append('trailer', trailer);
                    fd.append('cover', img64);
                    fd.append('key_words', $('#key_words').val());


                    $.ajax({
                        url: $('#form-new').attr('action'),
                        type: 'post',
                        data: fd,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#modal-upload').modal('hide');
                            $('#modal-new-link').modal('hide');
                            running = false;
                            if ($.trim(data) === 'exito') {
                                update();
                            } else {
                                alert(data);
                            }
                        }
                    });

                }
            } else {
                alert("Seleccione una imagen de portada");
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
            title: 'Eliminar Temporada?',
            content: 'Se eliminaran tambien los enlaces relacionados',
            autoClose: 'cancel|6000',
            confirmButton: 'ELIMINAR',
            cancelButton: 'CANCELAR',
            confirm: function () {


                if (!running) {
                    running = true;
                    $.ajax({
                        url: '<?php echo base_url('admin/eliminar-temporada') ?>',
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
