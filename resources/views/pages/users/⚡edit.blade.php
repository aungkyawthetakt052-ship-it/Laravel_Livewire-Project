<?php

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

new class extends Component {

    public User $user;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $this->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (!empty($validated['password'])) {
            $this->user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        session()->flash('success', 'User updated successfully.');

        return $this->redirect(route('users.index'), navigate: true);
    }
};

?>

<div>
    <div class="container-fluid px-4 py-5">

        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-5">
            <div>
                <h1 class="fw-bold mb-1" style="font-size: 1.85rem; letter-spacing: -0.5px;">
                    Edit User
                </h1>
                <p class="text-muted mb-0" style="font-size: 0.95rem;">
                    Update user information
                </p>
            </div>

            <a href="{{ route('users.index') }}"
                class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 px-4 py-2.5 rounded-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                </svg>
                Back to Users
            </a>
        </div>

        {{-- Form Card --}}
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 col-xl-7">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">

                        <form wire:submit="save">

                            {{-- Name --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">Full Name</label>
                                <input type="text" wire:model="name"
                                    class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror"
                                    placeholder="Enter full name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">Email Address</label>
                                <input type="email" wire:model="email"
                                    class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror"
                                    placeholder="name@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">

                            <p class="text-muted small mb-3">
                                Leave password blank if you don't want to change it.
                            </p>

                            {{-- Password --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">New Password</label>
                                <input type="password" wire:model="password"
                                    class="form-control form-control-lg rounded-3 @error('password') is-invalid @enderror"
                                    placeholder="Enter new password (optional)">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">Confirm New Password</label>
                                <input type="password" wire:model="password_confirmation"
                                    class="form-control form-control-lg rounded-3" placeholder="Confirm new password">
                            </div>

                            {{-- Actions --}}
                            <div class="d-flex gap-3 pt-3">
                                <button type="submit"
                                    class="btn btn-primary px-5 py-2.5 rounded-3 fw-medium d-inline-flex align-items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                    </svg>
                                    Update User
                                </button>

                                <a href="{{ route('users.index') }}"
                                    class="btn btn-outline-secondary px-4 py-2.5 rounded-3">
                                    Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>