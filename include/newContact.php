<?php
	
	$contact = new Contact();
	
	?>

<form action="addContact.php" method="post" id="add-contact-window" class="add-window">
    <div class="add-window-header contact-bg-color">
        <div class="add-window-header-icon contact-icon"></div>
        <div class="add-window-header-title">Create new contact</div>
        <button type="button" class="add-window-close window-close"></button>
    </div>
    <div id="contactMainInfo" class="add-window-form">
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-3">
                <label>First Name</label>
                <input type="text" name="firstName" placeholder="" required>
            </div>
            <div class="add-window-form-section-cell form-x-3">
                <label>Last Name</label>
                <input type="text" name="lastName" placeholder="" required>
            </div>
            <div class="add-window-form-section-cell form-x-3">
                <label>Title</label>
                <input type="text" name="title" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-2">
                <label>Category</label>
                <select name="category">
                    <?php
                    foreach ($contact->getCategories() as $item){

                        echo "<option value='".$item->category."'>".$item->category."</option>";

                    }
                    ?>
                </select>
            </div>
            <div class="add-window-form-section-cell form-x-5">
                <label>Customer Name</label>
                <input onfocus="getCustomers(this)" onkeyup="getCustomers(this)" type="text" style="width:90%;" class="autocomplete-input" name="customer">
                <div class="autocomplete-wrapper"></div>
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-4">
                <label>Email</label>
                <input type="text" name="email" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-3">
                <label>Office Phone</label>
                <input type="text" name="officePhone" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-2">
                <label>Extension</label>
                <input type="text" name="extension" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-3">
                <label>Mobile Phone</label>
                <input type="text" name="mobilePhone" placeholder="">
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-4">
                <label>Street</label>
                <input type="text" name="street" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>City</label>
                <input type="text" name="city" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-2">
                <label>State</label>
                <input type="text" name="state" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-2">
                <label>Zip</label>
                <input type="text" name="zip" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Country</label>
                <input type="text" name="country" placeholder="">
            </div>
        </div>

        <div class="add-window-form-section-big-row">
            <div class="add-window-form-section-cell form-y-4 form-x-4">
                <label>Description</label>
                <textarea name="description"></textarea>
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Tags</label>
                <input type="text" name="tags" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-2">
                <label>Facebook</label>
                <input type="text" name="facebook" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-2">
                <label>Twitter</label>
                <input type="text" name="twitter" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-2">
                <label>LinkedIn</label>
                <input type="text" name="linkedIn" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-2">
                <label>Website</label>
                <input type="text" name="website" placeholder="">
            </div>
        </div>

    </div>
    <div class="add-window-footer">
        <div class="add-window-footer">
            <button id="contactDefaultOpen" onclick="openWindowTab(event, 'contactMainInfo')" type="button" class="add-window-tab defaultOpen">Main Fields</button>
            <div></div>
            <div></div>
            <button type="reset" class="add-window-button-cancel window-close">Cancel</button>
            <button type="submit" class="add-window-button-save">Save</button>
        </div>
    </div>
</form>

