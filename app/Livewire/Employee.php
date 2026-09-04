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
    public string $employeeNumber = '';

    public string $firstName = '';

    public string $lastName = '';

    public string $email = '';

    public string $phone = '';

    public string $position = '';

    public string $hiredAt = '';

    public bool $showSuccessModal = false;

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
        $validated = $this->validate();

        EmployeeModel::create([
            'employee_number' => $validated['employeeNumber'],
            'first_name' => $validated['firstName'],
            'last_name' => $validated['lastName'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?: null,
            'position' => $validated['position'],
            'hired_at' => $validated['hiredAt'],
        ]);

        $this->reset([
            'employeeNumber',
            'firstName',
            'lastName',
            'email',
            'phone',
            'position',
            'hiredAt',
        ]);

        $this->showSuccessModal = true;

        $this->dispatch('saved');
    }

    public function closeSuccessModal(): void
    {
        $this->showSuccessModal = false;
    }

    public function render(): View
    {
        return view('livewire.employee', [
            'employees' => EmployeeModel::latest()->get(),
        ]);
    }
}
