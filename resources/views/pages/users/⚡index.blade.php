<?php

use Livewire\Component;
use App\Models\User;

new class extends Component {

    public string $search = '';

    public function with(): array
    {
        return [
            'users' => User::query()
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderByDesc('id')   // ←  (ID ကြီးတဲ့သူ အရင်)
                ->get(),
        ];
    }

    public function delete(int $id)
    {
        User::findOrFail($id)->delete();
    }
};

?>

<div>
    <div class="container-fluid px-4 py-5">

        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-5">
            <div>
                <h1 class="fw-bold mb-1" style="font-size: 1.85rem; letter-spacing: -0.5px;">
                    User Management
                </h1>
                <p class="text-body-secondary mb-0" style="font-size: 0.95rem;">
                    Manage all users in your system
                </p>
            </div>

            <a href="{{ route('users.create') }}"
                class="btn btn-primary d-inline-flex align-items-center gap-2 px-4 py-2.5 rounded-3 shadow-sm fw-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg>
                Add New User
            </a>
        </div>

        {{-- Search --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3 p-md-4">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-transparent border-end-0 ps-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            class="text-body-secondary" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        class="form-control border-start-0 ps-0 shadow-none" placeholder="Search by name or email...">
                    @if($search)
                        <button wire:click="$set('search', '')" class="btn btn-link text-body-secondary px-3">
                            ✕
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        {{-- ★ table-light ကို ဖယ်လိုက်ပြီး theme-aware class သုံးထားပါတယ် --}}
                        <tr class="border-bottom">
                            <th class="ps-4 py-3 text-body-secondary fw-semibold"
                                style="font-size: 0.78rem; letter-spacing: 0.6px; background-color: var(--bs-tertiary-bg);">
                                ID</th>
                            <th class="py-3 text-body-secondary fw-semibold"
                                style="font-size: 0.78rem; letter-spacing: 0.6px; background-color: var(--bs-tertiary-bg);">
                                USER</th>
                            <th class="py-3 text-body-secondary fw-semibold"
                                style="font-size: 0.78rem; letter-spacing: 0.6px; background-color: var(--bs-tertiary-bg);">
                                EMAIL</th>
                            <th class="py-3 text-body-secondary fw-semibold"
                                style="font-size: 0.78rem; letter-spacing: 0.6px; background-color: var(--bs-tertiary-bg);">
                                CREATED</th>
                            <th class="py-3 text-body-secondary fw-semibold"
                                style="font-size: 0.78rem; letter-spacing: 0.6px; background-color: var(--bs-tertiary-bg);">
                                UPDATED</th>
                            <th class="pe-4 py-3 text-end text-body-secondary fw-semibold"
                                style="font-size: 0.78rem; letter-spacing: 0.6px; background-color: var(--bs-tertiary-bg);">
                                ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr wire:key="user-{{ $user->id }}">
                                <td class="ps-4 py-3">
                                    <span
                                        class="badge bg-body-secondary text-body-emphasis fw-medium px-2.5 py-1 rounded-pill">
                                        #{{ $user->id }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                            style="width: 42px; height: 42px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-size: 0.95rem;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="fw-semibold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 text-body-secondary">{{ $user->email }}</td>
                                <td class="py-3 text-body-secondary" style="font-size: 0.9rem;">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="py-3 text-body-secondary" style="font-size: 0.9rem;">
                                    {{ $user->updated_at->format('M d, Y') }}
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="btn btn-sm btn-outline-primary rounded-3 px-3">
                                            Edit
                                        </a>
                                        <button wire:click="delete({{ $user->id }})"
                                            wire:confirm="Are you sure you want to delete this user?"
                                            class="btn btn-sm btn-outline-danger rounded-3 px-3">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-body-secondary py-4">
                                        <h5 class="fw-semibold">No users found</h5>
                                        <p class="mb-0">Try adjusting your search</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>