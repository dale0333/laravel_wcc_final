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

test('employee can be edited', function () {
    $this->actingAs(User::factory()->create());
    $employee = EmployeeModel::factory()->create([
        'employee_number' => 'EMP-1001',
        'first_name' => 'Alvin',
        'last_name' => 'Joyosa',
        'email' => 'alvin@example.com',
        'phone' => '09171234567',
        'position' => 'Software Engineer',
        'hired_at' => '2026-09-03',
    ]);

    Livewire::test(Employee::class)
        ->call('edit', $employee->id)
        ->assertSet('editingEmployeeId', $employee->id)
        ->assertSet('employeeNumber', 'EMP-1001')
        ->assertSet('firstName', 'Alvin')
        ->assertSet('lastName', 'Joyosa')
        ->assertSet('email', 'alvin@example.com')
        ->set('employeeNumber', 'EMP-2002')
        ->set('firstName', 'Dale')
        ->set('lastName', 'Santos')
        ->set('email', 'dale@example.com')
        ->set('phone', '')
        ->set('position', 'Project Manager')
        ->set('hiredAt', '2026-09-02')
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('updated')
        ->assertSet('editingEmployeeId', null)
        ->assertSet('showSuccessModal', true)
        ->assertSee('Employee Updated');

    $this->assertDatabaseHas('employees', [
        'id' => $employee->id,
        'employee_number' => 'EMP-2002',
        'first_name' => 'Dale',
        'last_name' => 'Santos',
        'email' => 'dale@example.com',
        'phone' => null,
        'position' => 'Project Manager',
    ]);

    expect($employee->fresh()->hired_at->toDateString())->toBe('2026-09-02');
});

test('employee update allows the current unique values', function () {
    $this->actingAs(User::factory()->create());
    $employee = EmployeeModel::factory()->create([
        'employee_number' => 'EMP-1001',
        'email' => 'alvin@example.com',
    ]);

    Livewire::test(Employee::class)
        ->call('edit', $employee->id)
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('updated');

    $this->assertDatabaseCount('employees', 1);
});

test('employee update validates unique fields against other employees', function () {
    $this->actingAs(User::factory()->create());
    EmployeeModel::factory()->create([
        'employee_number' => 'EMP-1001',
        'email' => 'alvin@example.com',
    ]);
    $employee = EmployeeModel::factory()->create([
        'employee_number' => 'EMP-2002',
        'email' => 'dale@example.com',
    ]);

    Livewire::test(Employee::class)
        ->call('edit', $employee->id)
        ->set('employeeNumber', 'EMP-1001')
        ->set('email', 'alvin@example.com')
        ->call('save')
        ->assertHasErrors([
            'employeeNumber' => ['unique'],
            'email' => ['unique'],
        ]);

    $this->assertDatabaseHas('employees', [
        'id' => $employee->id,
        'employee_number' => 'EMP-2002',
        'email' => 'dale@example.com',
    ]);
});

test('employee edit can be cancelled', function () {
    $this->actingAs(User::factory()->create());
    $employee = EmployeeModel::factory()->create([
        'employee_number' => 'EMP-1001',
        'first_name' => 'Alvin',
    ]);

    Livewire::test(Employee::class)
        ->call('edit', $employee->id)
        ->assertSet('editingEmployeeId', $employee->id)
        ->call('cancelEdit')
        ->assertSet('editingEmployeeId', null)
        ->assertSet('employeeNumber', '')
        ->assertSet('firstName', '');
});

test('employee can be deleted', function () {
    $this->actingAs(User::factory()->create());
    $employee = EmployeeModel::factory()->create();

    Livewire::test(Employee::class)
        ->call('confirmDelete', $employee->id)
        ->assertSet('deletingEmployeeId', $employee->id)
        ->assertSet('showDeleteModal', true)
        ->call('delete')
        ->assertDispatched('deleted')
        ->assertSet('deletingEmployeeId', null)
        ->assertSet('showDeleteModal', false)
        ->assertSet('showSuccessModal', true)
        ->assertSee('Employee Deleted');

    $this->assertModelMissing($employee);
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
