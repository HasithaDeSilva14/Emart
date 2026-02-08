<div>
    <div class="page-header">
        <h1>Settings</h1>
        <p class="text-secondary">Manage application settings</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>General Settings</h3>
        </div>

        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="form-group">
                    <label class="form-label">Site Name</label>
                    <input type="text" wire:model="site_name" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Site Email</label>
                    <input type="email" wire:model="site_email" class="form-input">
                </div>

                <div class="grid grid-cols-3 gap-md">
                    <div class="form-group">
                        <label class="form-label">Currency</label>
                        <select wire:model="currency" class="form-select">
                            <option value="LKR">LKR (Sri Lankan Rupee)</option>
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tax Rate (%)</label>
                        <input type="number" wire:model="tax_rate" class="form-input" step="0.01">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Shipping Fee</label>
                        <input type="number" wire:model="shipping_fee" class="form-input" step="0.01">
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>
