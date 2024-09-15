<!-- resources/views/livewire/image-preview.blade.php -->

<div>
    @if ($imageName)
    <img src="{{ asset(" storage/form-attachments/{$imageName}") }}" alt="Image Preview"
        style="max-width: 100px; max-height: 100px;">
    @endif
</div>