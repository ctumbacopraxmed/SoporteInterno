<div class="space-y-6">
    <!-- Cabecera servidor -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 rounded-2xl bg-blue-50 flex items-center justify-center">
                    <i data-lucide="Server" class="w-8 h-8 text-blue-700"></i>
                </div>
                <div>
                    <div class="grid grid-cols-2 items-center">
                        <h1 class="text-3xl font-bold text-gray-900"><?= $server['serverName'] ?></h1>
                        <div class="mx-3">
                            <?php if ($server['online']) : ?>
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 font-semibold">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    En Linea
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 font-semibold">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    Fuera de Linea
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-6 mt-3 text-gray-500">
                        <span class="inline-flex items-center gap-2 px-3 py-1">
                            <i data-lucide="Monitor" class="w-5 h-5"></i>
                            <span class="font-bold select-none">IP:</span> <?= $server['ip_address'] ?>
                        </span>
                        <span class="inline-flex items-center gap-2 px-3 py-1">
                            <i data-lucide="UserRound" class="w-5 h-5"></i>
                            <span class="font-bold select-none">Usuario:</span><?= $server['user'] ?>
                        </span>
                        <span class="inline-flex items-center gap-2 px-3 py-1">
                            <i data-lucide="SquareTerminal" class="w-5 h-5"></i>
                            <span class="font-bold select-none">SO:</span><?= $server['operating_system'] ?>
                        </span>
                        <span class="inline-flex items-center gap-2 px-3 py-1">
                            <i data-lucide="Container" class="w-5 h-5"></i>
                            <span class="font-bold select-none">Entorno:</span><?= $server['environment'] ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Servicios -->
    <div class="space-y-4">
        <div class="flex items-center justify-between select-none mb-3">
            <div class="font-bold text-lg">Servicios del Servidor</div>
            <div class="flex justify-end">
                <button id="btnModalServices"
                    class="flex items-center gap-2 bg-blue-500 text-white hover:bg-blue-600 rounded-xl px-4 py-2 transition-colors text-sm cursor-pointer">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    <span>Agregar Servicio</span>
                </button>
            </div>
        </div>
        <?php
        if (!empty($server['services']) && sizeof($server['services']) > 0) {
            foreach ($server['services'] as $service): ?>
                <?php
                $line = "root@" . strtolower(str_replace(' ', '-', $service['serviceName'])) . ":~# ";
                ?>
                <details class="group bg-white rounded-2xl shadow-sm overflow-hidden">
                    <summary
                        class="cursor-pointer select-none list-none flex items-center justify-between p-5 hover:bg-gray-50">
                        <div class="flex items-center gap-4">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-gray-400 transition group-open:rotate-90"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            <div>
                                <h3 class="text-lg font-semibold mb-0"><?= $service['serviceName'] ?></h3>
                                <span class="text-gray-400 text-sm"><?= $service['description'] ?></span>
                            </div>
                        </div>
                    </summary>
                    <div class="border-t border-gray-200 p-4">
                        <div class="grid grid-cols-12 gap-4">
                            <!-- Terminal -->
                            <div class="col-span-12 lg:col-span-9">
                                <div id="terminal-<?= $service['serviceId'] ?>" class="bg-black select-none rounded-xl h-[420px] overflow-auto p-5 font-mono text-sm">
                                    <pre class="text-white"><?= $line . "\n" ?></pre>
                                </div>
                            </div>
                            <!-- Comandos -->
                            <div class="col-span-12 lg:col-span-3 h-[420px] overflow-auto">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <h4 class="font-semibold mb-4">Comandos</h4>
                                    <div class="space-y-3">
                                        <?php foreach ($service['commands'] as $command): ?>
                                            <?php
                                            $icono = 'SquareTerminal';
                                            if (preg_match('/\brestart\b/', $command['command'])) {
                                                $icono = "RotateCcw";
                                            }
                                            if (preg_match('/\bstart\b/', $command['command'])) {
                                                $icono = "Play";
                                            }
                                            if (preg_match('/\bstop\b/', $command['command'])) {
                                                $icono = "Square";
                                            }
                                            if (preg_match('/\bstatus\b/', $command['command'])) {
                                                $icono = "Info";
                                            }
                                            ?>
                                            <button class="w-full border border-gray-400 hover:bg-gray-200 px-4 py-2 rounded-lg flex items-center gap-2" onclick="executeCommand(<?= $server['id'] ?>,<?= $service['serviceId'] ?>,<?= $command['commandId'] ?>,'<?= $line ?>')">
                                                <i data-lucide="<?= $icono ?>" class="w-5 h-5"></i>
                                                <span><?= $command['commandName'] ?></span>
                                            </button>
                                        <?php endforeach; ?>
                                        <button class="w-full bg-sky-700 hover:bg-sky-800 text-white px-4 py-2 rounded-lg flex items-center gap-2" onclick="executeCommandLogs(<?= $server['id'] ?>,<?= $service['serviceId'] ?>,'<?= $line ?>')">
                                            <i data-lucide="ScrollText" class="w-5 h-5"></i>
                                            <span>Ver Logs</span>
                                        </button>
                                        <button class="w-full bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg flex items-center gap-2"
                                            onclick="clearTerminal(<?= $service['serviceId'] ?>,'<?= $line ?>')">
                                            <i data-lucide="BrushCleaning" class="w-5 h-5"></i>
                                            <span>Limpiar Terminal</span>
                                        </button>
                                        <button id="btnModalCommands" data-id="<?= $service['serviceId'] ?>" class="w-full bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                                            <i data-lucide="CirclePlus" class="w-5 h-5"></i>
                                            <span>Agregar Comando</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </details>
        <?php endforeach;
        } ?>
    </div>
