<?php require_once 'base.php' ?>

<?php startblock('title') ?>Pelicula <?php echo $movie->name ?> <?php endblock() ?>
<?php startblock('meta') ?>
<meta name="description" content="<?php echo $movie->name ?>">

<?php endblock() ?>


<?php startblock('main-content') ?>

<div class="container-fluid">
    <h2 class="text-center"
        style="background-color: #E91E63; color: #fff; padding: 5px; margin-bottom: 0; "><?php echo $movie->name ?>
        <br>(<?php echo $movie->year ?>)</h2>
    <div class="row p-2">
        <div class="col-md-4">


            <img width="100%" src="<?php echo $movie->cover ?>" alt=" <?php echo $movie->name ?>">
            <br>

            <div class="text-center" style="background-color: #293b65; padding: 10px; color: white;">

                <button onclick="send_score()"
                        style="border: none; padding: 4px; position: absolute; right: 20px;  width: 30px; background-color: #ff0f4d; color: white; cursor: pointer;">
                    <i class="icon-pencil-1"></i></button>

                <h4 style="color: white; text-transform: uppercase;">Puntuación</h4>
                <ul style="list-style-type: none; padding-left: 5px; padding-top: 3px; margin: 0;">
                    <?php

                    $n = $movie->score;
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
                # votos: <?php echo $movie->votos ?>
            </div>

        </div>

        <div class="col-md-8">
            <?php echo $movie->description; ?>


            <h2 class="text-center" style="background-color: #0099cc; color: #fff; margin-bottom: 0; margin-top: 10px;">
                TRAILER</h2>


            <div id="movie-trailer" data-type="youtube" data-video-id="<?php echo $movie->trailer ?>"></div>

        </div>

        <div class="col-12"><br>

            <h3>Enlaces: </h3>
            <table class="table table-striped table-inverse" style="background-color: #E91E63; -webkit-box-shadow: 5px 9px 12px -4px rgba(0,0,0,0.75);
-moz-box-shadow: 5px 9px 12px -4px rgba(0,0,0,0.75);
box-shadow: 5px 9px 12px -4px rgba(0,0,0,0.75); color: #fff;">
                <thead>
                <tr class="text-center">
                    <th class="text-center" style="color: white">Audio</th>
                    <th class="text-center" style="color: white">Calidad</th>
                    <th class="text-center" style="color: white">Servidor</th>
                    <th class="text-center" style="color: white">Ver online</th>
                    <th class="text-center" style="color: white">Descarga</th>
                    <th class="text-center" style="color: white">¿Enlace caido?</th>

                </tr>
                </thead>
                <?php foreach ($urls as $url) { ?>
                    <tr class="text-center" style="background-color: #f2f2f2;">
                        <th class="text-center" scope="row"><?php echo $url->language_name ?></th>
                        <th class="text-center" scope="row"><?php echo $url->quality ?></th>
                        <th class="text-center" scope="row"><?php echo $url->server ?></th>
                        <th class="text-center" scope="row">
                            <button class="btn btn-sm btn-primary play-video"
                                    onclick="play_video('<?php echo $url->file_id ?>','<?php echo $url->server ?>')">
                                <i class="icon-play-4"></i> VER
                                ONLINE
                            </button>
                        </th>
                        <th class="text-center" scope="row">
                            <?php if ($url->server == 'openload') { ?>
                                <a target="_blank" class="btn btn-sm btn-info active w-100"
                                   href="https://openload.co/f/<?php echo $url->file_id ?>"
                                ><i class="icon-download"></i>
                                    DESCARGAR
                                </a>
                            <?php } else if ($url->server == 'stream.moe') { ?>
                                <a target="_blank" class="btn btn-sm btn-info active w-100"
                                   href="https://stream.moe/<?php echo $url->file_id ?>"
                                ><i class="icon-download"></i>
                                    DESCARGAR
                                </a>
                            <?php } else if ($url->server == 'google drive') { ?>
                                <a target="_blank" class="btn-sm  btn btn-info active w-100"
                                   href="https://drive.google.com/file/d/<?php echo $url->file_id ?>/view"
                                ><i class="icon-download"></i>
                                    DESCARGAR
                                </a>
                            <?php } ?>
                        </th>

                        <th class="text-center" scope="row">
                            <a target="_blank" class="btn btn-secondary" href="<?php echo base_url('enlace-caido?msg='.urlencode('PELICULA: '.$movie->name.' - calidad  '.$url->quality).'&url_id='.$url->url_id) ?>">REPORTAR</a>
                        </th>


                    </tr>
                <?php } ?>
            </table>

            <h3>Enlaces de MEGA: </h3>
            <?php if (isset($_SESSION['user_type'])) {
                if ($_SESSION['user_type'] == 'free') { ?>
                    <div class="card card-outline-danger p-4">
                        <b>Solo nuestros usuarios premium pueden ver los enlaces</b>
                    </div>
                <?php } else {
                    foreach ($mega_urls as $mega) {?>
                        <div class="p-4 text-center" style="border: 4px double #ff0f4d;">
                            <h3 style="color: #35568c;"><b><?php echo $mega->name ?></b></h3>
                            <p>Idioma: <?php echo $mega->language_name ?></p>
                            <p><?php echo $mega->name ?>note</p>
                            <a target="_blank" class="btn btn-danger" href="<?php echo $mega->url ?>" style="max-width: 200px;"> DESCARGAR</a>
                            <a target="_blank" class="btn btn-secondary" href="<?php echo base_url('enlace-caido?msg='.urlencode('MEGA: '.$mega->name).'&url_id='.$mega->mega_id) ?>"> ENLACE CAIDO</a>
                        </div>
                    <?php }
                }
            } else { ?>
                <div class="card card-outline-danger p-4">
                    <b>Solo nuestros usuarios registrados pueden ver los enlaces</b>
                </div>
            <?php } ?>


        </div>
    </div>
