
<x-layouts.app>

    <div class="p-4 sm:p-6 lg:p-8 space-x-4 sm:space-x-6">

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ __('Dashboard') }}</h1>
            {{-- <a href="{{ route('trackers.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-150 ease-in-out text-sm sm:text-base">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Upload New Tracker') }}
            </a> --}}

             <flux:modal.trigger name="create-tracker">
                <flux:button icon="plus" variant="primary">Upload New Tracker</flux:button>
            </flux:modal.trigger>

        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mt-4">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 sm:p-6">
                <div class="text-center">
                    <div class="text-2xl sm:text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['total_submissions'] }}</div>
                    <div class="text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 mt-1 sm:mt-2">{{ __('Total Submissions') }}</div>

                </div>
            </div>
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 sm:p-6">
                <div class="text-center">
                    <div class="text-2xl sm:tex-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['pending'] }}</div>
                    <div class="text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 mt-1 sm:mt-2">{{ __('Pending') }}</div>

                </div>
            </div>
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 sm:p-6">
                <div class="text-center">
                    <div class="text-2xl sm:tex-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['reviewed'] }}</div>
                    <div class="text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 mt-1 sm:mt-2">{{ __('Reviewed') }}</div>

                </div>
            </div>
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 sm:p-6">
                <div class="text-center">
                    <div class="text-2xl sm:tex-3xl font-bold text-red-600 dark:text-red-400">{{ $stats['rejected'] }}</div>
                    <div class="text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 mt-1 sm:mt-2">{{ __('Rejected') }}</div>

                </div>
            </div>

        </div>

        {{-- Recent Trackers --}}

        <div class="bg-white dark:bg-zinc-900 border mt-4 border-zinc-200 dark:border-zinc-700 rounded-lg p-4 sm:p-6">
            <h2 class="text-lg sm:text-xl font-semibold text-zinc-900 dark:text-zink-100 mb-3 sm:mb-4">{{ __('Recent Submissions') }}</h2>

            @if($recentTrackers->count()>0)
                {{-- Mobile view --}}

            <div class="block lg:hidden space-y-3">
                @foreach ($recentTrackers as $tracker )
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 space-y-2">
                    <div class="flex justify-between items-start">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-medium text-zinc-900 dark:text-zinc-100 text-sm">{{ $tracker->trackerTypes->name }}</h3>
                            <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">
                                {{ $tracker->period_start }} - {{ $tracker->period_end }}
                            </p>

                        </div>

                        @if ($tracker->status === 'pending')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 whitespace-nowrap ml-2">
                                {{ __('Pending') }}
                            </span>
                        @elseif ($tracker->status === 'reviewed')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 whitespace-nowrap ml-2">
                                {{ __('Reviewed') }}
                            </span>
                        @else
                             <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 whitespace-nowrap ml-2">
                                {{ __('Rejected') }}
                            </span>
                        @endif

                    </div>

                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                        {{ __('Submitted') }} {{ $tracker->submission_date }}

                    </div>

                    <div class="pt-2">
                        <a href="{{ route('trackers.show', $tracker) }}">
                            {{ __('View Details »') }}
                        </a>

                    </div>

                </div>

                @endforeach

            </div>

            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('Tracker Type') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('Period') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('Submitted') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('Status') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach ($recentTrackers as $tracker )
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $tracker->trackerTypes->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-600 dark:text-zinc-400">
                                {{ $tracker->period_start }} - {{ $tracker->period_end}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-600 dark:text-zinc-400">
                                {{ $tracker->submission_date }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($tracker->status === 'pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        {{ __('Pending') }}
                                    </span>
                                @elseif ($tracker->status === 'reviewed')
                                     <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        {{ __('Reviewed') }}
                                    </span>
                                @else
                                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        {{ __('Reviewed') }}
                                    </span>
                                @endif

                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('trackers.show', $tracker) }}"
                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:text-blue-300">{{ __('View') }}</a>

                            </td>
                        </tr>

                        @endforeach

                    </tbody>

                </table>


            </div>
            @else
            <p class="text-sm text-center sm:text-base text-zinc-600 dark:text-zinc-400">
                {{ __('No submissions yet.') }}

                <a href="{{ route('trackers.create') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                    {{ __('Upload a Tracker') }}
                </a>
            </p>

            @endif

        </div>

    </div>


    <flux:modal name="create-tracker" class="md:w-[600px] space-y-6">
        <div>
            <flux:heading size="lg">{{ __('Upload New Tracker') }}</flux:heading>
            <flux:subheading>{{ __('Fill in the detail below to upload a new tracker.') }}</flux:subheading>
        </div>

        <form action="{{ route('trackers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- <flux:field>
                <flux:label>{{ __('Tracker Type') }}</flux:label>
                <flux:select name="tracker_type_id" required>
                    <option value="">{{ __('Select tracker type') }}</option>
                    @foreach ($trackerTypes as $type )
                        <option value="{{ $type->id }}" {{ old('tracker_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }} {{ ucfirst($type->frequency) }}
                        </option>
                    @endforeach
                </flux:select>
                @error('tracker_type_id')
                    <flux:error>{{ $message }}</flux:error>
                @enderror

            </flux:field> --}}

            <flux:field>
                <flux:label>{{ __('Upload File') }}</flux:label>
                <input
                type="file"
                name="file"
                id="file"
                accept=".pdf, .doc, .docx"
                class="block w-full text-sm text-zinc-500 dark:text-zinc-400
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100
                        dark:file:bg-blue-900 dark:file:text-blue-300
                        dark:hover:file:bg-blue-800"
                    required
                >
                <flux:description>{{ __('Accepted Formats: PDF, DOC, DOCX (Max: 10MB)') }}</flux:description>
                @error('file')
                <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Start Date') }}</flux:label>
                <flux:input type="date" name="period_start" :value="old('period_start')" required/>
                @error('period_start')
                <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>

            <flux:field>
                <flux:label>{{ __('End Date') }}</flux:label>
                <flux:input type="date" name="period_end" :value="old('period_end')" required/>
                @error('period_end')
                <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Notes (Optional)') }}</flux:label>
                <flux:textarea name="notes" rows="3" placeholder="{{ __('Add any additional notes or comments') }}">{{ old('notes') }}</flux:textarea>
                @error('notes')
                <flux:error>{{ $message }}</flux:error>
                @enderror
            </flux:field>

            <div class="flex justify-end gap-2">
                <flux:button variant="ghost" x-on:click="$flux.modal('create-tracker').close()">
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button type="submit" variant="primary">
                    {{ __('Submit') }}

                </flux:button>

            </div>


        </form>

    </flux:modal>

</x-layouts.app>


