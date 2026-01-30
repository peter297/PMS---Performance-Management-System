<x-layouts.app>
    <div class="p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ __('Coordinator Dashboard')
                }}</h1>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
            <div class="bg-white dark:bg-zinc-900 border-zinc-100 dark:border-zinc-700 rounded-lg p-4 sm:p-6">
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-blue-600 dark:text-blue-400">{{
                        $stats['total_teachers'] }}</div>
                    <div class="text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 mt-1 sm:mt-2">{{ __('Total
                        Teachers') }}</div>

                </div>

            </div>
            <div class="bg-white dark:bg-zinc-900 border-zinc-100 dark:border-zinc-700 rounded-lg p-4 sm:p-6">
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-purple-600 dark:text-purple-400">{{
                        $stats['total_submissions'] }}</div>
                    <div class="text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 mt-1 sm:mt-2">{{ __('Total
                        Submissions') }}</div>

                </div>

            </div>
            <div class="bg-white dark:bg-zinc-900 border-zinc-100 dark:border-zinc-700 rounded-lg p-4 sm:p-6">
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{
                        $stats['pending_review'] }}</div>
                    <div class="text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 mt-1 sm:mt-2">{{ __('Pending
                        Review') }}</div>

                </div>

            </div>
            <div class="bg-white dark:bg-zinc-900 border-zinc-100 dark:border-zinc-700 rounded-lg p-4 sm:p-6">
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['reviewed']
                        }}</div>
                    <div class="text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 mt-1 sm:mt-2">{{ __('Reviewed') }}
                    </div>

                </div>

            </div>

            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 sm:p-6">
                <div class="flex justify-between items-center w-full">
                    <h2 class="text-lg sm:text-xl font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Recent
                        Submissions') }}</h2>
                    <flux:button variant="primary" size="sm" :href="route('coordinator.trackers')">
                        {{ __('View All') }}
                    </flux:button>

                </div>

                @if($recentTrackers->count() > 0)

                <div class="block lg:hidden space-y-3">
                    @foreach ($recentTrackers as $tracker)
                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 space-y-2">
                        <div class="flex justify-between items-start">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-zinc-900 dark:text-zinc-100 text-sm">{{ $tracker->user->name
                                    }}</h3>
                                <p>{{ $tracker->trackerType->name }}</p>
                            </div>
                            @if($tracker->status === 'pending')
                            <span
                                class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 whitespace-nowrap ml-2">
                                {{ __('Pending') }}
                            </span>
                            @elseif($tracker->status === 'reviewed')
                            <span
                                class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 whitespace-nowrap ml-2">
                                {{ __('Reviewed') }}
                            </span>
                            @else
                            <span
                                class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 whitespace-nowrap ml-2">
                                {{ __('Rejected') }}
                            </span>

                            @endif

                        </div>

                        <div class="text-xs text-zinc-500 dark:text-zinc-400">
                            {{ __('Submitted:') }} {{ $tracker->submission_date->format('M d, Y') }}

                        </div>

                        <div class="pt-2 flex gap-2">
                           <flux:modal.trigger name="review-tracker">
                            <flux:button variant="primary">{{ $tracker->status === 'pending' ? __('Review->') : __('View->') }}</flux:button>
                           </flux:modal.trigger>

                        </div>

                    </div>

                    @endforeach

                </div>

                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{{__('Teacher')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{{__('Tracker Type')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{{__('Term')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{{__('Submitted')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{{__('Status')}}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{{__('Actions')}}</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach ($recentTrackers as $tracker )

                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $tracker->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">{{ $tracker->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">{{ $tracker->trackerType->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">{{ $tracker->period_start->format('M d') }} - {{ $tracker->period_end->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">{{ $tracker->period_start->format('M d') }} - {{ $tracker->submission_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($tracker->status === 'pending')

                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            {{ __('Pending') }}
                                        </span>
                                        @elseif ($tracker->status === 'reviewed')
                                             <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            {{ __('Reviewed') }}
                                        </span>

                                        @else
                                              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            {{ __('Rejected') }}
                                        </span>

                                        @endif

                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                @endif

            </div>



        </div>
</x-layouts.app>
