<div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">

    <div class="text-sm font-medium text-gray-700">
        Schedule Follow-up
    </div>

    <div class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
        
        <x-validation-errors></x-validation-errors>

        <div>
            <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                <li>
                   <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 w-2/4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Detail
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($followUps as $followUp)
                            <tr class="hover:bg-gray-50">
                                <td  class="pl-3 pr-4 py-3">
                                    {{ $followUp->FollowUpDate }}
                                </td>
                                <td  class="pl-3 pr-4 py-3 w-2/4">
                                    {{ $followUp->FollowUpDetail }}
                                </td>
                                <td  class="pl-3 pr-4 py-3">
                                    {{ $followUp->Created }}
                                </td>
                                <td  class="pl-3 pr-4 py-3">
                                    <button wire:click="delete('{{ $followUp->ID }}')" type="button" class="font-medium text-gray-400 hover:text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                No Follow-up.
                            </li>
                        @endforelse
                        </tbody>
                    </table>
                </li>
                <li class="p-3">
                    <form wire:submit.prevent="save" class="space-y-2">

                        {{-- Follow-up details --}}
                        <textarea
                            wire:model.defer="followUp.FollowUpDetail"
                            placeholder="Follow-up Details..."
                            name="detail"
                            id="detail"
                            rows="3"
                            class="shadow-sm focus:ring-green-500 focus:border-green-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
                        >
                        </textarea>
            
                        {{-- Follow-up date --}}
                        <div class="flex justify-between">
                            <input
                                type="date"
                                wire:model.defer="followUp.FollowUpDate"
                                name="date"
                                id="date"
                                class="shadow-sm focus:ring-green-500 focus:border-green-500 mt-1 block w-1/2 sm:text-sm border-gray-300 rounded-md"
                            >
                            <button type="submit" class="py-2 px-4 border border-transparent font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Create Follow-up
                            </button>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </div>

</div>
