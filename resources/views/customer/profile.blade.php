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
                                    <label>Full Name *</label>
                                    <input type="text" name="name" value="{{ old('name', $customer->name) }}" required class="form-control @error('name') is-invalid @enderror">
                                    @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                                    @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="form-row-2">
                                <div class="form-group">
                                    <label>Company</label>
                                    <input type="text" name="company" value="{{ old('company', $customer->company) }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Country</label>
                                    <select name="country" class="form-control">
                                        @foreach(['United States','United Kingdom','Canada','Australia','Germany','France','Netherlands','Japan','China','India','UAE','Saudi Arabia','Singapore','Sri Lanka','Other'] as $c)
                                            <option value="{{ $c }}" {{ ($customer->country ?? '') == $c ? 'selected' : '' }}>{{ $c }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Default Shipping Address</label>
                                <textarea name="address" rows="3" class="form-control" placeholder="Street, City, State, ZIP">{{ old('address', $customer->address) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Email Address (read-only)</label>
                                <input type="email" value="{{ $customer->email }}" disabled class="form-control form-control-disabled">
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
                            <div class="form-row-2">
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" name="password" required minlength="8" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group">
                                    <label>Confirm New Password</label>
                                    <input type="password" name="password_confirmation" required class="form-control">
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
