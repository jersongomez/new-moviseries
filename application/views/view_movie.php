<?php include_once 'base.php' ?>


<?php startblock('title') ?>
<?php echo $movie->name . ' (' ?><?php echo $url->language_name . '-' . $url->quality ?>
<?php endblock() ?>

<?php startblock('main-content') ?>
<h2 class="text-center" style="background-color: #E91E63; color: #fff;padding-bottom: 10px; margin-bottom: 0px; ">
    <?php echo $movie->name . ' (' . $url->language_name . '-' . $url->quality . ')' ?> </h2>

<?php if ($url->server == "stream.moe") { ?>
    <iframe src="https://stream.moe/embed2/<?php echo $url->file_id ?>/" frameborder="0" scrolling="no"
            height="600"
            style="overflow: hidden; width: 100%; max-height: 500px; margin-bottom: -6px;" webkitAllowFullScreen="true"
            mozallowfullscreen="true"
            allowFullScreen="true"></iframe>
<?php } else if ($url->server == "openload") { ?>
    <iframe src="https://openload.co/embed/<?php echo $url->file_id ?>" scrolling="no" frameborder="0" height="400"
            style="overflow: hidden; width: 100%; max-height: 500px; margin-bottom: -6px;"
            allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
<?php } ?>

<?php endblock() ?>


<?php startblock('scripts') ?>
<script>plyr.setup();</script>

<script>
    $(function () {
        var altura_navegador = $(window).height();
        var altura_titulo = $('#titulo').height();

        var altura_video = altura_navegador - 2 * altura_titulo;


    });


</script>
<?php endblock() ?>
