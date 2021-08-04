<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Agency Details
        </h2>
    </x-slot>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="flex flex-wrap justify-between px-4 py-5 sm:px-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-900 ">
                    {{ $agency->Name }}
                </h3>
            </div>
            <div class="flex flex-col flex-wrap space-y-2">
                <div class="flex flex-row flex-wrap justify-end">
                    <div class="flex flex-row space-x-1 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm">
                            {{ $agency->location->Address ?? '' }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-row justify-end space-x-1 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                    </svg>
                    <p class="text-sm">
                        {{ $agency->location->PhoneWork ?? ''}}
                    </p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200">
            <dl>
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-700">
                        Summary
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 space-y-10">
                        <div class="sm:grid sm:grid-cols-2">
                            <div class="flex flex-col">
                                <p class="text-gray-500 font-medium ">Jobs Completed</p>
                                <p>{{ $agency->jobs->count() ?? 0 }}</p>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-gray-500 font-medium ">Last Job Completed</p>
                                <p>
                                    @if($agency->jobs()->latest('Created')->first()?->Created ?? null)
                                        {{ \Carbon\Carbon::parse($agency->jobs()->latest('Created')->first()?->Created)->diffForHumans() }}
                                    @else
                                        Never
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="sm:grid sm:grid-cols-2">
                            <div class="flex flex-col">
                                <p class="text-gray-500 font-medium ">First Job Completed</p>
                                <p>
                                    @if($agency->jobs()->oldest('Created')->first()?->Created ?? null)
                                        {{ \Carbon\Carbon::parse($agency->jobs()->oldest('Created')->first()?->Created)->diffForHumans() }}
                                    @else
                                        Never
                                    @endif
                                </p>
                            </div>
                        </div>
                    </dd>
                </div> 
            </dl>
        </div>
    </div>

    <div>
        <div class="mt-5 bg-white shadow overflow-hidden sm:rounded-lg">
            <livewire:update-agency-status :agency="$agency">
            <livewire:update-agency-notes :agency="$agency">
            <livewire:update-agency-rating :agency="$agency">
        </div>
        
        <div x-data="{ isActive: 1 }">
            <div class="flex justify-center mt-5">
                <ul id="tabs" class="flex justify-center w-full px-1 pt-2">
                    <li x-on:click="isActive = 1" x-bind:class="isActive == 1 ? 'border-b-2 border-green-400 opacity-100' : 'hover:opacity-80'" class="px-4 py-2 -mb-px font-semibold text-gray-800  cursor-pointer rounded-t opacity-50">Schedule Follow-up</li>
                    <li x-on:click="isActive = 2" x-bind:class="isActive == 2 ? 'border-b-2 border-green-400 opacity-100' : 'hover:opacity-80'" class="px-4 py-2 font-semibold text-gray-800 rounded-t cursor-pointer opacity-50 ">Agency Logs</li>
                </ul>
            </div>
            <div x-show="isActive == 1" class="mt-5 bg-white shadow overflow-hidden sm:rounded-lg">
                <livewire:agency-schedule-followup :agency="$agency">
            </div>
            <div x-show="isActive == 2" class="mt-5 bg-white shadow overflow-hidden sm:rounded-lg">
                <livewire:manage-agency-logs :agency="$agency">
            </div>
        </div>

        <div>
            <div class="pt-6">
                {{-- Job Listings --}}
                <div>
                    <div class="text-sm text-gray-500 mb-2">
                        Found {{ $jobs->count() }} related jobs
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        @forelse ($jobs as $job)

                            <x-visit-card :visit="$job">
                                <x-slot name="badges">
                                    <x-badge text="text-pink-800" bg="bg-pink-100">
                                        Status: {{ $job->jobStatus }}
                                    </x-badge>

                                    <x-badge text="text-yellow-800" bg="bg-yellow-100">
                                        Applicants: {{ $job->applicantCount ?? 0 }}
                                    </x-badge>
                                </x-slot>
                            </x-visit-card>

                        @empty
                            {{-- No results found --}}
                            <div class="col-span-3 bg-white shadow overflow-hidden sm:rounded-lg">
                                <div class="flex flex-col items-center justify-center p-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" stroke="none" fill="currentColor" class="text-green-600" style="width: 200px;">
                                        <path d="M22.7142857,9.23809524 L21.5,6 L20.2857143,9.23809524 L18,10 L20.2857143,10.7619048 L21.5,14 L22.7142857,10.7619048 L25,10 L22.7142857,9.23809524 L22.7142857,9.23809524 Z M20.7142857,21.2380952 L19.5,18 L18.2857143,21.2380952 L16,22 L18.2857143,22.7619048 L19.5,26 L20.7142857,22.7619048 L23,22 L20.7142857,21.2380952 L20.7142857,21.2380952 L20.7142857,21.2380952 Z M13.4594595,13.4864865 L11.5,8 L9.54054054,13.4864865 L5,15 L9.54054054,16.5135135 L11.5,22 L13.4594595,16.5135135 L18,15 L13.4594595,13.4864865 L13.4594595,13.4864865 L13.4594595,13.4864865 Z"></path>
                                    </svg>
                                    <span>We didn't find results - sorry.</span>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
