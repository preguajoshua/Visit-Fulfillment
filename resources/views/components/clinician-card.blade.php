<div class="bg-white shadow overflow-hidden sm:rounded-lg border border-transparent hover:border-green-500">
    <a href="{{ route('clinicians.show', ['clinician' => $clinician->profId] ) }}" class="cursor-pointer">
        <div class="flex-auto px-4 py-5 sm:px-6 space-y-5">
            <div>

                <div class="mt-2 text-sm flex items-center justify-center">
                    {{-- Avatar --}}
                    <img class="h-10 w-10 rounded-full" src="{{ asset('images/avatar.png') }}">
                    {{-- Name --}}
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $clinician->clinicianName }}
                        </div>
                    </div>

                    {{-- Star Responder --}}
                    @if ($clinician->note->isStarResponder)
                    <div>
                        <svg class="h-5 w-5 text-red-700" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                            <title>Star Responder</title>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    @endif
                </div>

                {{-- Tech Issue --}}
                <div class="mt-2 flex items-center justify-center text-gray-500 truncate">
                    @if ($clinician->note->IsTechIssue)
                    <span class="px-3 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800">
                        <svg class="mr-1 h-4 w-4 text-gray-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Technical Issue
                    </span>
                    @endif
                </div>

                <div class="mt-2 text-sm text-center text-gray-500 truncate">
                    {{-- Do Not Contact --}}
                    @if ($clinician->note->IsDnc)
                    <span class="px-3 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        <svg class="mr-1 h-4 w-4 text-red-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                        Do Not Contact
                    </span>

                    {{-- Client Paused --}}
                    @elseif ($clinician->note->IsPaused)
                    <span class="px-3 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        <svg class="mr-1 h-4 w-4 text-yellow-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke="none" stroke-width="1" fill="currentcolor" fill-rule="evenodd" d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 L2.92893219,17.0710678 Z M15.6568542,15.6568542 C18.7810486,12.5326599 18.7810486,7.46734008 15.6568542,4.34314575 C12.5326599,1.21895142 7.46734008,1.21895142 4.34314575,4.34314575 C1.21895142,7.46734008 1.21895142,12.5326599 4.34314575,15.6568542 C7.46734008,18.7810486 12.5326599,18.7810486 15.6568542,15.6568542 Z M7,6 L9,6 L9,14 L7,14 L7,6 Z M11,6 L13,6 L13,14 L11,14 L11,6 Z" id="Combined-Shape"></path>
                        </svg>
                        Client Paused
                    </span>

                    {{-- Phone Number --}}
                    @else
                        {{ $clinician->clinicianPhoneNumber }}
                    @endif
                </div>

                {{-- Role --}}
                <div class="mt-2 text-sm text-center text-gray-500 truncate">
                    {{ $clinician->role }}
                </div>

                {{-- Last Contacted --}}
                <div class="mt-2 text-sm text-center text-gray-500 truncate">
                    Last Contacted:
                    @if ($clinician->note->LastContacted != "")
                        {{ \Carbon\Carbon::parse($clinician->note->LastContacted)->diffForHumans() }}
                    @else
                        Never
                    @endif
                </div>

                {{-- Jobs Applied --}}
                <div class="mt-2 text-sm text-center text-gray-500 truncate">
                    Jobs Applied: {{ $clinician->completedJobsCount }} | Jobs Completed: {{ $clinician->appliedJobsCount }}
                </div>

                {{-- Distance --}}
                <div class="mt-2 text-sm flex items-center justify-center text-green-600">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                    {{ $clinician->distanceFromClinician }} miles from clinician
                </div>

                {{-- Posting Agency --}}
                <div class="mt-2 text-sm text-center text-gray-500 truncate">
                    {{ $clinician->postingAgency }}
                </div>

            </div>
        </div>
    </a>
</div>
