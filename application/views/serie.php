<?php require_once 'base.php' ?>
<?php startblock('title') ?><?php echo $serie->serie_name ?> <?php endblock() ?>
<?php startblock('meta') ?>
<meta name="description" content="<?php echo $serie->key_words ?>">

<?php endblock() ?>


<?php startblock('main-content') ?>

<div class="container-fluid">

    <div class="row">
        <div class="col-lg-2 regular hidden-sm-down">
            <h6 class="text-center"
                style="margin-top: 5px; background-color: #1d1d80; color: #fff; padding: 5px; margin-bottom: 0; ">
                ULTIMAS SERIES</h6>
            <?php foreach ($last_series as $mserie) { ?>
                <div class="mitem" style="margin-top: 4px;">
                    <a href="<?php echo base_url('series/' . $mserie->serie_id) ?>">
                        <div class="play  hvr-sweep-to-right">

                            <div class="play-content  hvr-float  text-center">


                                <div
                                    style="padding-top: 17px; padding-left: 5px; padding-right: 10px; line-height: 90%;">
                                    <b style="color: white; font-size: 15px; "><?php echo $mserie->serie_name; ?></b>
                                </div>


                                <div class="row pl-3 pr-3">
                                    <div class="col-5"
                                         style="height: 1px; background-color: #fff; margin: auto 0px;"></div>
                                    <div class="col-2" style="padding: 0; margin: 0;">
                                        <img src="/assets/img/ic_play_circle.png" alt=""
                                             style="100%; margin-left: auto; margin-right: auto;">
                                    </div>
                                    <div class="col-5"
                                         style="height: 1px; background-color: #fff; margin: auto 0px;"></div>
                                </div>


                                <div class="text-justify p-2"
                                     style="position: relative; font-size: 14px; line-height: 100%;">
                                    <?php echo $mserie->short_description; ?>
                                </div>


                            </div>


                        </div>
                        <img class="shadow" style="border: 1px solid #eb0f4b;" width="100%"
                             src="<?php echo $mserie->cover ?>">
                    </a>
                </div>

            <?php } ?>
        </div>

        <div class="col-lg-10 col-sm-12">
            <h2 class="text-center"
                style="background-color: #E91E63; color: #fff; padding: 5px; margin-bottom: 0; "><?php echo $serie->serie_name ?>
                - (<?php echo $serie->year ?>)</h2>

            <div class="row">
                <div class="col-md-4">


                    <img width="100%" src="<?php echo $serie->cover ?>" alt=" <?php echo $serie->serie_name ?>">
                    <br>

                    <div class="text-center" style="background-color: #293b65; padding: 10px; color: white;">
                        <button onclick="send_score()"
                                style="border: none; padding: 4px; position: absolute; right: 20px;  width: 30px; background-color: #ff0f4d; color: white; cursor: pointer;">
                            <i class="icon-pencil-1"></i></button>

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
                                    <li style="display: inline-block"><i
                                            style="font-size: 15px; color: rgba(98, 107, 150, 0.58);"
                                            class="icon-star-empty"></i></li>
                                <?php }
                            } else {
                                for ($i; $i < 10; $i++) { ?>
                                    <li style="display: inline-block"><i
                                            style="font-size: 15px; color: rgba(98, 107, 150, 0.58);"
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
            <hr>
            <div class="row text-center">
                <?php foreach ($temporadas as $tmp) { ?>


                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 center-block mb-2">
                        <h5 style="background-color: #f52265; color: white; text-align: center; margin: 0;">
                            TEMPORADA <?php echo $tmp->number ?></h5>
                        <img src="<?php echo $tmp->cover ?>" width="100%">
                        <button type="button" class="btn btn-sm btn-primary w-100 play-temporada"
                                onclick="play_temporada(<?php echo $tmp->season_id ?>,<?php echo $tmp->number ?>)"><i
                                class="icon-list"></i> EPISODIOS
                        </button>
                        <button type="button" class="btn btn-sm btn-danger w-100 play-trailer"
                                onclick="play_trailer('<?php echo $tmp->trailer ?>',<?php echo $tmp->number ?>)"><i class="icon-youtube-play"></i>
                            TRAILER
                        </button>
                    </div>


                <?php } ?>
            </div>
            <br>

            <h3>Enlaces de MEGA: </h3>
            <?php if (isset($_SESSION['username'])) {
                if ($_SESSION['user_type'] == 'free') { ?>
                    <div class="card card-outline-danger p-4">
                        <b>Solo nuestros usuarios premium pueden ver los enlaces</b>
                    </div>
                <?php } else {
                    foreach ($mega_urls as $mega) { ?>
                        <div class="p-4 text-center" style="border: 4px double #ff0f4d;">
                            <h3 style="color: #35568c;"><b><?php echo $mega->name ?></b></h3>

                            <p>Idioma: <?php echo $mega->language_name ?></p>

                            <p><?php echo $mega->note ?></p>
                            <a target="_blank" class="btn btn-danger" href="<?php echo $mega->url ?>"
                               style="max-width: 200px;">
                                DESCARGAR</a>
                            <a target="_blank" class="btn btn-secondary"
                               href="<?php echo base_url('enlace-caido?msg=' . urlencode('MEGA: ' . $mega->name) . '&url_id=' . $mega->mega_id) ?>">
                                ENLACE CAIDO</a>
                        </div>
                    <?php }
                }
            } else { ?>
                <div class="card card-outline-danger p-4">
                    <b>Solo nuestros usuarios registrados pueden ver los enlaces</b>
                </div>
            <?php } ?>

            <hr>
            <div class="container p-2" id="disqus_thread"></div>

        </div>


    </div>


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
        <h3 id="titulo-video" class="text-center  modal-titlem"></h3>

        <div class="text-center" id="video-content" style="margin-top: -5px; background-color: #0c0c0c;">

        </div>
    </div>
</div>

<div style="display: none;">
    <div id="modal-temporada" class="modal-content">
        <h3 id="titulo-temporada" class="text-center  modal-titlem"></h3>

        <div class="text-center" id="temporada-content">

        </div>
    </div>
</div>



<div style="display: none;" style="background-color: #15154d;">
    <div id="modal-trailer" class="modal-content" style="background-color: #15154E;">
        <h3 id="titulo-trailer" class="text-center modal-titlem"></h3>

        <div class="text-center container" id="trailer-content" style="margin-top: -5px;">

        </div>
    </div>
</div>


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


<?php
if (isset($_SESSION['username'])) {
    ?>
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
<?php } ?>

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




        $('#modal-temporada').apFullscreenModal({
            openSelector: '.play-temporada'
        });


        $('#modal-trailer').apFullscreenModal({
            openSelector: '.play-trailer'
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
                    if (result == 1) {
                        alert("tu calificación ha sido guardada")
                    } else {
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

        var altura_video = $(window).height() - $('#titulo-video').height() - 24;

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




    function play_trailer(ID,number) {

        var html = '';

        var altura_video = $(window).height() - $('#titulo-video').height() - 20;

        html='<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="//www.youtube.com/embed/'+ID+'" allowfullscreen></iframe></div>';


        $('#titulo-trailer').html('<?php echo $serie->serie_name ?>: Trailer Temporada ' + number);
        $('#trailer-content').html(html);


    }



    function play_temporada(ID, number) {
        $('#titulo-temporada').html('<?php echo $serie->serie_name ?>: Temporada ' + number);

        $.ajax({
            type: 'post',
            url: '<?php echo base_url('get-temporada') ?>',
            data: 'id=' + ID + '&number=' + number + '&serie_name=<?php echo rawurlencode($serie->serie_name) ?>',
            success: function (result) {
                console.log(result);
                $('#temporada-content').html(result);


                $('#modal-content-demo').apFullscreenModal({
                    openSelector: '.play-video'
                });
            },
            error: function (result) {
                alert(result);
            }
        });


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
