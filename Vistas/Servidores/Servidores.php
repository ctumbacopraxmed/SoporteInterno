<div id="stats"></div>
<div id="list"></div>
<div id="serverModal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 overflow-y-auto">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm modal-overlay"></div>
    <!-- Card -->
    <div id="serverModalContent" class="modal-content relative w-full max-w-3xl max-h-[90vh] mx-4 flex flex-col bg-white rounded-2xl shadow-2xl scale-95 opacity-0 transition-all duration-300 ease-out">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-5">
            <div>
                <div class="flex items-center gap-2">
                    <i data-lucide="save" class="w-5 h-5"></i>
                    <h2 class="text-xl font-bold text-gray-800">Agregar Servidor</h2>
                </div>
                <p class="text-sm text-gray-500 mt-1">Registra un nuevo servidor para monitoreo.</p>
            </div>
            <button data-modal-close class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <i data-lucide="x" class="w-5 h-5 text-gray-500"></i>
            </button>
        </div>
        <!-- Body -->
        <div class="p-6 space-y-5 pt-0 overflow-y-auto">
            <div>
                <label class="block text-sm text-gray-700 font-bold mb-2">Nombre <span class="text-red-600">*</span></label>
                <input id="name" type="text" placeholder="Nombre del Servidor" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm text-gray-700 font-bold mb-2">Dirección IP <span class="text-red-600">*</span></label>
                <input id="ip_address" type="text" placeholder="255.255.255.255" class="w-full border border-gray-300 rounded-xl px-4 py-3 ip_address focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="grid grid-cols-2 gap-x-8">
                <div>
                    <label class="block text-sm text-gray-700 font-bold mb-2">Usuario <span class="text-red-600">*</span></label>
                    <input id="user" type="text" placeholder="root" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm text-gray-700 font-bold mb-2">Contraseña <span class="text-red-600">*</span></label>
                    <input id="password" type="password" placeholder="..." class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            <div>
                <label class="block text-sm text-gray-700 font-bold mb-2">Sistema Operativo <span class="text-red-600">*</span></label>
                <input id="operating_system" type="text" placeholder="Centos 9" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm text-gray-700 font-bold mb-2">Entorno <span class="text-red-600">*</span></label>
                <select id="environment" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="Producción">Producción</option>
                    <option value="Pruebas">Pruebas</option>
                </select>
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
    </div>
</div>