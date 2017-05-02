<?php include_once 'base.php' ?>
<?php startblock('title') ?>Editar Pelicula<?php endblock() ?>

<?php startblock('main-content') ?>
<div class="container">

    <h2 class="text-center" style="background-color: #E91E63; color: #fff; text-transform: uppercase;">Editar
        Pelicula <?php echo $movie->movie_id ?></h2>


    <form id="form-edit">

        <div class="row">


            <div class="col-md-9 col-sm-12">
                <label class="sr-only" for="inlineFormInputGroup">Nombre de la pelicula</label>

                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <div class="input-group-addon">Titulo</div>
                    <input value="<?php echo $movie->name ?>" required name="name" type="text" class="form-control"
                           id="title"
                           placeholder="Nombre de la pelicula">
                </div>
            </div>

            <div class="col-md-3 col-sm-12">
                <label class="sr-only" for="inlineFormInputGroup">Año</label>

                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <div class="input-group-addon">Año</div>
                    <input required name="year" value="<?php echo $movie->year ?>" type="number" class="form-control"
                           id="year"
                           placeholder="Año">
                </div>
            </div>

            <div class="clearfix"></div>


            <div class="col-md-9 col-sm-12">
                <hr>
                <label class="sr-only" for="inlineFormInputGroup">Trailer de la pelicula</label>

                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <div class="input-group-addon">Trailer</div>
                    <input required name="trailer" type="text" class="form-control" id="trailer"
                           value="<?php echo $movie->trailer ?>"
                           placeholder="video ID YouTube">
                </div>
            </div>
            <div class="col-md-3 col-sm-12 text-right">
                <hr>
                <button type="button" class="btn btn-link w-100" href="#modallogo" data-toggle="modal"><i
                        class="icon-file-image"></i> Portada
                </button>


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
                                    <img id="image" src="<?php echo $movie->cover ?>">
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


            </div>

            <div class="col-12">
                <hr>
            <textarea required style="height: 80px;" class="form-control" name="short_description"
                      id="short_description"
                      cols="30" rows="10"
                      placeholder="Descripción corta"><?php echo $movie->short_description ?></textarea>
            </div>

            <div class="col-12">
                <hr>
                <textarea name="description" id="editor" cols="30"
                          rows="10"><?php echo $movie->description ?></textarea>
            </div>


            <div class="col-md-9 col-sm-12">
                <hr>
                <label class="sr-only" for="inlineFormInputGroup">Palabras clave</label>

                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <div class="input-group-addon">Palabras clave</div>
                    <input required type="text" class="form-control" id="key_words"
                           value="<?php echo $movie->key_words ?>">
                </div>
            </div>
            <div class="col-md-3 col-sm-12 text-right">
                <hr>
                <button type="submit" class="btn btn-primary w-100"><i class="icon-ok"></i> Publicar</button>
            </div>


        </div>

    </form>

</div>
<hr>


<div id="modal-upload" class="modal">
    <div class="modal-body text-center" style="background-color: #fff;">
        <h3>Publicando pelicula</h3>
        <img src="/assets/img/loading2.gif" alt="" width="100">
    </div>
</div>


<?php endblock() ?>


<?php startblock('scripts') ?>

<script>
    var editor, img64;
    var running = false;
    $(function () {

        $(".js-multiple").select2({
            placeholder: "Seleccione los generos de la pelicula",
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


        var config = {
            extraPlugins: 'codesnippet',
            codeSnippet_theme: 'monokai_sublime',
            height: 356
        };

        editor = CKEDITOR.replace('editor', config);


        $('#form-edit').submit(function () {

            if (img64 == null) {
                alert("selecione una imagen de portada");
            }else if (!running) {
                $('#modal-upload').modal('show');
                running = true;

                var id = <?php echo $movie->movie_id ?>;
                var titulo = $('#title').val();
                var year = $('#year').val();
                var trailer = $('#trailer').val();
                var descripcion_corta = $('#short_description').val();
                var html = editor.getData();
                var fd = new FormData();
                fd.append('movie_id', id);
                fd.append('title', titulo);
                fd.append('year', year);
                fd.append('trailer', trailer);
                fd.append('short_description', descripcion_corta);
                fd.append('cover', img64);
                fd.append('html', html);
                fd.append('key_words', $('#key_words').val());


                $.ajax({
                    url: '<?php echo base_url('/admin/peliculas/edit') ?>',
                    type: 'post',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#modal-upload').modal('hide');
                        running = false;
                        if ($.trim(data) === 'exito') {
                            $.notify(
                                "ACTUALIZADO CON EXITO",
                                {
                                    className: "success",
                                    position: "bottom left",
                                });
                            //$('#form-new-movie').trigger('reset');
                            //editor.setData('');
                        } else {
                            alert(data);
                        }
                    }
                });
            }
            return false;
        });
    });
</script>

<?php endblock() ?>
