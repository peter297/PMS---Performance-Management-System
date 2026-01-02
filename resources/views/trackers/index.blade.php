<x-layouts.app>
    <div class="p-4 sm:p-6 lg:p-8 space-y-4 sm:space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ __('My Trackers') }}</h1>
            {{-- <flux:button icon="plus" variant="primary" x-on:click="$flux.modal('create-tracker').show()">
                {{ __('Upload New Tracker') }}
            </flux:button> --}}

            <flux:modal.trigger name="create-tracker">
                <flux:button icon="plus" variant="primary">Upload New Tracker</flux:button>
            </flux:modal.trigger>
        </div>

        {{-- <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 sm:p-6"> --}}
            <div class="sm:overflow-x-auto -mx-4 sm:mx-0">
                <div class="inline-block min-w-full align-middle">
                    <table id="trackersTable" class="min-w-full  display responsive nowrap mt-2" style="width: 100%">
                        <thead>

                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Tracker Type') }}</th>
                                <th>{{ __('File Name') }}</th>
                                <th>{{ __('Date From - Date To') }}</th>
                                <th>{{ __('Submitted') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>

                        </thead>

                        <tbody>
                            @foreach ($trackers as $tracker)
                            <tr>
                                <td>{{ $tracker->id }}</td>
                                <td>{{ $tracker->trackerTypes->name }}</td>
                                <td class="max-w-[200px] truncate">
                                    <a href="" download>
                                         {{ $tracker->original_filename }}</td>
                                    </a>
                                <td>{{ $tracker->period_start }} - {{ $tracker->period_end }}</td>
                                <td>{{ $tracker->submission_date}}</td>
                                <td>
                                    @if($tracker->status === 'pending')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100  text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 whitespace-nowrap">
                                        {{ __( 'Pending' )}}</span>

                                    @elseif($tracker->status === 'reviewed')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 whitespace-nowrap">{{
                                        __('Reviewed') }}</span>
                                    @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 whitespace-nowrap">{{
                                        __('Rejected') }}</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="flex flex-col sm:flex-row gap-2 items-center">
                                        <a href="{{ route('trackers.show', $tracker) }}"
                                            class="text-blue-600 items-center hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 text-sm whitespace-nowrap">{{
                                            __('View') }}

                                        </a>

                                        @if($tracker->status === 'pending')
                                        <a href="{{ route('trackers.edit', $tracker) }}"
                                            class="text-yellow-900 text-center dark:text-yellow-400 hover:bg-yellow-300 text-sm whitespace-nowrap">
                                            {{ __('Edit') }}
                                        </a>

                                        <form action="{{ route('trackers.destroy', $tracker) }}" method="POST"
                                            class="inline"
                                            {{-- onsubmit="return confirm('{{ __('Are you sure you want to delete this tracker?') }}');"> --}}
                                            x-on:click="$flux.modal('confirm').show()"
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600  hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 text-sm whitespace-nowrap">{{
                                                __('Delete') }}</button>
                                        </form>

                                        @endif

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>

            </div>

        {{-- </div> --}}

    </div>

    <flux:modal name="create-tracker" class="md:w-[600px] space-y-6">
        <div>
            <flux:heading size="lg">{{ __('Upload New Tracker') }}</flux:heading>
            <flux:subheading>{{ __('Fill in the detail below to upload a new tracker.') }}</flux:subheading>
        </div>

        <form action="{{ route('trackers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <flux:field>
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

            </flux:field>

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

     @push('scripts')
    <script>
        $(document).ready(function() {
            $('#trackersTable').DataTable({
                responsive: true,
                order: [[0, 'desc']],
                pageLength: 10,
                language: {
                    search: "{{ __('Search:') }}",
                    lengthMenu: "{{ __('Show _MENU_ Per Page') }}",
                    info: "{{ __('Showing _START_ to _END_ of _TOTAL_ trackers') }}",
                    infoEmpty: "{{ __('No trackers available') }}",
                    infoFiltered: "{{ __('(filtered from _MAX_ total trackers)') }}"
                },

                autoWidth: false,
                columnDefs: [
                    { responsivePriority: 1, targets: 1 }, // Tracker Type
                    { responsivePriority: 2, targets: 5 }, // Status
                    { responsivePriority: 3, targets: -1 } // Actions
                ]
            });
        });
    </script>
    @endpush
</x-layouts.app>
