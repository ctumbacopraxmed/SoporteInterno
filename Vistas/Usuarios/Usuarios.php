<div class="shadow-lg rounded-xl bg-white p-4">
    <div class="flex items-center justify-between select-none mb-3">
        <div class="font-bold text-xl">Listado de usuarios</div>
        <div class="flex justify-end">
            <button id="btnOpenModal"
                class="flex items-center gap-2 bg-blue-500 text-white hover:bg-blue-600 rounded-xl px-4 py-2 transition-colors text-sm cursor-pointer">
                <i data-lucide="plus" class="w-5 h-5"></i>
                <span>Agregar Usuario</span>
            </button>
        </div>
    </div>
    <div class="relative w-64 mb-3">
        <i data-lucide="search"
            class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400">
        </i>
        <input id="tableSearch" type="text" placeholder="Buscar servidor..." class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div class="overflow-x-auto mt-3">
        <table class="w-full" id="table">
            <thead class="bg-gray-50 select-none">
                <tr>
                    <th class="sortable p-4 font-bold text-gray-700">
                        <div class="flex items-center gap-1 justify-center">
                            <span>#</span>
                            <i data-lucide="arrow-up-down" class="sort-icon w-4 h-4"></i>
                        </div>
                    </th>
                    <th class="sortable text-left p-4 font-bold text-gray-700">
                        <div class="flex items-center gap-1">
                            <span>Nombres</span>
                            <i data-lucide="arrow-up-down" class="sort-icon w-4 h-4"></i>
                        </div>
                    </th>
                    <th class="sortable text-left p-4 font-bold text-gray-700">
                        <div class="flex items-center gap-1">
                            <span>Usuario</span>
                            <i data-lucide="arrow-up-down" class="sort-icon w-4 h-4"></i>
                        </div>
                    </th>
                    <th class="sortable text-left p-4 font-bold text-gray-700">
                        <div class="flex items-center gap-1">
                            <span>Estado</span>
                            <i data-lucide="arrow-up-down" class="sort-icon w-4 h-4"></i>
                        </div>
                    </th>
                    <th class="text-center p-4 font-bold text-gray-700">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 ">
                <?php
                if (!empty($users) && is_array($users)) {
                    foreach ($users as $user) {
                ?>
                        <tr class="invoice-row hover:bg-gray-50" data-server-id="<?= $user->getId() ?>">
                            <td class="p-4 text-sm text-gray-800 font-bold text-center"><?= $user->getId() ?></td>
                            <td class="p-4 text-sm text-gray-800"><?= $user->getName() ?></td>
                            <td class="p-4 text-sm text-gray-800"><?= $user->getEmail() ?></td>
                            <td class="p-4 text-sm text-gray-800">
                                <?php
                                if ($user->getStatus() == 1) {
                                ?>
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 font-semibold">Activo</span>
                                <?php
                                } else {
                                ?>
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 font-semibold">Inactivo</span>
                                <?php
                                }
                                ?>
                            </td>
                            <td class="p-4 text-sm flex justify-center">
                                <a href="#" title="Resetear Clave" class="text-gray-600 hover:text-gray-800">
                                    <i data-lucide="LockKeyhole" class="w-5 h-5 cursor-pointer"></i>
                                </a>
                                <a href="<?= RUTA_WEB . "/Usuarios/" . $user->getId() ?>" title="Editar" class="text-gray-600 hover:text-gray-800 ms-3">
                                    <i data-lucide="SquarePen" class="w-5 h-5 cursor-pointer"></i>
                                </a>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div id="serverModal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 overflow-y-auto">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm modal-overlay"></div>
    <!-- Card -->
    <div id="serverModalContent" class="modal-content relative w-full max-w-3xl max-h-[90vh] mx-4 flex flex-col bg-white rounded-2xl shadow-2xl scale-95 opacity-0 transition-all duration-300 ease-out">
        <!-- Header -->
        <form action="<?= RUTA_WEB . "/Usuarios/create" ?>" method="POST" enctype="multipart/form-data">
            <div class="flex items-center justify-between px-6 py-5">
                <div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        <h2 class="text-xl font-bold text-gray-800">Agregar Usuario</h2>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Registra un nuevo usuario.</p>
                </div>
                <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <i data-lucide="x" class="w-5 h-5 text-gray-500"></i>
                </button>
            </div>
            <!-- Body -->
            <div class="p-6 space-y-5 pt-0 overflow-y-auto">
                <div>
                    <label class="block text-sm text-gray-700 font-bold mb-2">Nombres <span class="text-red-600">*</span></label>
                    <input id="name" name="name" type="text" placeholder="Ingrese su nombre y apellido" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div class="grid grid-cols-2 gap-x-8">
                    <div>
                        <label class="block text-sm text-gray-700 font-bold mb-2">Usuario <span class="text-red-600">*</span></label>
                        <input id="user" name="user" type="text" placeholder="Ingrese su usuario" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 font-bold mb-2">Contraseña <span class="text-red-600">*</span></label>
                        <input id="password" name="password" type="password" placeholder="Ingrese su contraseña" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <div class="flex justify-end gap-3 px-6 py-5 rounded-b-2xl">
                <button data-modal-close class="px-5 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 transition-colors">
                    Cancelar
                </button>
                <button class="px-5 py-2.5 rounded-xl bg-blue-500 text-white hover:bg-blue-600 transition-colors btn-create">
                    Guardar
                </button>
            </div>
        </form>

    </div>
</div>