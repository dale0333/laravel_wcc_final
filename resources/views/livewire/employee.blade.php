<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mx-auto mb-8 max-w-2xl text-center">
                <h1 class="text-2xl font-semibold text-gray-900">
                    Employee
                </h1>
                <p class="mt-2 text-sm text-gray-600">
                    Create and manage employee records.
                </p>
            </div>

            <div>
                <form wire:submit="save" novalidate class="overflow-hidden rounded-lg bg-white shadow-xl ring-1 ring-gray-200">
                    <div class="flex items-center justify-between gap-4 border-b border-gray-100 px-8 py-6 lg:px-10">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">
                                {{ $editingEmployeeId ? 'Edit Employee' : 'Add Employee' }}
                            </h2>
                        </div>

                        @if ($editingEmployeeId)
                            <button type="button" wire:click="cancelEdit" class="inline-flex min-h-10 items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2 text-sm font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                                Cancel
                            </button>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 gap-x-8 gap-y-7 p-8 sm:grid-cols-2 lg:p-10">
                        <div>
                            <label for="employeeNumber" class="block text-base font-semibold text-gray-700">
                                Employee Number
                            </label>
                            <input id="employeeNumber" type="text" wire:model.live="employeeNumber" autocomplete="off" class="mt-2 block h-13 w-full rounded-lg border border-gray-300 bg-white px-4 text-base text-gray-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                            @error('employeeNumber')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="position" class="block text-base font-semibold text-gray-700">
                                Position
                            </label>
                            <input id="position" type="text" wire:model.live="position" autocomplete="organization-title" class="mt-2 block h-13 w-full rounded-lg border border-gray-300 bg-white px-4 text-base text-gray-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                            @error('position')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="firstName" class="block text-base font-semibold text-gray-700">
                                First Name
                            </label>
                            <input id="firstName" type="text" wire:model.live="firstName" autocomplete="given-name" class="mt-2 block h-13 w-full rounded-lg border border-gray-300 bg-white px-4 text-base text-gray-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                            @error('firstName')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="lastName" class="block text-base font-semibold text-gray-700">
                                Last Name
                            </label>
                            <input id="lastName" type="text" wire:model.live="lastName" autocomplete="family-name" class="mt-2 block h-13 w-full rounded-lg border border-gray-300 bg-white px-4 text-base text-gray-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                            @error('lastName')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-base font-semibold text-gray-700">
                                Email
                            </label>
                            <input id="email" type="email" wire:model.live="email" autocomplete="email" class="mt-2 block h-13 w-full rounded-lg border border-gray-300 bg-white px-4 text-base text-gray-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                            @error('email')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-base font-semibold text-gray-700">
                                Phone
                            </label>
                            <input id="phone" type="tel" wire:model.live="phone" autocomplete="tel" class="mt-2 block h-13 w-full rounded-lg border border-gray-300 bg-white px-4 text-base text-gray-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                            @error('phone')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="hiredAt" class="block text-base font-semibold text-gray-700">
                                Hire Date
                            </label>
                            <input id="hiredAt" type="date" wire:model.live="hiredAt" autocomplete="off" class="mt-2 block h-13 w-full rounded-lg border border-gray-300 bg-white px-4 text-base text-gray-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                            @error('hiredAt')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 border-t border-gray-100 bg-gray-50 px-8 py-5 lg:px-10">
                        <button type="submit" wire:loading.attr="disabled" class="inline-flex min-h-12 items-center justify-center rounded-lg bg-gray-900 px-8 py-3 text-sm font-semibold uppercase tracking-widest text-white transition hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-indigo-200 disabled:cursor-not-allowed disabled:opacity-60">
                            <span wire:loading.remove wire:target="save">{{ $editingEmployeeId ? 'Update Employee' : 'Add Employee' }}</span>
                            <span wire:loading wire:target="save">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-10 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900">
                        Employees
                    </h3>

                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Employee Number
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Name
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Email
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Position
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Hire Date
                                    </th>
                                    <th scope="col" class="px-3 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($employees as $employee)
                                    <tr wire:key="employee-{{ $employee->id }}">
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                            {{ $employee->employee_number }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900">
                                            {{ $employee->first_name }} {{ $employee->last_name }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                            {{ $employee->email }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                            {{ $employee->position }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                            {{ $employee->hired_at->toFormattedDateString() }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-right text-sm">
                                            <div class="flex justify-end gap-2">
                                                <button type="button" wire:click="edit({{ $employee->id }})" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-wider text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                                                    Edit
                                                </button>
                                                <button type="button" wire:click="confirmDelete({{ $employee->id }})" class="inline-flex min-h-9 items-center justify-center rounded-lg bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white transition hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-100">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-3 py-4 text-sm text-gray-500">
                                            {{ __('No employees yet.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($showSuccessModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6">
            <div class="absolute inset-0 bg-gray-900/50"></div>

            <div role="dialog" aria-modal="true" aria-labelledby="success-modal-title" class="relative w-full max-w-md overflow-hidden rounded-lg bg-white shadow-2xl">
                <div class="px-8 py-7 text-center">
                    <div class="mx-auto flex size-16 items-center justify-center rounded-full bg-green-100">
                        <svg class="size-8 text-green-600" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>

                    <h2 id="success-modal-title" class="mt-5 text-xl font-semibold text-gray-900">
                        {{ $successTitle }}
                    </h2>

                    <p class="mt-2 text-base text-gray-600">
                        {{ $successMessage }}
                    </p>
                </div>

                <div class="border-t border-gray-100 bg-gray-50 px-8 py-5">
                    <button type="button" wire:click="closeSuccessModal" class="inline-flex min-h-12 w-full items-center justify-center rounded-lg bg-gray-900 px-6 py-3 text-sm font-semibold uppercase tracking-widest text-white transition hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-indigo-200">
                        OK
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6">
            <div class="absolute inset-0 bg-gray-900/50"></div>

            <div role="dialog" aria-modal="true" aria-labelledby="delete-modal-title" class="relative w-full max-w-md overflow-hidden rounded-lg bg-white shadow-2xl">
                <div class="px-8 py-7 text-center">
                    <div class="mx-auto flex size-16 items-center justify-center rounded-full bg-red-100">
                        <svg class="size-8 text-red-600" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 9v4m0 4h.01M10.29 3.86 2.82 17a2 2 0 0 0 1.71 3h14.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>

                    <h2 id="delete-modal-title" class="mt-5 text-xl font-semibold text-gray-900">
                        Delete Employee
                    </h2>

                    <p class="mt-2 text-base text-gray-600">
                        This will permanently remove the employee record.
                    </p>
                </div>

                <div class="flex gap-3 border-t border-gray-100 bg-gray-50 px-8 py-5">
                    <button type="button" wire:click="closeDeleteModal" class="inline-flex min-h-12 flex-1 items-center justify-center rounded-lg border border-gray-300 bg-white px-6 py-3 text-sm font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                        Cancel
                    </button>
                    <button type="button" wire:click="delete" wire:loading.attr="disabled" class="inline-flex min-h-12 flex-1 items-center justify-center rounded-lg bg-red-600 px-6 py-3 text-sm font-semibold uppercase tracking-widest text-white transition hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-100 disabled:cursor-not-allowed disabled:opacity-60">
                        <span wire:loading.remove wire:target="delete">Delete</span>
                        <span wire:loading wire:target="delete">Deleting...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
