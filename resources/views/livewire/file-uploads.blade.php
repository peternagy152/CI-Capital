<div>
    @if ($value['image'])
    <img src="{{ asset(" storage/form-attachments/{$value['image']}") }}" alt="Image Preview"
        style="max-width: 100px; max-height: 100px;">
    @endif
</div>