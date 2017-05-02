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
            <li>Tu ID de usuario: <span style="color: #0000ee;"><?php echo $user->user_id ?></span></li>
            <li>Nombre de usuario: <span style="color: #0000ee;"><?php echo $user->username ?></span></li>
            <li>E-mail: <span style="color: #0000ee;"><?php echo $user->email ?></span></li>
            <li>Tipo de cuenta: <span style="color: #0000ee;"><?php echo $user->user_type ?></span></li>
        </ul>

        <p>No lo olvides esta información es esclusivamente tuya y de nadie más.</p>
    </div>
    <hr>
</div>
<?php endblock() ?>
