<div>
    <div class="card  mx-auto" style="width: 500px;">
        <form wire:submit.prevent="acceptRequest">
            @csrf
            <div class="card-body" style="margin-left: 45px;">
                <label class="card-title">Enter Your Password To Continue Accept:-</label>
                <input type="password" wire:model="password" placeholder="Enter your password">
                <button class="btn btn-outline-success" type="submit">Accept</button>
            </div>
        </form>
    </div>
</div>
