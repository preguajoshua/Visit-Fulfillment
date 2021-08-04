<div>
    <div>
        {{-- TODO - Style and make a component --}}
        @if ($errors->any())
        <div class="alert alert-primary" role="alert">

            <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
        @endif

        {{-- Note --}}
        <div class="border-gray-200 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div class="text-sm font-medium text-gray-700">
            
            </div>

            <div class="text-sm text-gray-900 sm:mt-0 col-span-2">
                <form wire:submit.prevent="saveNote" class="space-y-2">
                    <textarea
                        wire:model.defer="note.Note"
                        rows="3"
                        class="shadow-sm focus:ring-green-500 focus:border-green-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
                    >
                    </textarea>

                    <div class="text-right">
                        <button type="submit" class="border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <div wire:loading.remove>
                                <div class="inline-flex items-center px-4 py-2">
                                    <!-- Heroicon name: solid/pencil -->
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" clip-rule="evenodd" />
                                    </svg>
                                    Update Agency Note
                                </div>
                            </div>
                            <div wire:loading>
                                <div class="inline-flex items-center px-4 py-2">
                                    <svg class="-ml-1 mr-2 h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Updating...
                                </div>
                            </div>
                        </button>  
                    </div>
                </form>
            </div>
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