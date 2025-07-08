<div>
    <div class="card  mx-auto" style="width: 500px;">
        <form wire:submit.prevent="rejectRequest">
            @csrf
            <div class="card-body" style="margin-left: 45px;">
                <label class="card-title">Enter Your Password To Continue Deletion:-</label>
                <input type="password" wire:model="password" placeholder="Enter your password">
                <button class="btn btn-outline-danger" type="submit">Delete</button>
            </div>
        </form>
    </div>
</div>
