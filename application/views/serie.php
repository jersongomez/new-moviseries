<?php require_once 'base.php' ?>
<?php startblock('title') ?><?php echo $serie->serie_name ?> <?php endblock() ?>
<?php startblock('meta') ?>
<meta name="description" content="<?php echo $serie->key_words ?>">

<?php endblock() ?>


<?php startblock('main-content') ?>

<div class="container">

    <div class="row p-2">
        <div class="col-md-4">
            <h2 class="text-center"
                style="background-color: #E91E63; color: #fff; padding: 5px; margin-bottom: 0; "><?php echo $serie->serie_name ?><br><?php echo $serie->year ?></h2>

            <img width="100%" src="<?php echo $serie->cover ?>" alt=" <?php echo $serie->serie_name ?>">
            <br>
            <div class="text-center" style="background-color: #293b65; padding: 10px; color: white;">
                <button class="btn btn-sm btn-default" onclick="send_score()"
                        style="position: absolute; right: 20px; background-color: #ff0f4d; color: white; cursor: pointer;">
                    <i class="icon-pencil"></i></button>

                <h4 style="color: white; text-transform: uppercase;">Puntuación</h4>
                <ul style="list-style-type: none; padding-left: 5px; padding-top: 3px; margin: 0;">
                    <?php

                    $n = $serie->score;
                    $whole = floor($n);      // 1
                    $fraction = $n - $whole; // .25
                    for ($i = 0; $i < floor($n); $i++) { ?>
                        <li style="display: inline-block"><i style="font-size: 15px; color: #ff0f4d;"
                                                             class="icon-star-1"></i></li>
                    <?php }
                    if ($fraction > .5) {
                        ?>
                        <li style="display: inline-block"><i style="font-size: 16px; color: #ff0f4d;"
                                                             class="icon-star-half"></i></li>
                        <?php

                        for ($i = $i + 1; $i < 10; $i++) { ?>
                            <li style="display: inline-block"><i style="font-size: 15px; color: rgba(98, 107, 150, 0.58);"
                                                                 class="icon-star-empty"></i></li>
                        <?php }
                    } else {
                        for ($i; $i < 10; $i++) { ?>
                            <li style="display: inline-block"><i style="font-size: 15px; color: rgba(98, 107, 150, 0.58);"
                                                                 class="icon-star-empty"></i></li>
                        <?php }
                    } ?>
                </ul>
                # votos: <?php echo $serie->votos ?>
            </div>
        </div>

        <div class="col-md-8">
            <?php echo $serie->description; ?>


        </div>


    </div>


    <?php foreach ($temporadas_capitulos as $tmp) { ?>
        <div class="panel panel-primary">
            <div style="background-color: #0099cc; color: white;">
                <h3 class='text-center p-1'>
                    <a data-toggle='collapse' href='#collapsex<?php echo $tmp['temporada']->number ?>'
                       style="color: white; text-transform: uppercase; text-decoration: none; width: 100%;">
                        temporada <?php echo $tmp['temporada']->number ?>
                    </a>
                </h3>
            </div>

            <div id='collapsex<?php echo $tmp['temporada']->number ?>' class='panel-collapse collapse'
                 role='tabpanel'
                 aria-labelledby='headingx<?php echo $tmp['temporada']->number ?>'>

                <div class='panel-body' style='padding: 0;'>


                    <table class="table table-striped table-inverse" style="background-color: #E91E63; -webkit-box-shadow: 5px 9px 12px -4px rgba(0,0,0,0.75);
-moz-box-shadow: 5px 9px 12px -4px rgba(0,0,0,0.75);
box-shadow: 5px 9px 12px -4px rgba(0,0,0,0.75);">
                        <thead>
                        <tr class="text-center">
                            <th class="text-center">#</th>
                            <th class="text-center">Título</th>
                            <th class="text-center">Audio</th>
                            <th class="text-center">Calidad</th>
                            <th class="text-center">Servidor</th>
                            <th class="text-center">Ver online</th>
                            <th class="text-center">Descarga</th>

                        </tr>
                        </thead>
                        <?php foreach ($tmp['capitulos'] as $cap) { ?>
                            <tr class="text-center">
                                <th class="text-center" scope="row"><?php echo $cap->episode ?></th>
                                <th class="text-center" scope="row"><?php echo $cap->episode_name ?></th>
                                <th class="text-center" scope="row"><?php echo $cap->language_name ?></th>
                                <th class="text-center" scope="row"><?php echo $cap->quality ?></th>
                                <th class="text-center" scope="row"><?php echo $cap->server ?></th>
                                <th class="text-center" scope="row">
                                    <button class="btn btn-sm btn-primary play-video"
                                            onclick="play_video('<?php echo $cap->file_id ?>','<?php echo $cap->server ?>',<?php echo $tmp['temporada']->number ?>,'<?php echo $cap->episode_name ?>',<?php echo $cap->episode ?>)">
                                        <i class="icon-play-4"></i> VER
                                        ONLINE
                                    </button>
                                </th>
                                <th class="text-center" scope="row">
                                    <?php if ($cap->server == 'openload') { ?>
                                        <a target="_blank" class="btn btn-sm btn-info active w-100"
                                           href="https://openload.co/f/<?php echo $cap->file_id ?>"
                                        ><i class="icon-download"></i>
                                            DESCARGAR
                                        </a>
                                    <?php } else if ($cap->server == 'stream.moe') { ?>
                                        <button class="btn btn-sm btn-info active w-100"
                                                onclick="descargar('<?php echo $cap->file_id ?>')"><i
                                                class="icon-download"></i>
                                            DESCARGA
                                        </button>
                                    <?php } else if ($cap->server == 'google drive') { ?>
                                        <a target="_blank" class="btn-sm  btn btn-info active w-100"
                                           href="https://drive.google.com/file/d/<?php echo $cap->file_id ?>/view"
                                        ><i class="icon-download"></i>
                                            DESCARGAR
                                        </a>
                                    <?php } ?>
                                </th>


                            </tr>
                        <?php } ?>
                    </table>


                </div>
            </div>
        </div>
    <?php } ?>

