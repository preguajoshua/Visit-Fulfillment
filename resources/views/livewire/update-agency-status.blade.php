<div>
    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <div class="text-sm font-medium text-gray-700">
            Agency Notes
        </div>

        {{-- Badges --}}
        <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <form class="space-y-5">

                {{-- Do Not Contact --}}
                <div class="sm:grid sm:grid-cols-2">
                    <label for="toggle" class="text-gray-700">Do Not Contact</label>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input 
                            type="checkbox" 
                            wire:model="note.IsDnc" 
                            name="IsDnc" 
                            id="IsDnc" 
                            class="focus:outline-none toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                        />
                        <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </div>

                {{-- Paused --}}
                <div class="sm:grid sm:grid-cols-2">
                    <label for="toggle" class="text-gray-700">Paused</label>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" wire:model="note.IsPaused" name="IsPaused" id="IsPaused" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none focus:ring-color-none cursor-pointer"/>
                        <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </div>

                {{-- Reset --}}
                <div class="flex flex-row space-x-2">
                    <button wire:click="clearBadges" type="button" class="py-2 px-4 flex items-center border border-gray-600 text-gray-600 max-w-max shadow-sm hover:shadow-lg rounded-md w-auto h-10 ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>Reset</p>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>