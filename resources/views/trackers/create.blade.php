
<x-layouts.app>
    <div class="p-6 lg:p-8 space-y-6 max-w-4xl">
        <!-- Page Header -->
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ __('Upload New Tracker') }}</h1>
            <a href="{{ route('trackers.index') }}" class="inline-flex items-center px-4 py-2 bg-zinc-200 hover:bg-zinc-300 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-zinc-900 dark:text-zinc-100 font-semibold rounded-lg transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('Back to List') }}
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-6">
            <form action="{{ route('trackers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Tracker Type -->
                <div>
                    <label for="tracker_type_id" class="block text-sm font-medium text-zinc-900 dark:text-zinc-100 mb-2">
                        {{ __('Tracker Type') }} <span class="text-red-600">*</span>
                    </label>
                    <select
                        name="tracker_type_id"
                        id="tracker_type_id"
                        class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                        <option value="">{{ __('Select tracker type') }}</option>
                        @foreach($trackerTypes as $type)
                            <option value="{{ $type->id }}" {{ old('tracker_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }} ({{ ucfirst($type->frequency) }})
                            </option>
                        @endforeach
                    </select>
                    @error('tracker_type_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Upload -->
                <div>
                    <label for="file" class="block text-sm font-medium text-zinc-900 dark:text-zinc-100 mb-2">
                        {{ __('Upload File') }} <span class="text-red-600">*</span>
                    </label>
                    <input
                        type="file"
                        name="file"
                        id="file"
                        accept=".pdf,.doc,.docx,.xls,.xlsx"
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
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Accepted formats: PDF, DOC, DOCX, XLS, XLSX (Max: 10MB)') }}</p>
                    @error('file')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Period Start -->
                <div>
                    <label for="period_start" class="block text-sm font-medium text-zinc-900 dark:text-zinc-100 mb-2">
                        {{ __('Period Start Date') }} <span class="text-red-600">*</span>
                    </label>
                    <input
                        type="date"
                        name="period_start"
                        id="period_start"
                        value="{{ old('period_start') }}"
                        class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                    @error('period_start')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Period End -->
                <div>
                    <label for="period_end" class="block text-sm font-medium text-zinc-900 dark:text-zinc-100 mb-2">
                        {{ __('Period End Date') }} <span class="text-red-600">*</span>
                    </label>
                    <input
                        type="date"
                        name="period_end"
                        id="period_end"
                        value="{{ old('period_end') }}"
                        class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                    @error('period_end')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-zinc-900 dark:text-zinc-100 mb-2">
                        {{ __('Notes (Optional)') }}
                    </label>
                    <textarea
                        name="notes"
                        id="notes"
                        rows="4"
                        class="w-full rounded-lg border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:border-blue-500 focus:ring-blue-500"
                        placeholder="{{ __('Add any additional notes or comments...') }}"
                    >{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('trackers.index') }}" class="inline-flex items-center px-4 py-2 bg-zinc-200 hover:bg-zinc-300 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-zinc-900 dark:text-zinc-100 font-semibold rounded-lg transition duration-150 ease-in-out">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-150 ease-in-out">
                        {{ __('Submit Tracker') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
