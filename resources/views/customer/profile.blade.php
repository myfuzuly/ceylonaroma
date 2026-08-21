@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<section class="cust-section">
    <div class="container">
        <div class="cust-layout">
            @include('customer.partials.sidebar')
            <div class="cust-main">
                <h2 class="cust-page-title">My Profile</h2>

                @if(session('success'))
                    <div class="auth-alert auth-alert-success mb-3">{{ session('success') }}</div>
                @endif

                <div class="profile-cards">
                    {{-- Personal Info --}}
                    <div class="cust-section-card">
                        <div class="cust-card-head"><h3>Personal Information</h3></div>
                        <form method="POST" action="{{ route('customer.profile.update') }}">
                            @csrf @method('PATCH')
                            <div class="form-row-2">
                                <div class="form-group">
                                    <label for="prof-name">Full Name *</label>
                                    <input type="text" id="prof-name" name="name" value="{{ old('name', $customer->name) }}" required autocomplete="name" class="form-control @error('name') is-invalid @enderror">
                                    @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="prof-phone">Phone</label>
                                    <input type="text" id="prof-phone" name="phone" value="{{ old('phone', $customer->phone) }}" autocomplete="tel" class="form-control @error('phone') is-invalid @enderror">
                                    @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="form-row-2">
                                <div class="form-group">
                                    <label for="prof-company">Company</label>
                                    <input type="text" id="prof-company" name="company" value="{{ old('company', $customer->company) }}" autocomplete="organization" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="prof-country">Country</label>
                                    <select id="prof-country" name="country" class="form-control">
                                        <option value="">Select Country</option>
                                        @include('partials.country-options', ['fieldName' => 'country', 'selected' => $customer->country ?? ''])
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="prof-address">Default Shipping Address</label>
                                <textarea id="prof-address" name="address" rows="3" class="form-control" placeholder="Street, City, State, ZIP" autocomplete="street-address">{{ old('address', $customer->address) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="prof-email">Email Address (read-only)</label>
                                <input type="email" id="prof-email" value="{{ $customer->email }}" disabled class="form-control form-control-disabled">
                            </div>
                            <button type="submit" class="btn btn-gold">Save Changes</button>
                        </form>
                    </div>

                    {{-- Password --}}
                    @if($customer->password)
                    <div class="cust-section-card">
                        <div class="cust-card-head"><h3>Change Password</h3></div>
                        <form method="POST" action="{{ route('customer.password.update') }}">
                            @csrf @method('PATCH')
                            <div class="form-group">
                                <label for="current_password">Current Password *</label>
                                <input type="password" id="current_password" name="current_password" required autocomplete="current-password" class="form-control @error('current_password') is-invalid @enderror">
                                @error('current_password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-row-2">
                                <div class="form-group">
                                    <label for="new_password">New Password *</label>
                                    <input type="password" id="new_password" name="password" required minlength="8" autocomplete="new-password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="new_password_confirmation">Confirm New Password *</label>
                                    <input type="password" id="new_password_confirmation" name="password_confirmation" required autocomplete="new-password" class="form-control">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline">Update Password</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
