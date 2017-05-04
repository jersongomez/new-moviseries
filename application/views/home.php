<?php include_once 'base.php' ?>
<?php startblock('title') ?>MoviSeries<?php endblock() ?>

<?php startblock('main-content') ?>

<div class="container-fluid p-0" style="background-color: white; margin-top: 10px;">

    <section id="last-movies" class="regular slider">

        <?php foreach ($last_movies as $movie) { ?>
            <div class="mitem  shadow">


                <a href="<?php echo base_url('peliculas/' . $movie['movie']->movie_id) ?>">
                    <div class="play  hvr-sweep-to-right">

                        <div class="play-content  hvr-float  text-center">


                            <div
                                style="padding-top: 17px; padding-left: 5px; padding-right: 10px; line-height: 95%;">
                                <b style="color: white; font-size: 15px; "><?php echo $movie['movie']->name; ?></b>
                            </div>


                            <div class="row pl-3 pr-3">
                                <div class="col-5" style="height: 1px; background-color: #fff; margin: auto 0px;"></div>
                                <div class="col-2" style="padding: 0; margin: 0;">
                                    <img src="/assets/img/ic_play_circle.png" alt=""
                                         style="100%; margin-left: auto; margin-right: auto;">
                                </div>
                                <div class="col-5" style="height: 1px; background-color: #fff; margin: auto 0px;"></div>
                            </div>


                            <div class="text-justify p-2"
                                 style="position: relative; font-size: 14px; line-height: 100%;">
                                <?php echo $movie['movie']->short_description; ?>
                            </div>


                        </div>


                    </div>
                    <img src="<?php echo $movie['movie']->cover ?>">

                    <div class="w-100 mt-1"
                         style="background-color: #0E2231; min-height: 50px;">
                        <ul style="list-style-type: none; padding-left: 5px; padding-top: 4px; margin: 0;">
                            <?php foreach ($movie['qualities'] as $quality) { ?>
                                <li style="width: 30%;display: inline-block"><img
                                        src="/assets/img/<?php echo $quality->quality ?>.png"
                                        style="width: 100%;"></li>

                            <?php } ?>
                        </ul>

                        <div class="clearfix"></div>
                    </div>
                </a>


            </div>
        <?php } ?>


    </section>


    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" style="background-color: #ff0f4d;">
        <li class="nav-item">
            <a style="color: white; font-size: 10px;" class="nav-link active" data-toggle="tab" href="#tab-home" role="tab">Top
                Peliculas</a>
        </li>

        <li class="nav-item">
            <a style="color: white; font-size: 10px;" class="nav-link" data-toggle="tab" href="#tab-series" role="tab">Top
                Series</a>
        </li>

        <li class="nav-item">
            <a style="color:white;  font-size: 10px; " class="nav-link" data-toggle="tab" href="#last-series" role="tab">Ultimas
                Series</a>
        </li>
        <li class="nav-item">
            <a style="color: white; font-size: 10px;" class="nav-link" data-toggle="tab" href="#series-updated" role="tab">Series
                Actualizadas</a>
        </li>

    </ul>

    <!-- Tab panes -->
    <div class="tab-content container-fluid">
        <div class="tab-pane active" id="tab-home" role="tabpanel">
            <section class="regular" style="margin-top: 6px;">

                <div class="row">
                    <?php foreach ($best_movies as $movie) { ?>
                        <div class="mitem col-xl-2  col-lg-2 col-md-4 col-sm-6 col-6 p-0" style="border: 4px solid #fff;">


                            <a class="shadow" href="<?php echo base_url('peliculas/' . $movie->movie_id) ?>">
                                <div class="play  hvr-sweep-to-right">

                                    <div class="text-center"
                                         style="margin-top: 20px; margin-bottom: auto;">

                                        <div
                                            style="padding-top: 17px; padding-left: 5px; padding-right: 10px; line-height: 90%;">
                                            <b style="color: white; font-size: 15px; "><?php echo $movie->name; ?></b>
                                        </div>


                                        <div class="row pl-3 pr-3" style="margin-top: 30px;">
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
                                            <?php echo $movie->short_description; ?>
                                        </div>


                                    </div>


                                </div>
                                <img src="<?php echo $movie->cover ?>">

                                <div class="w-100 mt-1 text-center"
                                     style="background-color: #0E2231; min-height: 30px;">
                                    <ul style="list-style-type: none; padding-left: 5px; padding-top: 3px; margin: 0; padding-left: 0px; padding-right: 0;">
                                        <?php

                                        $n = $movie->score;
                                        $whole = floor($n);      // 1
                                        $fraction = $n - $whole; // .25
                                        for ($i = 0; $i < floor($n); $i++) { ?>
                                            <li style="display: inline"><i style="font-size: 12px; color: #ff0f4d;"
                                                                       class="icon-star-1"></i></li>
                                        <?php }
                                        if ($fraction > .5) {
                                            ?>
                                            <li  style="display: inline"><i style="font-size: 13px; color: #ff0f4d;"
                                                                       class="icon-star-half"></i></li>
                                            <?php

                                            for ($i = $i + 1; $i < 10; $i++) { ?>
                                                <li  style="display: inline"><i style="font-size: 12px; color: rgba(98, 107, 150, 0.58);"
                                                                           class="icon-star-empty"></i></li>
                                            <?php }
                                        } else {
                                            for ($i; $i < 10; $i++) { ?>
                                                <li  style="display: inline"><i style="font-size: 12px; color: rgba(98, 107, 150, 0.58);"
                                                                           class="icon-star-empty"></i></li>
                                            <?php }
                                        } ?>
                                    </ul>

                                    <div class="clearfix"></div>
                                </div>

                            </a>


                        </div>
                    <?php } ?>

                </div>

            </section>
        </div>
        <div class="tab-pane" id="tab-series" role="tabpanel">
            <section class="regular" style="margin-top: 6px;">

                <div class="row">
                    <?php foreach ($best_series as $serie) { ?>
                        <div class="mitem col-xl-2  col-lg-2 col-md-4 col-sm-6 col-6 p-0" style="border: 4px solid #fff;">


                            <a class="shadow" href="<?php echo base_url('series/' . $serie->serie_id) ?>">
                                <div class="play  hvr-sweep-to-right">

                                    <div class="text-center"
                                         style="margin-top: 20px; margin-bottom: auto;">

                                        <div
                                            style="padding-top: 17px; padding-left: 5px; padding-right: 10px; line-height: 90%;">
                                            <b style="color: white; font-size: 15px; "><?php echo $serie->serie_name; ?></b>
                                        </div>


                                        <div class="row pl-3 pr-3" style="margin-top: 30px;">
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
                                            <?php echo $serie->short_description; ?>
                                        </div>


                                    </div>


                                </div>
                                <img src="<?php echo $serie->cover ?>">

                                <div class="w-100 mt-1 text-center"
                                     style="background-color: #0E2231; min-height: 30px;">
                                    <ul style="list-style-type: none; padding-left: 5px; padding-top: 3px; margin: 0; padding-left: 0px; padding-right: 0;">
                                        <?php

                                        $n = $serie->score;
                                        $whole = floor($n);      // 1
                                        $fraction = $n - $whole; // .25
                                        for ($i = 0; $i < floor($n); $i++) { ?>
                                            <li style="display: inline"><i style="font-size: 12px; color: #ff0f4d;"
                                                                           class="icon-star-1"></i></li>
                                        <?php }
                                        if ($fraction > .5) {
                                            ?>
                                            <li  style="display: inline"><i style="font-size: 13px; color: #ff0f4d;"
                                                                            class="icon-star-half"></i></li>
                                            <?php

                                            for ($i = $i + 1; $i < 10; $i++) { ?>
                                                <li  style="display: inline"><i style="font-size: 12px; color: rgba(98, 107, 150, 0.58);"
                                                                                class="icon-star-empty"></i></li>
                                            <?php }
                                        } else {
                                            for ($i; $i < 10; $i++) { ?>
                                                <li  style="display: inline"><i style="font-size: 12px; color: rgba(98, 107, 150, 0.58);"
                                                                                class="icon-star-empty"></i></li>
                                            <?php }
                                        } ?>
                                    </ul>

                                    <div class="clearfix"></div>
                                </div>

                            </a>


                        </div>
                    <?php } ?>

                </div>

            </section>
        </div>
        <div class="tab-pane" id="last-series" role="tabpanel">

            <section class="regular" style="margin-top: 6px;">

                <div class="row">
                    <?php foreach ($last_series as $serie) { ?>
                        <div class="mitem  col-lg-2 col-md-4 col-sm-6 col-6 p-0" style="border: 4px solid #fff;">


                            <a href="<?php echo base_url('series/' . $serie->serie_id) ?>">
                                <div class="play  hvr-sweep-to-right">

                                    <div class="play-content  hvr-float  text-center">


                                        <div
                                            style="padding-top: 17px; padding-left: 5px; padding-right: 10px; line-height: 90%;">
                                            <b style="color: white; font-size: 15px; "><?php echo $serie->serie_name; ?></b>
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
                                            <?php echo $serie->short_description; ?>
                                        </div>


                                    </div>


                                </div>
                                <img class="shadow" style="border: 1px solid #eb0f4b;"
                                     src="<?php echo $serie->cover ?>">
                            </a>


                        </div>
                    <?php } ?>
                </div>

            </section>
        </div>
        <div class="tab-pane" id="series-updated" role="tabpanel">
            <section class="regular" style="margin-top: 6px;">

                <div class="row">
                    <?php foreach ($last_seasons as $season) { ?>
                        <div class="mitem  col-lg-2 col-md-4 col-sm-6 col-6 p-0" style="border: 4px solid #fff;">


                            <a href="<?php echo base_url('series/' . $season->serie_id) ?>">
                                <div class="play  hvr-sweep-to-right">

                                    <div class="text-center"
                                         style="margin-top: 30px; margin-bottom: auto;">

                                        <div
                                            style="padding-top: 17px; padding-left: 5px; padding-right: 10px; line-height: 90%;">
                                            <b style="color: white; font-size: 15px; "><?php echo $season->serie_name; ?></b>
                                        </div>


                                        <div class="row pl-3 pr-3" style="margin-top: 30px;">
                                            <div class="col-5"
                                                 style="height: 1px; background-color: #fff; margin: auto 0px;"></div>
                                            <div class="col-2" style="padding: 0; margin: 0;">
                                                <img src="/assets/img/ic_play_circle.png" alt=""
                                                     style="100%; margin-left: auto; margin-right: auto;">
                                            </div>
                                            <div class="col-5"
                                                 style="height: 1px; background-color: #fff; margin: auto 0px;"></div>
                                        </div>


                                        <div
                                            style="padding-top: 17px; padding-left: 5px; padding-right: 10px; line-height: 90%;">
                                            <b style="color: white; font-size: 15px; ">Temporada <?php echo $season->number; ?></b>
                                        </div>


                                    </div>


                                </div>
                                <img class="shadow" style="border: 1px solid #eb0f4b;"
                                     src="<?php echo $season->cover ?>">
                            </a>


                        </div>
                    <?php } ?>

                </div>

            </section>
        </div>
    </div>


</div>


<br>


<?php endblock() ?>



<?php startblock('scripts') ?>
<script>
    $(document).on('ready', function () {


        $('#last-movies').slick({
            dots: false,
            infinite: true,
            autoplay: true,
            speed: 300,
            slidesToShow: 8,
            slidesToScroll: 8,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }
            ]
        });
        $('#nav-inicio').addClass('active');

    });
</script>
<?php endblock() ?>
