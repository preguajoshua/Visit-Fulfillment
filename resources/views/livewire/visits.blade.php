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
            <div class="block text-sm font-medium text-gray-700">Job type:</div>
            <div class="inline-flex rounded-md shadow-sm -space-x-px">
                <x-group-button prop="filters.jobType" value="" :current="$filters['jobType']" position="start">
                    All
                </x-group-button>
                <x-group-button prop="filters.jobType" value="Internal" :current="$filters['jobType']">
                    Internal
                </x-group-button>
                <x-group-button prop="filters.jobType" value="External" :current="$filters['jobType']" position="end">
                    External
                </x-group-button>
            </div>
        </div>

        <div class="flex flex-col">
            <div class="block text-sm font-medium text-gray-700">Discipline:</div>
            <div class="inline-flex rounded-md shadow-sm -space-x-px">
                <x-group-button prop="filters.discipline" value="" :current="$filters['discipline']" position="start">
                    All
                </x-group-button>
                <x-group-button prop="filters.discipline" value="Nursing" :current="$filters['discipline']">
                    Nursing
                </x-group-button>
                <x-group-button prop="filters.discipline" value="PT" :current="$filters['discipline']" position="end">
                    Physical Therapy
                </x-group-button>
            </div>
        </div>

        <div>
            <label for="mile-radius" class="block text-sm font-medium text-gray-700">Within {{ $filters['radius'] }} miles:</label>
            <input type="range" wire:model="filters.radius" min="1" max="50" name="mile-radius" id="mile-radius" class="mt-3">
        </div>

        <div>
            <label for="max-date" class="flex justify-between text-sm font-medium text-gray-700">
            @empty ($filters['dateRange'])
                <span>Showing all future visits</span>
            @else
                <span>Visits up to:</span>
                <button wire:click="$set('filters.dateRange', null)" class="focus:outline-none">
                    <svg class="h-4 w-4 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z" />
                    </svg>
                </button>
            @endempty
            </label>
            <input type="date" min="{{ $tomorrow }}" wire:model="filters.dateRange" name="max-date" id="max-date" class="px-2.5 py-1.5 rounded-md border-gray-300 shadow-sm focus:border-green-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-20">
        </div>
    </div>

    {{-- Table count and sorting --}}
    <div class="flex justify-between mt-8 mb-2">
        <div class="text-sm text-gray-500">Displaying {{ count($visits) }} visits</div>
        <div class="text-sm text-gray-500">Sort by:
            <a wire:click.prevent="$set('filters.orderBy', 'VisitDate')" class="hover:underline cursor-pointer">Visit Date</a> |
            <a wire:click.prevent="$set('filters.orderBy', 'PostingDate')" class="hover:underline cursor-pointer">Posted Date</a>
        </div>
    </div>

    {{-- Results --}}
    <div wire:loading.remove class="grid grid-cols-3 gap-6">
        @forelse ($visits as $visit)

            <x-visit-card :visit="$visit"/>

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

    {{-- Pagination --}}
    <div class="mt-5">
        {{ $visits->links() }}
    </div>

    <x-loading-spinner wire:loading.block />
</div>
