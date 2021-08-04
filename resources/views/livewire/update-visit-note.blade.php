<div>
    <x-validation-errors></x-validation-errors>

    <form wire:submit.prevent="save">
        <dl>

            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Visit Notes
                </dt>

                <dd class="space-y-5 text-sm text-gray-900 sm:mt-0 sm:col-span-2">

                    {{-- Flags --}}
                    <fieldset>
                        <legend class="text-base font-medium text-gray-900">Flags</legend>
                        <div class="mt-4 space-y-4">

                            {{-- Understaffed --}}
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input wire:model.defer="note.isUnderstaffed" id="understaffed" name="understaffed" type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="understaffed" class="font-medium text-gray-700">Understaffed</label>
                                    <p class="text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                </div>
                            </div>

                            {{-- Low Visit Rate --}}
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input wire:model.defer="note.isLowvisitrate" id="low-visit-rate" name="low-visit-rate" type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="low-visit-rate" class="font-medium text-gray-700">Low Visit Rate</label>
                                    <p class="text-gray-500">Repellat quasi incidunt quaerat qui nemo impedit quod.</p>
                                </div>
                            </div>

                            {{-- Reschedule / Remove --}}
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input wire:model.defer="note.isRescheduleremove" id="reschedule-remove" name="reschedule-remove" type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="reschedule-remove" class="font-medium text-gray-700">Reschedule / Remove</label>
                                    <p class="text-gray-500">Tempora fuga praesentium quam dolore neque magnam fugit.</p>
                                </div>
                            </div>

                            {{-- Attempted Fulfillment --}}
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input wire:model.defer="note.isAttemptedFulfillment" id="attempted-fulfillment" name="attempted-fulfillment" type="checkbox" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="attempted-fulfillment" class="font-medium text-gray-700">Attempted Fulfillment</label>
                                    <p class="text-gray-500">Nihil assumenda velit esse aliquid, libero.</p>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    {{-- Notes --}}
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">
                            Notes
                        </label>
                        <div class="mt-1">
                            <textarea wire:model.defer="note.Note" id="notes" name="notes" rows="3" class="shadow-sm focus:ring-green-500 focus:border-green-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Brief description of the visit.
                        </p>
                    </div>
                </dd>
            </div>

            {{-- Submit Button --}}
            <div class="px-4 py-3 bg-gray-50 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt></dt>
                <dd>
                    <button type="submit" class="border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <div wire:loading.remove>
                            <div class="inline-flex items-center px-4 py-2">
                                <!-- Heroicon name: solid/pencil -->
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" clip-rule="evenodd" />
                                </svg>
                                Update Visit Notes
                            </div>
                        </div>
                        <div wire:loading>
                            <div class="inline-flex items-center px-4 py-2">
                                <svg class="-ml-1 mr-2 h-5 w-5 animate-reverse-spin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Updating...
                            </div>
                        </div>
                    </button>
                </dd>
            </div>

        </dl>
    </form>

</div>
