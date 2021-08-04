<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Visit Details
        </h2>
    </x-slot>

    <div class="space-y-6">

        {{-- Visit Details --}}
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                {{-- Agency Name --}}
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $visit->agencyName }}
                </h3>
                {{-- Address --}}
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    {{ $visit->jobAddress }}
                </p>
            </div>

            <div class="border-t border-gray-200">
                <dl>
                    {{-- Discipline --}}
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Discipline
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $visit->discipline }}
                        </dd>
                    </div>

                    {{-- Job Type --}}
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Job Type
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $visit->jobType }} Job
                        </dd>
                    </div>

                    {{-- Discipline Task --}}
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Discipline Task
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $visit->disciplineTask }}
                        </dd>
                    </div>

                    {{-- Specialty --}}
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Specialty
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $visit->speciality }}
                        </dd>
                    </div>

                    {{-- Rates --}}
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Rates
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <x-rates :visit="$visit">
                                <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">

                                    @if ($component->disciplineOneVisitRate())
                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                        <div class="w-0 flex-1 flex items-center">
                                            <!-- Heroicon name: outline/currency-dollar -->
                                            <svg class="flex-shrink-0 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="ml-2 flex-1 w-0 truncate">
                                                Visit Rate {{ $component->disciplineOneLabel() }}
                                            </span>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <span class="font-medium text-green-600">
                                                ${{ $component->disciplineOneVisitRate() }}
                                            </span>
                                        </div>
                                    </li>
                                    @endif

                                    @if ($component->disciplineTwoVisitRate())
                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                        <div class="w-0 flex-1 flex items-center">
                                            <!-- Heroicon name: outline/currency-dollar -->
                                            <svg class="flex-shrink-0 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="ml-2 flex-1 w-0 truncate">
                                                Visit Rate {{ $component->disciplineTwoLabel() }}
                                            </span>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <span class="font-medium text-green-600">
                                                ${{ $component->disciplineTwoVisitRate() }}
                                            </span>
                                        </div>
                                    </li>
                                    @endif

                                    @if ($component->disciplineOneCustomRate())
                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                        <div class="w-0 flex-1 flex items-center">
                                            <!-- Heroicon name: outline/currency-dollar -->
                                            <svg class="flex-shrink-0 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="ml-2 flex-1 w-0 truncate">
                                                Custom Rate {{ $component->disciplineOneLabel() }}
                                            </span>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <span class="font-medium text-green-600">
                                                ${{ $component->disciplineOneCustomRate() }}
                                            </span>
                                        </div>
                                    </li>
                                    @endif

                                    @if ($component->disciplineTwoCustomRate())
                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                        <div class="w-0 flex-1 flex items-center">
                                            <!-- Heroicon name: outline/currency-dollar -->
                                            <svg class="flex-shrink-0 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="ml-2 flex-1 w-0 truncate">
                                                Custom Rate {{ $component->disciplineTwoLabel() }}
                                            </span>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <span class="font-medium text-green-600">
                                                ${{ $component->disciplineTwoCustomRate() }}
                                            </span>
                                        </div>
                                    </li>
                                    @endif

                                    @if (! $component->hasRates())
                                    <li class="pl-3 pr-4 py-3 text-sm">
                                        <div class="flex items-center">
                                            <!-- Heroicon name: outline/currency-dollar -->
                                            <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="ml-2 flex-1 w-0 truncate">
                                                No Rates Available
                                            </span>
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </x-rates>
                        </dd>
                    </div>

                    {{-- Visit Date --}}
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Visit Date
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{$visit->visitDate->format('M d, Y')}}
                        </dd>
                    </div>

                    {{-- Visit Details --}}
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Visit Details
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $visit->jobDescription ?: 'N/A' }}
                        </dd>
                    </div>

                    {{-- Special Instructions --}}
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Special Instructions
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $visit->jobComments ?: 'N/A' }}
                        </dd>
                    </div>

                </dl>
            </div>

        </div>

        {{-- Visit Notes --}}
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <livewire:update-visit-note :jobId="$visit->jobId">
        </div>

        {{-- Clinicians --}}
        <div>
            <div class="text-sm text-gray-500 mb-2">
                Found {{ count($clinicians) }} related clinicians
            </div>

            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                               Job Stats
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Distance
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
                        @forelse ($clinicians as $clinician)
                        <tr class="cursor-pointer hover:bg-gray-50">    <!-- TODO link to clinician -->
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
                                            {{ $clinician->phoneNumber ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Role --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $clinician->role ?? 'No Role Found' }}
                            </td>

                            {{-- Jobs Applied / Completed --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Completed: {{ $clinician->completedJobsCount }}</div>
                                <div class="text-sm text-gray-500">Applied: {{ $clinician->appliedJobsCount }}</div>
                            </td>

                            {{-- Distance from clinician --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($clinician->distanceFromClinician < 10)
                                <x-badge text="text-green-800" bg="bg-green-100">{{ $clinician->distanceFromClinician }} miles</x-badge>
                                @else
                                <x-badge text="text-pink-800" bg="bg-pink-100">{{ $clinician->distanceFromClinician }} miles</x-badge>
                                @endif
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
</x-app-layout>