</div>
<div id="ModalServices" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 overflow-y-auto">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm modal-overlay"></div>
    <!-- Card -->
    <div id="ModalServicesContent" class="modal-content relative w-full max-w-3xl max-h-[90vh] mx-4 flex flex-col bg-white rounded-2xl shadow-2xl scale-95 opacity-0 transition-all duration-300 ease-out">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-5">
            <div>
                <div class="flex items-center gap-2">
                    <i data-lucide="save" class="w-5 h-5"></i>
                    <h2 class="text-xl font-bold text-gray-800">Agregar Servicio</h2>
                </div>
                <p class="text-sm text-gray-500 mt-1">Registra un nuevo servicio para administrar.</p>
            </div>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5 text-gray-500"></i>
            </button>
        </div>
        <!-- Body -->
        <div class="p-6 space-y-5 pt-0 overflow-y-auto">
            <div>
                <label class="block text-sm text-gray-700 font-bold mb-2">Nombre del Servicio <span class="text-red-600">*</span></label>
                <input id="name" type="text" placeholder="Nombre del Servicio" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm text-gray-700 font-bold mb-2">Descripción del Servicio</label>
                <input id="description" type="text" placeholder="Descripción del Servicio" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm text-gray-700 font-bold mb-2">Comando de Logs <span class="text-red-600">*</span></label>
                <input id="file_log" type="text" placeholder="tail -n 10 /etc/logs/error.log" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <span class="text-red-600">
                    <ul class="list-disc ml-5 mt-2">
                        <li>Verifique que el comando sea válido y compatible con el sistema operativo del servidor de destino.</li>
                        <li>No utilice comandos interactivos o que permanezcan en ejecución indefinidamente, por ejemplo: <code>tail -f</code>, <code>top</code>, <code>watch</code>, entre otros.</li>
                        <li>Asegúrese de que el usuario configurado tenga los permisos necesarios para ejecutar el comando.</li>
                        <li>Revise cuidadosamente el comando antes de guardarlo, ya que podría afectar el funcionamiento del servidor.</li>
                    </ul>
                </span>
            </div>
        </div>
        <!-- Footer -->
        <div class="flex justify-end gap-3 px-6 py-5 rounded-b-2xl">
            <button data-modal-close class="px-5 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 transition-colors">
                Cancelar
            </button>
            <button data-id="<?= $server['id'] ?>" class="px-5 py-2.5 rounded-xl bg-blue-500 text-white hover:bg-blue-600 transition-colors btn-createService">
                Guardar
            </button>
        </div>
    </div>
</div>
<div id="ModalCommands" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 overflow-y-auto modal">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm modal-overlay"></div>
    <!-- Card -->
    <div id="ModalCommandsContent" class="relative w-full max-w-3xl max-h-[90vh] mx-4 flex flex-col bg-white rounded-2xl shadow-2xl scale-95 opacity-0 transition-all duration-300 ease-out modal-content">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-5">
            <div>
                <div class="flex items-center gap-2">
                    <i data-lucide="save" class="w-5 h-5"></i>
                    <h2 class="text-xl font-bold text-gray-800">Agregar Comando</h2>
                </div>
                <p class="text-sm text-gray-500 mt-1">Registra un nuevo comando para el servicio.</p>
            </div>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5 text-gray-500"></i>
            </button>
        </div>
        <!-- Body -->
        <div class="p-6 space-y-5 pt-0 overflow-y-auto">
            <input type="hidden" id="servicioId">
            <div>
                <label class="block text-sm text-gray-700 font-bold mb-2">Nombre del Comando <span class="text-red-600">*</span></label>
                <input id="namec" type="text" placeholder="Nombre del Servicio" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm text-gray-700 font-bold mb-2">Comando <span class="text-red-600">*</span></label>
                <input id="command" type="text" placeholder="tail -n 10 /etc/logs/error.log" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <span class="text-red-600">
                    <ul class="list-disc ml-5 mt-2">
                        <li>Verifique que el comando sea válido y compatible con el sistema operativo del servidor de destino.</li>
                        <li>No utilice comandos interactivos o que permanezcan en ejecución indefinidamente, por ejemplo: <code>tail -f</code>, <code>top</code>, <code>watch</code>, entre otros.</li>
                        <li>Asegúrese de que el usuario configurado tenga los permisos necesarios para ejecutar el comando.</li>
                        <li>Revise cuidadosamente el comando antes de guardarlo, ya que podría afectar el funcionamiento del servidor.</li>
                    </ul>
                </span>
            </div>
        </div>
        <!-- Footer -->
        <div class="flex justify-end gap-3 px-6 py-5 rounded-b-2xl">
            <button data-modal-close class="px-5 py-2.5 rounded-xl border border-gray-300 hover:bg-gray-100 transition-colors">
                Cancelar
            </button>
            <button data-id="<?= $server['id'] ?>" class="px-5 py-2.5 rounded-xl bg-blue-500 text-white hover:bg-blue-600 transition-colors btn-createCommand">
                Guardar
            </button>
        </div>
    </div>
</div>