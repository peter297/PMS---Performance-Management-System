<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
           @include('partials.head')

            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

          <style>
            .dataTables_wrapper {
                padding: 1rem 0;
            }

            .dataTables_filter input {
                border: 1px solid #52525b;
                border-radius: 0.5rem;
                padding: 0.5rem 0.75rem;
                margin-left: 0.5rem;
                background: #27272a;
                color: #fafafa;
                margin-bottom: 10px;
            }

            .dataTables_length select {
                border: 1px solid #52525b;
                border-radius: 0.5rem;
                padding: 0.5rem 0.75rem;
                margin: 0 0.5rem;
                background: #27272a;
                color: #fafafa;
            }

            table.dataTable thead th {
                background-color: #f1f1f1;
                border-bottom: 2px solid #3f3f46;
                padding: 0.75rem 1rem;
                font-weight: 600;
                color: #000000;
            }

            table.dataTable tbody td {
                padding: 0.75rem 1rem;
                border-bottom: 1px solid #3f3f46;
            }

            table.dataTable tbody tr:hover {
                background-color: rgba(255, 255, 255, .1)
            }

            .dataTables_paginate .paginate_button {
                padding: 0.5rem 0.75rem;
                margin: 0 0.25rem;
                border-radius: 0.375rem;
                border: 1px solid #52525b;
                color: #fafafa !important;
            }

            .dataTables_paginate .paginate_button.current {
                background: #3b82f6 !important;
                color: white !important;
                border-color: #939ba7;
            }

            .dataTables_paginate .paginate_button:hover {
                background: #58a873 !important;
                border-color: #52525b;
                color: #333131 !important;
            }

            .dataTables_info {
                color: #6b6b72;
            }
        </style>

        @stack('styles')

    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">

                <flux:navlist.group :heading="__('Platform')" class="grid">

                @if(auth()->check())
                    @if(auth()->user()->isTeacher())
                    <flux:navlist.item icon="home" :href="route('teacher.dashboard')" :current="request()->routeIs('teacher.dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:navlist.item>
                   <flux:spacer></flux:spacer>
                    <flux:navlist.item icon="arrow-up-right" :href="route('trackers.index')" :current="request()->routeIs('trackers.*')" wire:navigate>
                        {{ __('My Trackers') }}
                    </flux:navlist.item>

                     <flux:navlist.item icon="arrow-trending-up" wire:navigate>
                        {{ __('My Performance') }}
                    </flux:navlist.item>

                    @elseif (auth()->user()->isCoordinator())


                    @elseif (auth()->user()->isAdmin())
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="arrow-trending-up" :href="route('admin.trackers')" :current="request()->routeIs('admin.trackers')" wire:navigate>{{ __('All Trackers') }}</flux:navlist.item>
                    <flux:navlist.item icon="wrench" :href="route('admin.tracker-types')" :current="request()->routeIs('admin.tracker-types')" wire:navigate>{{ __('Trackers Types') }}</flux:navlist.item>
                    <flux:navlist.item icon="user" :href="route('admin.users')" :current="request()->routeIs('admin.users')" wire:navigate>{{ __('Users') }}</flux:navlist.item>

                    @endif

                @endif




                    {{-- <flux:navlist.item icon="user" :href="route('dashboard')"  wire:navigate>{{ __('Users') }}</flux:navlist.item> --}}
                </flux:navlist.group>


            </flux:navlist>





            <flux:spacer />

            @include('partials.theme')



            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts

        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

        @stack('scripts')
    </body>
</html>
