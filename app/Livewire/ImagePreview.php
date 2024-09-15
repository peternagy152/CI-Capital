<?php

namespace App\Livewire;

use Livewire\Component;

class ImagePreview extends Component
{
    public $imageName;

    public function mount($imageName)
    {
        $this->imageName = $imageName;
    }

    public function render()
    {
        return view('livewire.image-preview');
    }
}
