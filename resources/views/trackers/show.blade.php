<x-layouts.app>
    <div class="p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-4">
        <div class="max-w-6xl mx-auto">

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-4 sm:mb-6">
                <div class="flex flex-col-2 justify-between space-x-3">
                    <flux:button variant="ghost" icon="arrow-left" :href="route('trackers.index')">Back</flux:button>
                    <flux:separator vertical class="my-2" variant="subtle"/>
                    <h1 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ __('Tracker Details') }}</h1>
                </div>

                <div class="flex flex-col sm:flex-row gap-2">
                    @if ($tracker->status === 'pending' && auth()->user()->id === $tracker->user_id)
                      <flux:modal.trigger name="edit-tracker">
                            <flux:button icon="pencil" variant="primary">Edit</flux:button>
                        </flux:modal.trigger>



                               <flux:modal.trigger name="delete-tracker">
                                     <flux:button variant="danger" icon="trash">
                                        Delete
                                    </flux:button>
                               </flux:modal.trigger>
                    @endif

                </div>

            </div>

            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 sm:p-6">
                <div>
                     <h3 class="text-xs sm:text:sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Tracker Type') }}</h3>
                <p class="mt-1 text-base sm:text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $tracker->trackerTypes->name }}</p>
                </div>

                <div>
                    <h3 class="text-xs sm:text:sm font-medium text-zinc-500 dark:text-zinc-400 mt-2">{{ __('Status') }}</h3>
                    <p class="mt-1">
                        @if($tracker->status === 'pending')
                            <span class="px-2 sm:px-3 py-1 text-xs sm:text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 inline-block">
                                {{ __('Pending Review') }}

                            </span>
                        @elseif ($tracker->status === 'reviewed')
                             <span class="px-2 sm:px-3 py-1 text-xs sm:text-sm font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 inline-block">
                                {{ __('Reviewed') }}

                            </span>

                        @else
                             <span class="px-2 sm:px-3 py-1 text-xs sm:text-sm font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 inline-block">
                                {{ __('Reviewed') }}
                            </span>
                        @endif
                    </p>
                </div>

                <div class="sm:col-span-2 mt-2">
                     <h3 class="text-xs sm:text:sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('File Name') }}</h3>
                    <p class="mt-1 text-sm sm:text-base text-zinc-900 dark:text-zinc-100 break-all">{{ $tracker->original_filename }}</p>
                </div>
                <div class="sm:col-span-2 mt-2">
                     <h3 class="text-xs sm:text:sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Submission Date') }}</h3>
                    <p class="mt-1 text-sm sm:text-base text-zinc-900 dark:text-zinc-100">{{ $tracker->submission_date->format('d F, Y') }}</p>
                </div>
                <div class="sm:col-span-2 mt-2">
                     <h3 class="text-xs sm:text:sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Date From - Date To') }}</h3>
                    <p class="mt-1 text-sm sm:text-base text-zinc-900 dark:text-zinc-100">{{ $tracker->period_start->format('M d, Y') }} - {{$tracker->period_end->format('M d, Y')  }}</p>
                </div>



                @if($tracker->reviewed_at)

                @endif


            </div>
        </div>

    </div>






    <flux:modal name="delete-tracker" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete tracker?</flux:heading>
            <flux:text class="mt-2">
                You're about to delete this tracker.<br>
                This action cannot be reversed.
            </flux:text>
        </div>
        <div class="flex gap-2">
            <flux:spacer />
            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>

             <form action="{{ route('trackers.destroy', $tracker) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <flux:button type="submit" variant="danger">Delete project</flux:button>
                        </form>

        </div>
    </div>
</flux:modal>
</x-layouts.app>
