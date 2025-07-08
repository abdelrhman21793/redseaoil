<div>
<form wire:submit.prevent="updateTest">
    <input type="text" wire:model="newTestName" value="{{ $newTestName }}"
        style="border-color: none">
    <button type="submit" class="btn btn-outline-dark">Update Name</button>
</form>
</div>
