<div>
<form wire:submit.prevent="updateSurvey">
    <input type="text" wire:model="newSurveyName" value="{{ $newSurveyName }}"
        style="border-color: none">
    <button type="submit" class="btn btn-outline-dark">Update Name</button>
</form>
</div>
