<div>
    <div>
        <div class="border-t border-gray-200 bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-700">
                Agency Logs
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">

                {{-- TODO - Style and make a component --}}
                @if ($errors->any())
                <div class="mb-3 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">

                    <strong>Please correct the following errors:</strong>
                    <ul class="mb-0 mt-1 italic">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    
                </div>
                @endif

                <div>
                    <ul class="divide-y divide-gray-200">
                        @forelse ($logs as $log)
                        <li>
                            <div class="flex">
                                <div class="flex-shrink-0 mr-3">
                                    <img class="mt-2 rounded-full w-8 h-8 sm:w-10 sm:h-10 rounded-full" src="{{ asset('images/avatar.png') }}" alt="{{ $log->fullName }}">
                                </div>
                                <div class="flex-1 px-2 py-2 leading-relaxed">
                                    <strong>{{ $log->Username }}</strong> <span class="text-md text-gray-400">{{ $log->Created }}</span>
                                    <p class="text-sm break-all">{{ $log->Log }}</p>
                                </div>
                                @if(Auth::id() == $log->UserId)
                                <div class="ml-4 flex items-center">
                                    <button wire:click="delete('{{ $log->Id }}')" type="button" class="font-medium text-gray-400 hover:text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                                @endif
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
                                        rows="3"
                                        id="log" 
                                        name="log"
                                        class="shadow-sm focus:ring-green-500 focus:border-green-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" 
                                    >
                                    </textarea>
                                </div>
                                <div class="mt-3 text-right space-y-2">
                                    <button type="submit" class="py-2 px-4 border border-transparent font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </li>
                        
                    </ul>
                </div>
            </dd>
        </div>
    </div>
</div>