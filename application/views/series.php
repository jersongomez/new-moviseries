<?php include_once 'base.php' ?>

<?php startblock('title') ?>
Moviseries Series
<?php endblock() ?>

<?php startblock('meta') ?>
<meta name="description" content="peliculas y series en hd latino en tu pc y android sin publicidad">
<?php endblock() ?>


<?php startblock('main-content') ?>

<div class="container-fluid" style="overflow-x: hidden;">
    <div class="row " style="padding-top: 20px; padding-bottom: 10px;">
        <div class="col-lg-2 col-md-3" style="padding-left: 3px; margin-bottom: 10px; padding-right: 2px;">
            <ul class="list-group card" id="categorias">
                <li class="list-group-item"
                    style="background-color: #f40f4b; color: #fff; font-weight: bold;"><a href="<?php echo base_url('series') ?>" style="color: white;">CATEGORIAS</a>
                </li>
                <?php foreach ($categorias as $cat) { ?>
                    <li id="category-<?php echo str_replace("+", "-", urlencode($cat->category_name)) ?>"
                        class="list-group-item"><a style="display:inline-block;
width: 100%;"
                                                                     href="<?php echo base_url('series/categoria/' . urlencode($cat->category_name)) ?>"> <?php echo $cat->category_name ?>
                        </a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="col-lg-10 col-md-9  pl-3 pt-1 pr-3">
            <div class="row regular">
                <?php foreach ($series as $serie) { ?>
                    <div class="mitem  col-lg-2 col-md-4 col-sm-6 col-xs-6  p-0" style="border: 3px solid #fff;">

                        <a href="<?php echo base_url('series/' . $serie->serie_id) ?>">
                            <div class="play hvr-sweep-to-right">

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


                                    <div class="text-justify pl-2 pr-2 pt-2 "
                                         style="position: relative; font-size: 14px; line-height: 100%; overflow-y: hidden;  max-height: 150px;">
                                        <?php echo $serie->short_description; ?>
                                    </div>


                                </div>


                            </div>
                            <img class="shadow" src="<?php echo $serie->cover ?>">


                        </a>

                    </div>
                <?php } ?>


            </div>
            <hr>
            <div class="text-center">
                <?php
                /* Se imprimen los números de página */
                echo $pages;
                ?>
            </div>
            <hr>
        </div>
    </div>
</div>


<?php endblock() ?>


<?php startblock('scripts') ?>
<script>
    $(function () {

      

        $('#nav-series').addClass('active');
        <?php if(isset($category_name)){ ?>
        $('#category-<?php echo str_replace("+","-",urlencode($category_name)) ?>').addClass('active');
        <?php } ?>

        $("#categorias").tinyNav();
    });
</script>
<?php startblock('scripts2') ?><?php endblock() ?>
<?php endblock() ?>

