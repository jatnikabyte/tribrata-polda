<?php

use Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('File Manager')] class extends Component {
    public function render()
    {
        return $this->view()->layout('layouts::admin');
    }
};
?>

<div>

    <livewire:livewire-filemanager />

</div>