</div>


<div class="modal fade" id="modal-loading" tabindex="-1" role="dialog" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3>Generando enlace de descarga</h3>
                <img src="/assets/img/loading2.gif" width="50">
            </div>
        </div>
    </div>
</div>

<div style="display: none;">
    <div id="modal-content-demo" class="modal-content">
        <h3 id="titulo-video" class="text-center"
            style="padding: 6px; height: 80px; line-height: 2.3; background-color: #f40f4b; color: white;"></h3>

        <div class="text-center" id="video-content" style="margin-top: -5px; background-color: #0c0c0c;">

        </div>
    </div>
</div>


<div class="container" id="disqus_thread"></div>

<!-- Modal -->
<div class="modal fade" id="modal-no-login" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body text-center">
                <img src="/assets/img/info.png" alt="" width="50"><br>
                <span id="sms" style="font-size: 20px;"></span>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="icon-check"></i> ENTENDIDO
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal-calificar" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-cal" method="post" action="<?php echo base_url('calificar-serie') ?>">
                <input name="user_id" type="text" value="<?php echo $_SESSION['user_id'] ?>" hidden>
                <input name="serie_id" type="text" value="<?php echo $serie->serie_id ?>" hidden>

                <div class="modal-body text-center">

                    <h3 class="text-center"
                        style="padding: 20px; background-color: #ff0f4d; color: white; text-transform: uppercase;">
                        Califica esta serie</h3>

                    <div class="row">
                        <div class="col-md-8 text-right p-1">
                            Elige un número entre 0-10
                        </div>
                        <div class="col-md-4">
                            <input name="score" class="form-control" type="number" min="0" max="10" value="1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" class="btn btn-primary"><i class="icon-star"></i>
                        Calificar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<hr>
<?php endblock() ?>

<?php startblock('scripts') ?>
<script id="dsq-count-scr" src="//moviseriesxyz.disqus.com/count.js" async></script>
<script>
    var PAGE_URL = window.location.href;
    var title = $(document).find("title").text();

    var disqus_config = function () {
        this.page.url = PAGE_URL;
        this.page.identifier = title;
    };

    (function () { // DON'T EDIT BELOW THIS LINE
        var d = document, s = d.createElement('script');
        s.src = 'https://moviseriesxyz.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by
        Disqus.</a></noscript>


<script>plyr.setup();</script>
<script>

    $(function () {

        $('#modal-content-demo').apFullscreenModal({
            openSelector: '.play-video'
        });


        <?php if(isset($_SESSION['username'])){ ?>

        $('#form-cal').submit(function () {
            var url = $('#form-cal').attr('action');
            var data = $('#form-cal').serialize();

            $.ajax({
                type: 'post',
                url: url,
                data: data,
                success: function (result) {
                    $('#modal-calificar').modal('hide');
                    if(result==1){
                        alert("tu calificación ha sido guardada")
                    }else{
                        alert("Error: ya calificaste esta serie anteriormente")
                    }
                },
                error: function (result) {
                    $('#modal-calificar').modal('hide');
                    alert("Error: ya calificaste esta serie anteriormente")
                }
            });
            return false;
        });

        <?php }?>

    });

    function play_video(fileID, server, temp, capName, capNumer) {

        var html = '';

        var altura_video = $(window).height() - $('#titulo-video').height() - 20;

        if (server === 'openload') {
            html = ' <iframe src="https://openload.co/embed/' + fileID + '" scrolling="no" frameborder="0" height="' + altura_video + '" style="overflow: hidden; width: 100%;" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>';
        } else if (server === 'stream.moe') {
            html = '<iframe src="https://stream.moe/embed2/' + fileID + '/" frameborder="0" scrolling="no" height="' + altura_video + '"style="overflow: hidden; width: 100%;" webkitAllowFullScreen="true" mozallowfullscreen="true" allowFullScreen="true"></iframe>';
        } else if (server === 'google drive') {
            html = '<iframe src="https://drive.google.com/file/d/' + fileID + '/preview" style="width: 70%;" height="' + altura_video + '"></iframe>';
        }

        $('#titulo-video').html('<?php echo $serie->serie_name ?>: Temporada ' + temp + ' - episodio #' + capNumer + ' ' + capName);
        $('#video-content').html(html);


    }

    function descargar(fileID) {
        $('#modal-loading').modal('show');
        $.ajax({
            type: 'post',
            url: '<?php echo base_url('download-file') ?>',
            data: 'file_id=' + fileID,
            success: function (result) {
                $('#modal-loading').modal('hide');
                window.location = result;
            },
            error: function (result) {
                alert("No se pudo descargar el video");
            }
        });

    }

    function send_score() {
        <?php if(!isset($_SESSION['username'])){ ?>
        $('#modal-no-login').modal('show');
        $('#sms').html("Inicia sesión para calificar esta pelicula");
        <?php }else{ ?>
        $('#modal-calificar').modal('show');
        <?php }?>
    }

</script>


<?php endblock() ?>
