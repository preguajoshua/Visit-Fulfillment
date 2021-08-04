<div class="{{ $bgColor }} shadow overflow-hidden sm:rounded-lg border border-transparent hover:border-green-500">
    <a href="{{ route('visits.show', ['id' => $visit->jobId]) }}">
        <div class="px-4 py-5 sm:px-6 space-y-5">

            {{-- Badges --}}
            <div>
            @if ($badges)
                {{ $badges }}
            @else
                {{-- Default Badges --}}
                <x-badge text="text-green-800" bg="bg-green-100">
                    {{ $visit->jobType }} Job
                </x-badge>

                <x-badge text="text-blue-800" bg="bg-blue-100">
                    {{ $visit->discipline }}
                </x-badge>
            @endif
            </div>

            {{-- Visit details --}}
            <div>
                <div class="text-sm text-gray-500 truncate">
                    {{ $visit->disciplineTask }} - {{ $visit->speciality }}
                </div>

                <h3 class="mt-2 text-lg leading-6 font-medium text-gray-900 truncate">
                    {{ $visit->agencyName }}
                </h3>

                <div class="mt-2 text-sm text-gray-500 truncate">
                    {{ $visit->jobAddress }}
                </div>

                @if( $visit->distanceFromClinician )
                    <div class="mt-2 flex items-center">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm text-green-600">{{ $visit->distanceFromClinician }} miles from clinician</span>
                    </div>
                @endif
            </div>

            {{-- Rates --}}
            <x-rates :visit="$visit">
                <table class="min-w-full {{ $ratesBgColor }} rounded">
                    <tbody>
                        <tr>
                            <td class="px-3 py-1 text-sm"></td>
                            <td class="px-3 py-1 text-sm text-green-600">{{ $component->disciplineOneLabel() }}</td>
                            <td class="px-3 py-1 text-sm text-green-600">{{ $component->disciplineTwoLabel() }}</td>
                        </tr>
                        <tr>
                            <td class="px-3 py-1 text-sm text-green-600 uppercase">Visit Rate</td>
                            <td class="px-3 py-1 text-sm">${{ $component->disciplineOneVisitRate() }}</td>
                            <td class="px-3 py-1 text-sm">${{ $component->disciplineTwoVisitRate() }}</td>
                        </tr>
                        <tr>
                            <td class="px-3 py-1 text-sm text-green-600 uppercase">Custom Rate</td>
                            <td class="px-3 py-1 text-sm">${{ $component->disciplineOneCustomRate() }}</td>
                            <td class="px-3 py-1 text-sm">${{ $component->disciplineTwoCustomRate() }}</td>
                        </tr>
                    </tbody>
                </table>
            </x-rates>

            {{-- Dates --}}
            <div class="text-sm text-gray-500 flex items-center justify-between">
                <div><span class="text-xs font-medium text-gray-500 uppercase">Visit date:</span> {{ $visit->visitDate->format('M j, Y') }}</div>
                <div>Posted {{ $visit->postingDate->diffForHumans() }}</div>
            </div>

        </div>
    </a>
</div>
