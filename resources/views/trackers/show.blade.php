<x-layouts.app>
    <div class="p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-4">
        <div class="max-w-6xl mx-auto">

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-4 sm:mb-6">
                <div class="flex flex-col-2 justify-between space-x-3">
                    <flux:button variant="ghost" icon="arrow-left" :href="route('trackers.index')">Back</flux:button>
                    <flux:separator vertical class="my-2" variant="subtle" />
                    <h1 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ __('Tracker Details')
                        }}</h1>
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

            <div class="bg-white dark:bg-zinc-900 border  border-zinc-200 dark:border-zinc-700 rounded-lg p-4 sm:p-6">
                <div>
                    <h3 class="text-xs sm:text:sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Tracker Type') }}
                    </h3>
                    <p class="mt-1 text-base sm:text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{
                        $tracker->trackerTypes->name }}</p>
                </div>

                <div>
                    <h3 class="text-xs sm:text:sm font-medium text-zinc-500 dark:text-zinc-400 mt-2">{{ __('Status') }}
                    </h3>
                    <p class="mt-1">
                        @if($tracker->status === 'pending')
                        <span
                            class="px-2 sm:px-3 py-1 text-xs sm:text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 inline-block">
                            {{ __('Pending Review') }}

                        </span>
                        @elseif ($tracker->status === 'reviewed')
                        <span
                            class="px-2 sm:px-3 py-1 text-xs sm:text-sm font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 inline-block">
                            {{ __('Reviewed') }}

                        </span>

                        @else
                        <span
                            class="px-2 sm:px-3 py-1 text-xs sm:text-sm font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 inline-block">
                            {{ __('Reviewed') }}
                        </span>
                        @endif
                    </p>
                </div>

                <div class="sm:col-span-2 mt-2">
                    <h3 class="text-xs sm:text:sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('File Name') }}
                    </h3>
                    <div class="mt-2 flex flex-col sm:flex-row gap-2 sm:items-center">
                        <p class="mt-1 text-sm sm:text-base text-zinc-900 dark:text-zinc-100 break-all">{{
                            $tracker->original_filename }}</p>

                        <div class="flex gap-2">
                            @php
                            $extension = pathinfo($tracker->original_filename, PATHINFO_EXTENSION);
                            $isPdf = strtolower($extension) === 'pdf';
                            @endphp

                            @if($isPdf)
                            <flux:modal.trigger name="preview-file">
                                <flux:button variant="outline" size="sm" icon="eye">
                                    {{ __('Preview') }}
                                </flux:button>
                            </flux:modal.trigger>

                            @endif

                            <flux:button variant="primary" size="sm" icon="arrow-down-tray"
                                :href="route('trackers.download', $tracker)" target="_blank">
                                {{ __('Download') }}
                            </flux:button>

                        </div>

                    </div>

                </div>
                <div class="sm:col-span-2 mt-2">
                    <h3 class="text-xs sm:text:sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Submission Date')
                        }}</h3>
                    <p class="mt-1 text-sm sm:text-base text-zinc-900 dark:text-zinc-100">{{
                        $tracker->submission_date->format('d F, Y') }}</p>
                </div>
                <div class="sm:col-span-2 mt-2">
                    <h3 class="text-xs sm:text:sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Date From - Date
                        To') }}</h3>
                    <p class="mt-1 text-sm sm:text-base text-zinc-900 dark:text-zinc-100">{{
                        $tracker->period_start->format('M d, Y') }} - {{$tracker->period_end->format('M d, Y') }}</p>
                </div>



                @if($tracker->reviewed_at)
                <div>
                    <h3 class="text-xs sm:text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Reviewed Date')
                        }}</h3>
                    <p class="mt-1 text-sm sm:text-base text-zinc-900 dark:text-zinc-100">{{
                        $tracker->reviewed_at->format('d F, Y') }}</p>
                </div>
                @endif
                @if($tracker->reviewer)
                <div>
                    <h3 class="text-xs sm:text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Reviewed By') }}
                    </h3>
                    <p class="mt-1 text-sm sm:text-base text-zinc-900 dark:text-zinc-100">{{ $tracker->reviewer->name}}
                    </p>
                </div>
                @endif

                @if($tracker->notes)
                <div class="mt-4">
                    <h3 class="text-xs sm:text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ __('Tracker Notes')
                        }}</h3>
                    <p class="mt-2 text-sm sm:text-base text-zinc-900 dark:text-zinc-100 whitespace-pre-wrap">{{
                        $tracker->notes }}</p>
                </div>

                @endif

                @if ($tracker->coordinator_notes)
                <div
                    class="mt-4 sm:mt-6 p-3 sm:p-4 bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                    <h3 class="text-xs sm:text-sm font-medium text-blue-900 dark:text-blue-300">{{ __('Coordinator
                        Feedback') }}</h3>
                    <p class="mt-2 text-sm sm:text-base text-blue-800 dark:text-blue-200 whitespace-pre-wrap">{{
                        $tracker->coordinator_notes }}</p>

                </div>

                @endif


            </div>
        </div>

    </div>

    @if ($tracker->status === 'pending' && auth()->user()->id === $tracker->user_id)

    <flux:modal name="edit-tracker" class="md:w-[600px] space-y-6">
        <div>
            <flux:heading size="lg">{{ __('Edit Tracker') }}</flux:heading>
            <flux:subheading>{{ __('Update the details of your tracker submission.') }}</flux:subheading>

            <form action="{{ route('trackers.update', $tracker) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <flux:field>
                    <flux:label>{{ __('Tracker Type') }}</flux:label>
                    <flux:select name="tracker_type_id" required>
                        <option value="">{{ __('Select tracker type ') }}</option>
                        @foreach ($trackerTypes as $type )
                        <option value="{{ $type->id }}" {{ (old('tracker_type_id', $tracker->tracker_type_id) ==
                            $type->id) ? 'selected' : '' }}>
                            {{ $type->name }} ({{ ucfirst($type->frequency) }})

                        </option>

                        @endforeach

                    </flux:select>
                    @error('tracker_type_id')
                    <flux:error>{{ $message }}</flux:error>
                    @enderror

                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Current File') }}</flux:label>
                    <flux:description class="break-all">{{ $tracker->original_filename }}</flux:description>
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Replace File (Optional)') }}</flux:label>
                    <input type="file" name="file" id="edit-file" accept=".pdf, .doc,.docx," class="block w-full text-sm text-zinc-500 dark:text-zinc-400
                            file:mr-4 file:py-2 file:px-4
                              file:rounded-lg file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100
                        dark:file:bg-blue-900 dark:file:text-blue-300
                        dark:hover:file:bg-blue-800">
                    <flux:description>
                        {{ __('Leave empty to keep current file. Accepted PDF, DOC, DOCX (Max: 10MB)') }}
                    </flux:description>
                    @error('file')
                    <flux:error>{{ $message }}</flux:error>
                    @enderror

                </flux:field>


                <flux:field>
                    <flux:label>{{ __('Start Date') }}</flux:label>
                    <flux:input type="date" name="period_start"
                        :value="old('period_start', $tracker->period_start->format('d-m-Y'))" required />
                    @error('period_start')
                    <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('End Date') }}</flux:label>
                    <flux:input type="date" name="period_start"
                        :value="old('period_end', $tracker->period_start->format('d-m-Y'))" required />
                    @error('period_end')
                    <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Notes (Optional)') }}</flux:label>
                    <flux:textarea name="notes" rows="3"
                        placeholder="{{ __('Add any additional notes or comments...') }}">
                        {{ old('notes', $tracker->notes) }}
                        @error('notes')
                        <flux:error>{{ $message }}</flux:error>
                        @enderror
                    </flux:textarea>
                </flux:field>


                <div class="flex justify-end gap-2">
                    <flux:button variant="ghost" x-on:click="$flux.modal('edit-tracker').close()">
                        {{ __('Cancel') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        {{ __('Update Tracker') }}

                    </flux:button>

                </div>


            </form>
        </div>

    </flux:modal>

    @endif




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

    @php
    $extension = pathinfo($tracker->original_filename, PATHINFO_EXTENSION);
    $isPdf = strtolower($extension) === 'pdf';
    @endphp

    @if($isPdf)
    <flux:modal name="preview-file" class="w-full max-w-6xl h-[90vh]">
        <div class="flex flex-col h-full">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <flux:heading size="lg">{{ __('File Preview') }}</flux:heading>
                    <flux:subheading>{{ $tracker->original_filename }}</flux:subheading>
                </div>

                <div class="flex gap-2">
                    <flux:button variant="primary" size="sm" icon="arrow-down-tray"
                        :href="route('trackers.download', $tracker)" target="_blank" class="mt-6">
                    </flux:button>
                </div>



            </div>

            <div class="flex-1 min-h-0 border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden
                ">
                <iframe src="{{ route('trackers.download', $tracker) }}" class="w-full h-full" frameborder="0">
                    <p>
                        {{ __('Your Browser doeas not support PDF preview') }}
                        <a href="{{ route('trackers.download', $tracker) }}" class="text-blue-600 hover:text-blue-800">
                            {{ __('Download the file ') }}
                        </a>
                    </p>
                </iframe>


            </div>

        </div>

    </flux:modal>
    @endif

    @push('scripts')
    <script>
        @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function(){
            window.$flux.modal('edit-tracker').show();
        });

        @endif
    </script>

    @endpush
</x-layouts.app>
