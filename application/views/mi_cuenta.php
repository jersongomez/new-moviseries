<?php include_once 'base.php' ?>
<?php startblock('title') ?>Moviseries Tu cuenta<?php endblock() ?>

<?php startblock('main-content') ?>
<div class="container">
    <hr>
    <div class="card p-4">
        <h2 class="text-center">Hola <?php echo $user->username ?></h2>
        <hr>
        <p>A continucación te presentamos la informacion de tu cuenta</p>
        <ul>
            <li>Nombre de usuario: <?php echo $user->username ?></li>
            <li>E-mail: <?php echo $user->email ?></li>
            <li>Tipo de cuenta: <?php echo $user->user_type ?></li>
        </ul>

        <p>No lo olvides esta información es esclusivamente tuya y de nadie más.</p>
    </div>
    <hr>
</div>
<?php endblock() ?>
