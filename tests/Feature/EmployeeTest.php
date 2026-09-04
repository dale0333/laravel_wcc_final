<?php

use App\Livewire\Employee;
use App\Models\Employee as EmployeeModel;
use App\Models\User;
use Livewire\Livewire;

test('employee page requires authentication', function () {
    $this->get('/employee')
        ->assertRedirect('/login');
});

test('employee page renders for authenticated users', function () {
    $this->actingAs(User::factory()->create());

    $this->get('/employee')
        ->assertSee('Add Employee');
});

test('employee can be created', function () {
    $this->actingAs(User::factory()->create());
    $hireDate = today()->toDateString();

    Livewire::test(Employee::class)
        ->set('employeeNumber', 'EMP-1001')
        ->set('firstName', 'Alvin')
        ->set('lastName', 'Joyosa')
        ->set('email', 'alvin@example.com')
        ->set('phone', '09171234567')
        ->set('position', 'Software Engineer')
        ->set('hiredAt', $hireDate)
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('saved')
        ->assertSet('showSuccessModal', true)
        ->assertSee('Employee Added')
        ->call('closeSuccessModal')
        ->assertSet('showSuccessModal', false);

    $this->assertDatabaseHas('employees', [
        'employee_number' => 'EMP-1001',
        'first_name' => 'Alvin',
        'last_name' => 'Joyosa',
        'email' => 'alvin@example.com',
        'phone' => '09171234567',
        'position' => 'Software Engineer',
    ]);

    expect(EmployeeModel::first()->hired_at->toDateString())->toBe($hireDate);
});

test('employee creation validates required fields', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Employee::class)
        ->call('save')
        ->assertHasErrors([
            'employeeNumber' => ['required'],
            'firstName' => ['required'],
            'lastName' => ['required'],
            'email' => ['required'],
            'position' => ['required'],
            'hiredAt' => ['required'],
        ]);

    $this->assertDatabaseCount('employees', 0);
});

test('employee creation validates unique fields', function () {
    $this->actingAs(User::factory()->create());

    EmployeeModel::factory()->create([
        'employee_number' => 'EMP-1001',
        'email' => 'alvin@example.com',
    ]);

    Livewire::test(Employee::class)
        ->set('employeeNumber', 'EMP-1001')
        ->set('firstName', 'Alvin')
        ->set('lastName', 'Joyosa')
        ->set('email', 'alvin@example.com')
        ->set('position', 'Software Engineer')
        ->set('hiredAt', '2026-09-03')
        ->call('save')
        ->assertHasErrors([
            'employeeNumber' => ['unique'],
            'email' => ['unique'],
        ]);

    $this->assertDatabaseCount('employees', 1);
});

test('employee creation rejects an invalid email and future hire date', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Employee::class)
        ->set('employeeNumber', 'EMP-1001')
        ->set('firstName', 'Alvin')
        ->set('lastName', 'Joyosa')
        ->set('email', 'not-an-email')
        ->set('position', 'Software Engineer')
        ->set('hiredAt', today()->addDay()->toDateString())
        ->call('save')
        ->assertHasErrors([
            'email' => ['email'],
            'hiredAt' => ['before_or_equal'],
        ]);

    $this->assertDatabaseCount('employees', 0);
});
