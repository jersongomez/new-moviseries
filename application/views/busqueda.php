<?php include_once 'base.php' ?>

<?php startblock('title') ?>busqueda "<?php echo $_GET['query'] ?>"<?php endblock() ?>


<?php startblock('main-content') ?>

    <div class="container-fluid text-center">
        <hr>

        <?php if (sizeof($movies) > 0) { ?>
            <section class="regular" style="margin-top: 6px;">
<h2>Peliculas Encontradas</h2>
                <div class="row">
                    <?php foreach ($movies as $movie) { ?>
                        <div class="mitem col-xl-2  col-lg-2 col-md-4 col-sm-6 p-0" style="border: 4px solid #fff;">


                            <a class="shadow" href="<?php echo base_url('peliculas/' . $movie->movie_id) ?>">
                                <div class="play  hvr-sweep-to-right">

                                    <div class="text-center"
                                         style="margin-top: 10px; margin-bottom: auto;">

                                        <div
                                            style="padding-top: 17px; padding-left: 5px; padding-right: 10px; line-height: 90%;">
                                            <b style="color: white; font-size: 15px; "><?php echo $movie->name; ?></b>
                                        </div>


                                        <div class="row pl-3 pr-3" style="margin-top: 30px;">
                                            <div class="col-xs-5"
                                                 style="height: 1px; background-color: #fff; margin: auto 0px;"></div>
                                            <div class="col-xs-2" style="padding: 0; margin: 0;">
                                                <img src="/assets/img/ic_play_circle.png" alt=""
                                                     style="100%; margin-left: auto; margin-right: auto;">
                                            </div>
                                            <div class="col-xs-5"
                                                 style="height: 1px; background-color: #fff; margin: auto 0px;"></div>
                                        </div>

                                        <div class="text-justify p-2"
                                             style="position: relative; font-size: 14px; line-height: 100%;">
                                            <?php echo $movie->short_description; ?>
                                        </div>


                                    </div>


                                </div>
                                <img src="<?php echo $movie->cover ?>">


                            </a>


                        </div>
                    <?php } ?>

                </div>

            </section>
        <?php } else { ?>
            <div class="card p-4">
                <h3>No se encontrarón peliculas</h3>
            </div>
        <?php } ?>


        <?php if (sizeof($series) > 0) { ?>
            <hr>
            <section class="regular" style="margin-top: 6px;">
<h2>Series Encontradas</h2>
                <div class="row">
                    <?php foreach ($series as $serie) { ?>
                        <div class="mitem  col-lg-2 col-md-4 col-sm-6 p-0" style="border: 4px solid #fff;">


                            <a href="<?php echo base_url('series/' . $serie->serie_id) ?>">
                                <div class="play  hvr-sweep-to-right">

                                    <div class="play-content  hvr-float  text-center">


                                        <div
                                            style="padding-top: 17px; padding-left: 5px; padding-right: 10px; line-height: 90%;">
                                            <b style="color: white; font-size: 15px; "><?php echo $serie->serie_name; ?></b>
                                        </div>


                                        <div class="row pl-3 pr-3">
                                            <div class="col-xs-5"
                                                 style="height: 1px; background-color: #fff; margin: auto 0px;"></div>
                                            <div class="col-xs-2" style="padding: 0; margin: 0;">
                                                <img src="/assets/img/ic_play_circle.png" alt=""
                                                     style="100%; margin-left: auto; margin-right: auto;">
                                            </div>
                                            <div class="col-xs-5"
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
        <?php } else { ?>
            <div class="card p-4">
                <h3>No se encontrarón series</h3>
            </div>
        <?php } ?>
        <hr>
    </div>

<?php endblock() ?>