<?php $requests = new Request(); ?>
<div id="add-item-window" class="modal-window">
    <div class="item-popup-header">
        <h2>Add Item</h2>
        <div>
            <button class="item-popup-close"></button>
        </div>
    </div>
    <div class="request-popup-content">
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-16">
                <label>Item Name</label>
                <select class="item-name" name="typeID">
                    <?php foreach ($requests->getItemTypes() as $type): ?>
                        <option value="<?php echo $type->id ?>"><?php echo $type->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-16">
                <label for="request-title">Quantity</label>
                <input class="item-qty" type="text">
            </div>
        </div>
    </div>
    <div class="item-popup-footer">
        <button id="add-new-items" type="button"><i class="fa-spin fas fa-spinner"></i>Add</button>
    </div>
</div>