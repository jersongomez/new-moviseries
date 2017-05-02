<?php include_once 'base.php' ?>
<?php startblock('title') ?>Moviseries premium con Paypal<?php endblock() ?>

<?php startblock('main-content') ?>

    <div class="container">
        <hr>
        <?php if (isset($_SESSION['username'])) { ?>


            <div class="card p-3">
                <p>NOTA: Recuerda solo pagas una vez y eres usuario premium para siempre.</p>

                <h2 style="text-transform: uppercase; text-align: center;">La seguridad es primero</h2>

                <p>Antes de realizar tu pago para convertirte en usuario premium sigue las siguientes
                    recomendaciones:</p>
                <ul>
                    <li>Asegurate de tener una conección a internet estable</li>
                    <li>Espera a que la página carge completamente.</li>
                    <li>Revisa que el monto a pagar que se te muestra en la página de paypal es de $5.00 (dolares
                        americanos)
                    </li>
                </ul>

                <div class="text-center">
                    <hr>
                    <div id="paypal-button-container"></div>
                    <hr>
                    <p>Cuando termines tu pago automaticamente se te redireccionara a la información de tu cuenta donde
                        podras verificar que ya eres usuario premium.</p>
                </div>


                <div id="error-result" class="alert alert-danger" hidden></div>

            </div>
        <?php } else { ?>
            <div class=" alert alert-info text-center">
                <img src="/assets/img/logo.png" alt="" width="200">

                <h2>ERROR: por tu seguridad y para asegurarte que tu transacción sea exitosa, debes iniciar sesión para
                    ver el contenido de esta página</h2>
            </div>
        <?php } ?>
    </div><br>

<?php endblock() ?>

<?php startblock('scripts') ?>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <script>
        // Render the PayPal button

        paypal.Button.render({

            env: 'sandbox', // sandbox | production
            locale: 'es_ES',
            style: {
                label: 'checkout',
                size: 'medium',
                shape: 'rect',
                color: 'blue'
            },

            client: {
                sandbox: 'AYJaSTZxNbHDGjWTVzrq16qzWI1AP-xSudr9nH8LKJk5QP0QMJnKigZaXUlEMH8wLNFSC9gnPjrlecE9',
                production: 'EKQ-rttQhApD5Ib-Lm6ayk5lJtmaq7iMgSXooqlC-k33exQXjvdtwFyzIhE43gUXixtHGtGRjnLrYsOl'
            },


            commit: true,

            payment: function () {

                return paypal.rest.payment.create(this.props.env, this.props.client, {
                    transactions: [
                        {
                            amount: {total: '0.01', currency: 'USD'}
                        }
                    ]
                });
            },

            // Wait for the payment to be authorized by the customer

            onAuthorize: function (data, actions) {
                return actions.payment.execute().then(function () {
                    $.ajax({
                        url: '<?php echo base_url('user-premium') ?>',
                        type: 'post',
                        data: 'user_id=' +<?php echo $_SESSION['user_id'] ?>,
                        success: function (data) {
                            if ($.trim(data) === 'exito') {
                                window.location = '<?php echo base_url('mi-cuenta') ?>'
                            } else {
                                $('#error-result').show();
                                $('#error-result').html("Algo salio mal, por favor contacte al adminstrador.");
                            }
                        }
                    });
                });
            }

        }, '#paypal-button-container');
    </script>
<?php endblock() ?>