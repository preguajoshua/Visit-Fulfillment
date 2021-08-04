<div>
    <div class="border-gray-200 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <div class="text-sm font-medium text-gray-700">
                Current Agency Rating ({{ $agency->note->Rating }})
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
                        <button type="submit" class="border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <div wire:loading.remove>
                                <div class="inline-flex items-center px-4 py-2">
                                    <!-- Heroicon name: solid/pencil -->
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Update Agency Rating
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
