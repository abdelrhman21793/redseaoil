<div>
<form wire:submit.prevent="updateTroubleshoot">
    <input type="text" wire:model="newTroubleshootName" value="{{ $newTroubleshootName }}"
        style="border-color: none">
    <button type="submit" class="btn btn-outline-dark">Update Name</button>
</form>
</div>
