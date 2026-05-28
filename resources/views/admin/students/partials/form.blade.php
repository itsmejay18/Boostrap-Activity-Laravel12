@php
    $value = function (string $field, mixed $default = null) use ($student, $showErrors) {
        if ($showErrors) {
            return old($field);
        }

        return $student?->{$field} ?? $default;
    };
@endphp

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="{{ $prefix }}-firstname">First Name</label>
        <input
            type="text"
            id="{{ $prefix }}-firstname"
            name="firstname"
            value="{{ $value('firstname') }}"
            class="form-control {{ $showErrors && $errors->has('firstname') ? 'is-invalid' : '' }}"
            placeholder="Juan"
            required
        >
        @if ($showErrors && $errors->has('firstname'))
            <span class="invalid-feedback d-block">{{ $errors->first('firstname') }}</span>
        @endif
    </div>

    <div class="form-group col-md-4">
        <label for="{{ $prefix }}-middlename">Middle Name</label>
        <input
            type="text"
            id="{{ $prefix }}-middlename"
            name="middlename"
            value="{{ $value('middlename') }}"
            class="form-control {{ $showErrors && $errors->has('middlename') ? 'is-invalid' : '' }}"
            placeholder="Santos"
        >
        @if ($showErrors && $errors->has('middlename'))
            <span class="invalid-feedback d-block">{{ $errors->first('middlename') }}</span>
        @endif
    </div>

    <div class="form-group col-md-4">
        <label for="{{ $prefix }}-lastname">Last Name</label>
        <input
            type="text"
            id="{{ $prefix }}-lastname"
            name="lastname"
            value="{{ $value('lastname') }}"
            class="form-control {{ $showErrors && $errors->has('lastname') ? 'is-invalid' : '' }}"
            placeholder="Dela Cruz"
            required
        >
        @if ($showErrors && $errors->has('lastname'))
            <span class="invalid-feedback d-block">{{ $errors->first('lastname') }}</span>
        @endif
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-3">
        <label for="{{ $prefix }}-year">Year</label>
        <input
            type="number"
            id="{{ $prefix }}-year"
            name="year"
            value="{{ $value('year') }}"
            min="1"
            max="10"
            class="form-control {{ $showErrors && $errors->has('year') ? 'is-invalid' : '' }}"
            placeholder="1"
            required
        >
        @if ($showErrors && $errors->has('year'))
            <span class="invalid-feedback d-block">{{ $errors->first('year') }}</span>
        @endif
    </div>

    <div class="form-group col-md-3">
        <label for="{{ $prefix }}-course">Course</label>
        <input
            type="text"
            id="{{ $prefix }}-course"
            name="course"
            value="{{ $value('course') }}"
            class="form-control {{ $showErrors && $errors->has('course') ? 'is-invalid' : '' }}"
            placeholder="BSIT"
            required
        >
        @if ($showErrors && $errors->has('course'))
            <span class="invalid-feedback d-block">{{ $errors->first('course') }}</span>
        @endif
    </div>

    <div class="form-group col-md-6">
        <label for="{{ $prefix }}-photo-url">Photo URL</label>
        <input
            type="text"
            id="{{ $prefix }}-photo-url"
            name="photo_url"
            value="{{ $value('photo_url') }}"
            class="form-control {{ $showErrors && $errors->has('photo_url') ? 'is-invalid' : '' }}"
            placeholder="https://example.com/photo.jpg"
        >
        @if ($showErrors && $errors->has('photo_url'))
            <span class="invalid-feedback d-block">{{ $errors->first('photo_url') }}</span>
        @endif
    </div>
</div>
