<div class="border-t border-gray-200 bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
    <dt class="text-sm font-medium text-gray-700">
        Clinician Logs
    </dt>
    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">

        <x-validation-errors></x-validation-errors>

        <div>
            <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                @forelse ($logs as $log)
                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex flex-col space-y-1">
                            <div class="font-medium">
                                <span class="py-1 px-2 text-sm text-gray-500">{{ $log->Username }} - {{ $log->Created }}</span>
                            </div>
                            <div>
                                <span class="ml-2 flex-1 w-0 truncate">
                                {{ $log->Log }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <button wire:click="delete('{{ $log->Id }}')" type="button" class="font-medium text-gray-400 hover:text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </li>
                @empty
                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        No Logs
                    </li>
                @endforelse
                <li class="p-3">
                    <form wire:submit.prevent="save">
                        <div>
                            <textarea 
                                wire:model.defer='log.Log' 
                                placeholder="Log Details..."
                                id="log" 
                                name="log" 
                                rows="3" 
                                class="shadow-sm focus:ring-green-500 focus:border-green-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" 
                            >
                            </textarea>
                        </div>
                        <div class="mt-3 text-right space-y-2">
                            <button type="submit" class="py-2 px-4 border border-transparent font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Update Clinician Logs
                            </button>
                        </div>
                    </form>
                </li>
                
            </ul>
        </div>
    </dd>
</div>
