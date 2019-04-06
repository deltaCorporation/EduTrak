<?php
	$customer = new Customer();
?>

<form action="addCustomer.php" method="post" id="add-customer-window" class="add-window">
    <div class="add-window-header customer-bg-color">
        <div class="add-window-header-icon customer-icon"></div>
        <div class="add-window-header-title">Create new customer</div>
        <button type="button" class="add-window-close window-close"></button>
    </div>
    <div id="customerMainInfo" class="add-window-form">
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-4">
                <label>Name</label>
                <input type="text" name="name" placeholder="" required>
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Parent Customer</label>
                <input type="text" name="parentCustomer" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-2">
                <label>Category</label>
                <select id="customer-category" onchange="extendCustomer()" name="category">
                    <?php
                    foreach ($customer->getCategories() as $item){

                        echo "<option value='".$item->category."'>".$item->category."</option>";

                    }
                    ?>
                </select>
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
            <div class="add-window-form-section-cell form-x-3">
                <label>Fax</label>
                <input type="text" name="fax" placeholder="">
            </div>
        </div>

        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-4">
                <label>Partner</label>
                <input onfocus="getCustomers(this)" onkeyup="getCustomers(this)"  style="width:90%;" class="autocomplete-input" type="text" name="partner" placeholder="">
                <div class="autocomplete-wrapper"></div>
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Partner Rep</label>
                <input onfocus="getCustomers(this)" onkeyup="getCustomers(this)"  style="width:90%;" class="autocomplete-input"  type="text" name="partnerRep" placeholder="">
                <div class="autocomplete-wrapper"></div>
            </div>
            <div class="add-window-form-section-cell form-x-6">
                <label>Account Payable Info</label>
                <input type="text" name="accPayInfo" placeholder="">
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
    
    <div id="customerAdditionalInfo" class="add-window-form">
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-16">
                <label>Goals and Initiatives</label>
                <input type="text" name="goalsAndInitiatives" placeholder="">
            </div>
        </div>
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-4">
                <label>Number of schools</label>
                <input type="text" name="numSchools" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Number of students</label>
                <input type="text" name="numStudents" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Number of teachers</label>
                <input type="text" name="numTeachers" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>How many teachers to train</label>
                <input type="text" name="numTrain" placeholder="">
            </div>
        </div>
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-16">
                <label>Current technology in schools</label>
                <input type="text" name="schoolTech" placeholder="">
            </div>
        </div>
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-8">
                <label>What devices are students using</label>
                <input type="text" name="studentDevices" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-8">
                <label>What devices are teachers using</label>
                <input type="text" name="teachersDevices" placeholder="">
            </div>
        </div>
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-8">
                <label>Specific dates requested for PD</label>
                <input type="text" name="PDDates" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-8">
                <label>Type of PD</label>
                <input type="text" name="PDType" placeholder="">
            </div>
        </div>
    </div>
    
    <div class="add-window-footer">
        <div class="add-window-footer">
            <button id="customerDefaultOpen" onclick="openWindowTab(event, 'customerMainInfo')" type="button" class="add-window-tab defaultOpen">Main Fields</button>
            <button id="customer-additional-info-button" onclick="openWindowTab(event, 'customerAdditionalInfo')" type="button" class="add-window-tab">Additional Fields</button>
        <div id="customer-replace-block"></div>
        <div></div>
        <button type="reset" class="add-window-button-cancel window-close">Cancel</button>
        <button type="submit" class="add-window-button-save">Save</button>
        </div>
    </div>
</form>