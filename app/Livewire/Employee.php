<?php

namespace App\Livewire;

use App\Models\Employee as EmployeeModel;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Employee')]
class Employee extends Component
{
    public ?int $editingEmployeeId = null;

    public ?int $deletingEmployeeId = null;

    public string $employeeNumber = '';

    public string $firstName = '';

    public string $lastName = '';

    public string $email = '';

    public string $phone = '';

    public string $position = '';

    public string $hiredAt = '';

    public bool $showSuccessModal = false;

    public bool $showDeleteModal = false;

    public string $successTitle = 'Employee Added';

    public string $successMessage = 'The employee record was created successfully.';

    /**
     * The validation rules for creating an employee.
     *
     * @var array<string, string>
     */
    protected $rules = [
        'employeeNumber' => 'required|string|max:50|unique:employees,employee_number',
        'firstName' => 'required|string|max:255',
        'lastName' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:employees,email',
        'phone' => 'nullable|string|max:30',
        'position' => 'required|string|max:255',
        'hiredAt' => 'required|date|before_or_equal:today',
    ];

    public function save(): void
    {
        if ($this->editingEmployeeId !== null) {
            $this->updateEmployee();

            return;
        }

        $validated = $this->validate();

        EmployeeModel::create($this->employeeData($validated));

        $this->resetForm();
        $this->showSuccess('Employee Added', 'The employee record was created successfully.');

        $this->dispatch('saved');
    }

    public function edit(int $employeeId): void
    {
        $employee = EmployeeModel::findOrFail($employeeId);

        $this->editingEmployeeId = $employee->id;
        $this->employeeNumber = $employee->employee_number;
        $this->firstName = $employee->first_name;
        $this->lastName = $employee->last_name;
        $this->email = $employee->email;
        $this->phone = $employee->phone ?? '';
        $this->position = $employee->position;
        $this->hiredAt = $employee->hired_at->toDateString();
        $this->showSuccessModal = false;
        $this->showDeleteModal = false;

        $this->resetValidation();
    }

    public function cancelEdit(): void
    {
        $this->resetForm();
    }

    public function confirmDelete(int $employeeId): void
    {
        EmployeeModel::findOrFail($employeeId);

        $this->deletingEmployeeId = $employeeId;
        $this->showDeleteModal = true;
        $this->showSuccessModal = false;
    }

    public function delete(): void
    {
        if ($this->deletingEmployeeId === null) {
            return;
        }

        EmployeeModel::findOrFail($this->deletingEmployeeId)->delete();

        if ($this->editingEmployeeId === $this->deletingEmployeeId) {
            $this->resetForm();
        }

        $this->deletingEmployeeId = null;
        $this->showDeleteModal = false;
        $this->showSuccess('Employee Deleted', 'The employee record was deleted successfully.');

        $this->dispatch('deleted');
    }

    public function closeDeleteModal(): void
    {
        $this->deletingEmployeeId = null;
        $this->showDeleteModal = false;
    }

    public function closeSuccessModal(): void
    {
        $this->showSuccessModal = false;
    }

    /**
     * Get human-readable validation attribute names.
     *
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return [
            'employeeNumber' => 'employee number',
            'firstName' => 'first name',
            'lastName' => 'last name',
            'hiredAt' => 'hire date',
        ];
    }

    protected function updateEmployee(): void
    {
        $validated = $this->validate($this->updateRules());

        EmployeeModel::findOrFail($this->editingEmployeeId)->update($this->employeeData($validated));

        $this->resetForm();
        $this->showSuccess('Employee Updated', 'The employee record was updated successfully.');

        $this->dispatch('updated');
    }

    /**
     * The validation rules for updating an employee.
     *
     * @return array<string, string>
     */
    protected function updateRules(): array
    {
        return array_merge($this->rules, [
            'employeeNumber' => 'required|string|max:50|unique:employees,employee_number,'.$this->editingEmployeeId,
            'email' => 'required|email|max:255|unique:employees,email,'.$this->editingEmployeeId,
        ]);
    }

    /**
     * Convert validated Livewire properties into employee columns.
     *
     * @param  array<string, string>  $validated
     * @return array<string, string|null>
     */
    protected function employeeData(array $validated): array
    {
        return [
            'employee_number' => $validated['employeeNumber'],
            'first_name' => $validated['firstName'],
            'last_name' => $validated['lastName'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?: null,
            'position' => $validated['position'],
            'hired_at' => $validated['hiredAt'],
        ];
    }

    protected function resetForm(): void
    {
        $this->reset([
            'editingEmployeeId',
            'employeeNumber',
            'firstName',
            'lastName',
            'email',
            'phone',
            'position',
            'hiredAt',
        ]);

        $this->resetValidation();
    }

    protected function showSuccess(string $title, string $message): void
    {
        $this->successTitle = $title;
        $this->successMessage = $message;
        $this->showSuccessModal = true;
    }

    public function render(): View
    {
        return view('livewire.employee', [
            'employees' => EmployeeModel::latest()->get(),
        ]);
    }
}
