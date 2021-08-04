<div>

    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">

        <div class="text-sm font-medium text-gray-700">
            Clinician Notes
        </div>

        {{-- Badges --}}
        <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <x-validation-errors></x-validation-errors>

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

                {{-- Technical Issue --}}
                <div class="sm:grid sm:grid-cols-2">
                    <label for="toggle" class="text-gray-700">Technical Issue</label>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" wire:model="note.IsTechIssue" name="IsTechIssue" id="IsTechIssue" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none focus:ring-none cursor-pointer"/>
                        <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </div>

                {{-- Star Responder --}}
                <div class="sm:grid sm:grid-cols-2">
                    <label for="toggle" class="text-gray-700">Star Responder</label>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" wire:model="note.isStarResponder" name="isStarResponder" id="isStarResponder" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none focus:ring-none cursor-pointer"/>
                        <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                    </div>
                </div>

                {{-- Axxessian --}}
                <div class="sm:grid sm:grid-cols-2">
                    <label for="toggle" class="text-gray-700">Axxessian</label>
                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input type="checkbox" wire:model="note.isAxxessian" name="isAxxessian" id="isAxxessian" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none focus:ring-none cursor-pointer"/>
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

    {{-- Note --}}
    <div class="border-t border-gray-200 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <div class="text-sm font-medium text-gray-700">
            Note
        </div>

        <div class="text-sm text-gray-900 sm:mt-0 col-span-2">
            <form wire:submit.prevent="saveNote" class="space-y-2">
                <p class="text-gray-500">
                    Last Contacted: {{ $clinician->note->LastContactedDate }}
                </p>

                <textarea
                    wire:model.defer="note.Note"
                    rows="3"
                    class="shadow-sm focus:ring-green-500 focus:border-green-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
                >
                </textarea>

                <div class="text-right">
                    <button type="submit" class="py-2 px-4 border border-transparent font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Update Clinician Notes
                        <x-submit-loading-spinner wire:loading wire:target="saveNote"/> 
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Rating --}}
    <div class="border-t border-gray-200 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <div class="text-sm font-medium text-gray-700">
            Clinician Satisfaction Rating ({{ $note->Rating }})
        </div>

        <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            <form wire:submit.prevent="saveRating">
                <div>
                    <input
                        type="range"
                        wire:model.defer="note.Rating"
                        min="0" max="10" steps="10"
                        class="mt-3 w-full text-green-500"
                    >
                </div>

                <div class="flex justify-between mt-2 text-xs text-gray-400">
                    <span class="text-left">0</span>
                    <span class="text-center">5</span>
                    <span class="text-right">10</span>
                </div>

                <div class="mt-2 text-right">
                   <button type="submit" class="py-2 px-4 border border-transparent font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Update Satisfaction Rating
                        <x-submit-loading-spinner wire:loading wire:target="saveRating"/> 
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>


{{-- Style for toggle switch --}}
<style>
    .toggle-checkbox:checked {
        right: 0;
        border-color: #6b7280;
        color: white;
    }

    .toggle-checkbox:checked:focus {
        right: 0;
        border-color: #6b7280;
        color: white;
        outline: none;
    }

    .toggle-checkbox:checked:hover {
        border-color: #6b7280;
        color: white;
    }

    .toggle-checkbox:checked + .toggle-label {
        background-color: #68D391;
    }
</style>
