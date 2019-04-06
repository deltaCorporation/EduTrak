<!-- New Employee -->

<form action="register.php" method="post" id="add-employee-window" class="add-window">
    <div class="add-window-header employee-bg-color">
        <div class="add-window-header-icon employee-icon"></div>
        <div class="add-window-header-title">Create new employee</div>
        <button type="button" class="add-window-close window-close"></button>
    </div>
    <div id="employeeMainInfo" class="add-window-form">
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-3">
                <label>First Name</label>
                <input type="text" name="accName" placeholder="" required>
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Last Name</label>
                <input type="text" name="accLastName" placeholder="" required>
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Title</label>
                <input type="text" name="accJobTitle" placeholder="" required>
            </div>
            <div class="add-window-form-section-cell form-x-2">
                <label>Gender</label>
                <select name="accGender">
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>
        </div>
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-4">
                <label>Password</label>
                <input type="password" name="accPassword" placeholder="" required>
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Repeat Password</label>
                <input type="password" name="accRepeatPassword" placeholder="">
            </div>
        </div>
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-5">
                <label>Phone</label>
                <input type="text" name="accPhone" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-5">
                <label>Personal phone</label>
                <input type="text" name="accPersonalPhone" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-5">
                <label>Emergency phone</label>
                <input type="text" name="accEmergencyPhone" placeholder="">
            </div>
        </div>
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-5">
                <label>Email</label>
                <input type="email" name="accEmail" placeholder="" required>
            </div>
            <div class="add-window-form-section-cell form-x-5">
                <label>Personal email</label>
                <input type="email" name="accPersonalEmail" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-5">
                <label>Emergency email</label>
                <input type="email" name="accEmergencyEmail" placeholder="">
            </div>
        </div>
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-4">
                <label>Street</label>
                <input type="text" name="accStreet" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>City</label>
                <input type="text" name="accCity" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-2">
                <label>State</label>
                <input type="text" name="accState" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-2">
                <label>Zip</label>
                <input type="text" name="accZip" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Country</label>
                <input type="text" name="accCountry" placeholder="">
            </div>
        </div>
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-4">
                <label>Facebook</label>
                <input type="text" name="accFacebook" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Twitter</label>
                <input type="text" name="accTwitter" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>LinkedIn</label>
                <input type="text" name="accLinkedIn" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>Website</label>
                <input type="text" name="accWebsite" placeholder="">
            </div>
        </div>
        <div class="add-window-form-section-row">
            <div class="add-window-form-section-cell form-x-4">
                <label>Start date</label>
                <input type="text" name="accStartDate" placeholder="">
            </div>
            <div class="add-window-form-section-cell form-x-4">
                <label>End date</label>
                <input type="text" name="accEndDate" placeholder="">
            </div>
        </div>
        <div class="add-window-form-section-big-row">
            <div class="add-window-form-section-cell form-x-4 form-y-4">
                <label>Permissions</label>
                <div class="add-window-form-checkbox">
                    <label><input type="checkbox" name="permissions[]" value="1001">Admin</label>
                </div>
                <div class="add-window-form-checkbox">
                    <label><input type="checkbox" name="permissions[]" value="1003">Instructor</label>
                </div>
                <div class="add-window-form-checkbox">
                    <label><input type="checkbox" name="permissions[]" value="1004">Sales</label>
                </div>
            </div>
        </div>
    </div>
    <div class="add-window-footer">
        <div class="add-window-footer">
            <button id="employeeDefaultOpen" onclick="openWindowTab(event, 'employeeMainInfo')" type="button" class="add-window-tab defaultOpen">Main Fields</button>
            <div></div>
            <div></div>
            <button type="reset" class="add-window-button-cancel window-close">Cancel</button>
            <button type="submit" class="add-window-button-save">Save</button>
        </div>
    </div>
</form>