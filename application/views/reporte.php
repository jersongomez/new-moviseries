<?php include_once 'base.php' ?>

<?php startblock('title') ?>reporte de enlace caido<?php endblock() ?>
<?php startblock('main-content') ?>
<hr>
<div class="container text-center" style="border:  3px dotted #ff0f4d;">
    <img src="/assets/img/link_break.png" width="200"><br>
    <b>Ayudanos a mejorar nuestro servicio reportando los enlaces caidos</b>
    <hr>
    <div class="form-group">
        <form id="form-sms" action="<?php echo base_url('send_report') ?>">
            <input name="token" type="text" hidden value="<?php echo $token ?>">

            <div class="row">
                <div class="col-md-8">
                    <input readonly name="subject" type="text" class="form-control" required
                           value="<?php echo $_GET['msg'] . ', url_id = ' . $_GET['url_id'] ?>">
                </div>
                <div class="col-md-4">
                    <input name="email" type="email" class="form-control" required
                           placeholder="Tu E-mail">
                </div>
            </div>
            <textarea style="height: 100px;" name="msg" id="" cols="30" rows="10" class="form-control"
                      placeholder="describenos cual es el problema con el enlace.." required></textarea>
            <br>
            <button class="btn btn-primary">ENVIAR REPORTE</button>
            <br>
            <span id="result-sms"></span>
        </form>

    </div>
</div>
<hr>
<?php endblock() ?>

<?php startblock('scripts') ?>
<script>
    var run = false;
    $(function () {
        $('#form-sms').submit(function () {
            if (!run) {
                run=true;
                $('#result-sms').html('Enviando reporte por favor espere ...');
                $.ajax({
                    url: $('#form-sms').attr('action'),
                    type: 'post',
                    data: $('#form-sms').serialize(),
                    success: function (data) {
                        run=false;
                        $('#result-sms').html(data);
                    },
                    error:function(data){
                        run=false;
                        $('#result-sms').html(data);
                    }


                });
            }

            return false;
        });
    });
</script>
<?php endblock() ?>
