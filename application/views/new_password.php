<?php include_once 'base.php' ?>

<?php startblock('title') ?>Cambio de contraseña<?php endblock() ?>


<?php startblock('main-content') ?>
<div class="row p-5">
    <div class="col-md-3 hidden-sm-down"></div>
    <div class="col-md-6">
        <h2 class="text-center">Cambio de contraseña</h2>

        <form id="form-reset"
        " action="">
        <input type="text" name="user_id" value="<?php echo $user_id ?>" hidden>
        <input type="text" name="token" value="<?php echo $token ?>" hidden>
        <input type="text" name="reset_token" value="<?php echo $reset_token ?>" hidden>

        <input id="password1" type="password" name="password1" class="form-control" required
               placeholder="nueva contraseña">
        <br>
        <input id="password2" type="password" name="password2" class="form-control" required
               placeholder="verificación nueva contraseña">
        <hr>
        <button type="submit" class="btn btn-primary">Cambiar contraseña</button>

        <br>
        <span id="result-reset" class="al alert-info"></span>
        </form>

    </div>
</div>
<?php endblock() ?>

<?php startblock('scripts') ?>
<script>
    var running = false;
    $(function () {
        $('#form-reset').submit(function () {
            if (!running) {
                if ($.trim($('#password1').val()).length > 5 && $.trim($('#password2').val()).length > 5) {
                    if ($('#password1').val() === $('#password2').val()) {
                        $('#result-reset').html('verificando información');

                        $.ajax({
                            url: '<?php echo base_url('new-password') ?>',
                            type: 'post',
                            data: $('#form-reset').serialize(),
                            success: function (result) {
                                $('#result-reset').html(result);

                                $('#form-reset').trigger('reset');
                            }

                        });
                    } else {
                        $('#result-reset').html('Laa contraseñas ingresadas no coinciden');
                    }
                } else {
                    $('#result-reset').html('Ingrese una contraseña con mas de 6 caracteres');
                }


            } else {
                alert("esta tarea ya esta en curso");
            }
            return false;
        });
    });
</script>
<?php endblock() ?>
