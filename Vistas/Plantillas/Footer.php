</main>

</div>
</div>

<script src="<?php echo RUTA_WEB; ?>/assets/js/sweetalert2.js"></script>
<script src="<?php echo RUTA_WEB; ?>/assets/js/notify.min.js"></script>
<script src="<?php echo RUTA_WEB; ?>/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script src="<?php echo RUTA_WEB; ?>/assets/js/tailwind-modal.js"></script>
<script src="<?php echo RUTA_WEB; ?>/assets/js/script.js"></script>
<?php if (!empty($scripts)): ?>
    <?php foreach ($scripts as $script): ?>
        <?php
        $src = str_starts_with($script, '/')
            ? RUTA_WEB . $script
            : RUTA_WEB . '/assets/js/' . $script;
        ?>
        <script src="<?= $src ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

<?php
if (isset($_SESSION['ok'])) {
    echo "<script>Notify(1,'" . $_SESSION['ok'] . "')</script>";
    unset($_SESSION['ok']);
}
if (isset($_SESSION['error'])) {
    echo "<script>Notify(2,'" . $_SESSION['error'] . "')</script>";
    unset($_SESSION['error']);
}
?>
</body>

</html>