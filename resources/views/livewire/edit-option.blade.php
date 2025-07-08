<div>
<form wire:submit.prevent="updateOption">
    <input type="text" wire:model="newOptionName" value="{{ $newOptionName }}"
        style="border-color: none">
    <button type="submit" class="btn btn-outline-dark">Update Name</button>
</form>
</div>
