@props([
    'field' => null, // form.field_name
    'message' => null, // Custom message, will use Laravel validation message if not provided
])

@php
    // Get the actual error message from Laravel validation
    $errorMessage = $message;
    if (!$errorMessage && $field) {
        $errors = session('errors');
        if ($errors && isset($errors[$field])) {
            $errorMessage = $errors[$field];
        }
    }
@endphp

@if (isset($errorMessage) && $errorMessage !== '')
    <p class="mt-1.5 text-sm text-red-500">{{ $errorMessage }}</p>
@endif
