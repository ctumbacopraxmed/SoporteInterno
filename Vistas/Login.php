<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="<?php echo RUTA_WEB; ?>/assets/images/logos/favicon.png" />
    <title><?php echo NOMBRE; ?> - Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="<?php echo RUTA_WEB; ?>/assets/css/style.css">
</head>

<body class="h-full bg-gray-50  transition-colors duration-300 font-display">
    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white  py-8 px-4 shadow-lg sm:rounded-lg sm:px-10 transition-colors duration-300">
                <div class="sm:mx-auto sm:w-full sm:max-w-md">
                    <div class="mx-auto flex items-center justify-center">
                        <img src="<?php echo RUTA_WEB; ?>/assets/images/logos/logo.png" width="190" alt="">
                    </div>
                    <h2 class="mt-6 text-center text-3xl font-semibold tracking-tight text-gray-900 ">
                        Soporte Interno
                    </h2>
                </div>
                <form class="space-y-6" action="<?php echo RUTA_WEB; ?>/Logear/" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 ">
                            Usuario
                        </label>
                        <div class="mt-1">
                            <input id="usuario" name="usuario" type="text" required placeholder="Ingrese su usuario"
                                class="w-full px-4 py-3 border border-gray-200  rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent font-body bg-white  text-gray-900  focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 ">
                            Password
                        </label>
                        <div class="mt-1">
                            <input id="clave" name="clave" type="password" autocomplete="current-password" required placeholder="Ingrese su clave"
                                class="w-full px-4 py-3 border border-gray-200  rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent font-body bg-white  text-gray-900  focus:outline-none">
                        </div>
                    </div>
                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-3 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2  transition-colors duration-200">
                            Ingresar
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <script src="<?php echo RUTA_WEB; ?>/assets/js/sweetalert2.js"></script>
    <script src="<?php echo RUTA_WEB; ?>/assets/js/notify.min.js"></script>
    <script src="<?php echo RUTA_WEB; ?>/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="<?php echo RUTA_WEB; ?>/assets/js/tailwind-modal.js"></script>
    <script src="<?php echo RUTA_WEB; ?>/assets/js/script.js"></script>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<script>Notify(2,'" . $_SESSION['error'] . "')</script>";
        unset($_SESSION['error']);
    }
    ?>
</body>

</html>