</div>
<hr>

<!--
<video poster="https://thumb.oloadcdn.net/splash/HHJfQUNJlck/eOVT_jDN84E.jpg" controls>
    <source src="https://wabbit.moecdn.io/2267f2954b87b507?download_token=bf567aae61a7ced87f4b967ed45b7391f3b11c68018b2826db9e3a4e8307c971" type="video/mp4">
<track kind="captions" label="English captions" src="https://thumb.oloadcdn.net/splash/HHJfQUNJlck/eOVT_jDN84E.jpg"
       srclang="en" default>
</video>
-->


<div class="modal fade" id="modal-loading" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3>Generando enlace de descarga</h3>
                <img src="/assets/img/loading2.gif" width="50">
            </div>
        </div>
    </div>
</div>

<div id="video-modal" style="display: none;">
    <div id="modal-content-demo" class="modal-content">
        <h3 id="titulo-video" class="text-center"
            style="padding: 6px; height: 80px; line-height: 2.3; background-color: #f40f4b; color: white;"><?php echo $movie->name ?></h3>

        <div class="text-center" id="video-content" style="margin-top: -5px; background-color: #0c0c0c;">

        </div>
    </div>
</div>
<hr>
<div class="container-fluid p-4" id="disqus_thread"></div>

<!-- Modal -->
<div class="modal fade" id="modal-no-login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
<div class="modal fade" id="modal-calificar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-cal" method="post" action="<?php echo base_url('calificar-pelicula') ?>">
                <input name="user_id" type="text" value="<?php echo $_SESSION['user_id'] ?>" hidden>
                <input name="movie_id" type="text" value="<?php echo $movie->movie_id ?>" hidden>

                <div class="modal-body text-center">

                    <h3 class="text-center"
                        style="padding: 20px; background-color: #ff0f4d; color: white; text-transform: uppercase;">
                        Califica esta pelicula</h3>

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
<script>plyr.setup();</script>
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

<script>
    $(function () {


        $('#modal-content-demo').apFullscreenModal({
            openSelector: '.play-video'
        });

        /*
         setInterval(function () {
         video_visible();
         }, 3000);
         */


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
                        alert("Error: ya calificaste esta pelicula anteriormente")
                    }
                },
                error: function (result) {
                    $('#modal-calificar').modal('hide');
                    alert("Error: ya calificaste esta pelicula anteriormente")
                }
            });
            return false;
        });

        <?php }?>

    });


    function video_visible() {
        if (!$('#modal-content-demo').is(":visible")) {
            $('#video-content').html("");
        }
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
                alert(result);
            }
        });

    }

    function play_video(fileID, server) {

        var html = '';

        var altura_video = $(window).height() - $('#titulo-video').height() - 20;

        if (server === 'openload') {
            html = ' <iframe src="https://openload.co/embed/' + fileID + '" scrolling="no" frameborder="0" height="' + altura_video + '" style="overflow: hidden; width: 100%;" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>';
        } else if (server === 'stream.moe') {
            html = '<iframe src="https://stream.moe/embed2/' + fileID + '/" frameborder="0" scrolling="no" height="' + altura_video + '"style="overflow: hidden; width: 100%;" webkitAllowFullScreen="true" mozallowfullscreen="true" allowFullScreen="true"></iframe>';
        } else if (server === 'google drive') {
            html = '<iframe src="https://drive.google.com/file/d/' + fileID + '/preview" style="width: 70%;" height="' + altura_video + '"></iframe>';
        }

        $('#video-content').html(html);


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
