<nav x-data="{ open: false }" class="bg-green-500">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">

            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <!-- Mobile menu button-->
                <button type="button" @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-green-300 hover:text-white hover:bg-green-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>

                    <svg :class="{'hidden': open, 'block': ! open }" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <svg :class="{'hidden': ! open, 'block': open }" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                <a href="{{ route('home') }}">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="block lg:hidden h-8 w-auto" src="{{ asset('images/axxess-icon-white.png') }}" alt="Visit Fulfillment">
                        <img class="hidden lg:block h-8 w-auto" src="{{ asset('images/visit-fulfillment-logo-white.png') }}" alt="Visit Fulfillment">
                    </div>
                </a>

                <div class="hidden sm:block sm:ml-6">
                    <div class="flex space-x-4">
                        <x-nav.link :href="route('visits.index')" :active="request()->routeIs('visits.*')">
                            Visits
                        </x-nav.link>
                        <x-nav.link :href="route('clinicians.index')" :active="request()->routeIs('clinicians.*')" >
                            Clinicians
                        </x-nav-link>
                        <x-nav.link :href="route('agency.index')" :active="request()->routeIs('agency.index')" >
                            Agency
                        </x-nav-link>
                    </div>
                </div>
            </div>

            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <!-- Profile dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="bg-green-500 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-500 focus:ring-white" id="user-menu" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <x-profile-badge name="{{ Auth::user()->name }}"></x-profile-badge>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown.item href="#">My Follow-ups</x-dropdown.item>
                        <x-dropdown.item href="#">Statistics</x-dropdown.item>
                        <x-dropdown.item href="#">User Management</x-dropdown.item>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown.item :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                Sign out
                            </x-dropdown.item>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <x-nav.responsive-link :href="route('visits.index')" :active="request()->routeIs('visits.index')">
                Visit Overview
            </x-nav.responsive-link>
            <x-nav.responsive-link :href="route('home')" :active="request()->routeIs('home')">
                Returned Visits
            </x-nav.responsive-link>
            <x-nav.responsive-link :href="route('home')" :active="request()->routeIs('home')">
                Pending Acceptance
            </x-nav.responsive-link>
            <x-nav.responsive-link :href="route('clinicians.index')" :active="request()->routeIs('clinicians.index')">
                Clinicians
            </x-nav.responsive-link>
        </div>
    </div>

</nav>
