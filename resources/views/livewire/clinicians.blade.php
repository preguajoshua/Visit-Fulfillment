<div>

    {{-- Filters --}}
    <div class="flex justify-between bg-white shadow overflow-hidden sm:rounded-lg px-4 py-3">
        <div>
            <h3 class="text-lg font-medium leading-6 text-gray-900">Filters</h3>
            <button type="button" wire:click="resetFilters" class="mt-1 inline-flex items-center px-3 py-1 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-20">
                <svg class="-ml-1 mr-2 h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Reset
            </button>
        </div>

        <div class="flex flex-col">
            <div class="block text-sm font-medium text-gray-700">Notes:</div>
            <div class="inline-flex rounded-md shadow-sm -space-x-px">
                <button wire:click="clearBadges" class="inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                    None
                </button>
                <x-group-button prop="filters.starResponder" value="1" :current="$filters['starResponder']">
                    Star Responder
                </x-group-button>
                <x-group-button prop="filters.technicalIssue" value="1" :current="$filters['technicalIssue']">
                    Technical Issue
                </x-group-button>
                <x-group-button prop="filters.paused" value="1" :current="$filters['paused']">
                    Paused
                </x-group-button>
                <x-group-button prop="filters.doNotContact" value="1" :current="$filters['doNotContact']" position="end">
                    Do Not Contact
                </x-group-button>
            </div>
        </div>

        <div>
            <label for="rating" class="block text-sm font-medium text-gray-700">Rating:</label>
            <div class="space-x-1">
                <button wire:click="$set('filters.rating', 'good')">
                    <x-rating-icon type="good" size="9" mute="text-gray-600"></x-rating-icon>
                </button>
                <button wire:click="$set('filters.rating', 'neutral')">
                    <x-rating-icon type="neutral" size="9" mute="text-gray-600"></x-rating-icon>
                </button>
                <button wire:click="$set('filters.rating', 'poor')">
                    <x-rating-icon type="poor" size="9" mute="text-gray-600"></x-rating-icon>
                </button>
           </div>
        </div>
    </div>

    {{-- Table count and sorting --}}
    <div class="flex justify-between mt-8 mb-2">
        <div class="text-sm text-gray-500">&nbsp;</div>
        <div class="text-sm text-gray-500">Sort by:
            <a wire:click.prevent="$set('orderBy', 'name')" class="hover:underline cursor-pointer">Name</a> |
            <a wire:click.prevent="$set('orderBy', 'lastContacted')" class="hover:underline cursor-pointer">Last Contacted</a>
        </div>
    </div>

    {{-- Results --}}
    <div wire:loading.remove class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{-- Rating --}}
                                    <x-rating-icon type="neutral" color="text-gray-300" title="Rating"></x-rating-icon>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Last contacted
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Notes
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($this->clinicians as $clinician)
                            <tr wire:click="clinicianDetails('{{ $clinician->Id }}')" class="cursor-pointer hover:bg-gray-50">
                                {{-- Name --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        {{-- Avatar --}}
                                        <div class="flex-shrink-0 h-10 w-10 relative">
                                            <img class="h-10 w-10 rounded-full" src="{{ asset('images/avatar.png') }}" alt="{{ $clinician->fullName }}">

                                            @if ($clinician->note->StarResponder ?? null)
                                            <div class="absolute -bottom-1 -right-1">
                                                <svg class="h-5 w-5 text-red-700" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                                                    <title>Star Responder</title>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                </svg>
                                            </div>
                                            @endif
                                        </div>

                                        {{-- Name and Phone Number --}}
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $clinician->fullName }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $clinician->identity->PhoneNumber ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Rating --}}
                                <td class="px-6 py-4">
                                    @if ($iconType = $clinician->note->ratingDescription ?? null)
                                    <x-rating-icon :type="$iconType"></x-rating-icon>
                                    @endif
                                </td>

                                {{-- Role --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $clinician->roles[0]->Role ?? 'No Role Found' }}
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-badge text="text-green-800" bg="bg-green-100">{{ $clinician->Status }}</x-badge>
                                </td>

                                {{-- Last contacted --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $clinician->note->visitedAgo ?? '-' }}</div>
                                    <div class="text-sm text-gray-500">{{ $clinician->note->LastContacted ?? 'Never' }}</div>
                                </td>

                                {{-- Notes --}}
                                <td class="px-6 py-4 space-y-2">
                                    @if ($clinician->note->TechIssue ?? null)
                                        <x-badge.tech-issue></x-badge.tech-issue>
                                    @endif

                                    @if ($clinician->note->Paused ?? null)
                                        <x-badge.paused></x-badge.paused>
                                    @endif

                                    @if ($clinician->note->Dnc ?? null)
                                        <x-badge.dnc></x-badge.dnc>
                                    @endif
                                </td>
                            </tr>

                            @empty
                            {{-- No results found --}}
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap">
                                    No clinicians found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-5">
            {{ $this->clinicians->links() }}
        </div>
    </div>

    <x-loading-spinner wire:loading.block />
</div>
