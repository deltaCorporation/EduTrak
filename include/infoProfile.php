<!-- Profile -->

    <div class="remodal" data-remodal-id="profile">
        <div class="edit-profile-wrapper">
            <div class="edit-profile-header">
                <button data-remodal-action="close" class="remodal-close"></button>

                <div class="edit-profile-image" style="background: url('<?php echo 'view/img/profile/'.escape($user->data()->img) ?>') no-repeat; background-size: 15vh;"></div>
                <div class="edit-profile-name"><?php echo escape($user->data()->firstName).' '.escape($user->data()->lastName)?></div>
                <div class="edit-profile-role"><?php echo escape($user->data()->role)?></div>

                <div class="edit-profile-tabs">
                    <button class="tablinks profile-info-icon" id="defaultOpen" onclick="openTab(event, 'info')">Profile</button>
                    <button class="tablinks profile-contact-icon" onclick="openTab(event, 'contact')">Contact</button>
                    <button class="tablinks profile-address-icon" onclick="openTab(event, 'address')">Address</button>
                    <button class="tablinks profile-social-icon" onclick="openTab(event, 'social')">Social</button>
                </div>

                <!-- Tab content -->
                <div id="info" class="tabcontent">
                    <div class="edit-profile-info">
                        <div class="edit-profile-info-header">First Name</div>
                        <input type="text" name="" value="<?php echo  escape($user->data()->firstName)?>">
                    </div>

                    <div class="edit-profile-info">
                        <div class="edit-profile-info-header">Last Name</div>
                        <input type="text" name="" value="<?php echo  escape($user->data()->lastName)?>">
                    </div>

                    <div class="edit-profile-info">
                        <div class="edit-profile-info-header">Job Title</div>
                        <input type="text" name="" value="<?php echo  escape($user->data()->role)?>">
                    </div>
                </div>

                <div id="contact" class="tabcontent">
                    <div class="edit-profile-contact">
                        <div class="edit-profile-contact-header">Phone</div>
                        <input type="text" placeholder="Phone" value="<?php echo  escape($user->data()->phone)?>">
                    </div>

                    <div class="edit-profile-contact">
                        <div class="edit-profile-contact-header">Email</div>
                        <input type="text" placeholder="Email" value="<?php echo  escape($user->data()->email)?>" disabled>
                    </div>
                </div>

                <div id="address" class="tabcontent">
                    <div class="edit-profile-address">
                        <div class="edit-profile-address-header">Home address</div>

                        <input class="edit-profile-street" type="text" placeholder="Street" value="<?php echo  escape($user->data()->street)?>">
                        <input class="edit-profile-city" type="text" placeholder="City" value="<?php echo  escape($user->data()->city)?>">
                        <input class="edit-profile-district" type="text" placeholder="District" value="<?php echo  escape($user->data()->district)?>">
                        <input class="edit-profile-country" type="text" placeholder="Country" value="<?php echo  escape($user->data()->country)?>">
                        <input class="edit-profile-state" type="text" placeholder="State" value="<?php echo  escape($user->data()->state)?>">
                        <input class="edit-profile-zip" type="text" placeholder="Zip" value="<?php echo  escape($user->data()->zip)?>">
                    </div>
                </div>

                <div id="social" class="tabcontent">
                    <div class="edit-profile-social">
                        <div class="edit-profile-social-header">Facebook</div>
                        <span class="facebook-help">https://www.facebook.com/</span>
                        <input type="text" placeholder="" value="<?php echo  escape($user->data()->facebook)?>">
                    </div>

                    <div class="edit-profile-social">
                        <div class="edit-profile-social-header">Twitter</div>
                        <span class="twitter-help">https://twitter.com/</span>
                        <input type="text" placeholder="" value="<?php echo  escape($user->data()->twitter)?>">
                    </div>

                    <div class="edit-profile-social">
                        <div class="edit-profile-social-header">LinkedIn</div>
                        <span class="linkedin-help">https://www.linkedin.com/in/</span>
                        <input type="text" placeholder="" value="<?php echo  escape($user->data()->linkedin)?>">
                    </div>

                    <div class="edit-profile-social">
                        <div class="edit-profile-social-header">Website</div>
                        <span class="website-help">https://</span>
                        <input type="text" placeholder="" value="<?php echo  escape($user->data()->website)?>">
                    </div>
                </div>
            </div>
            <div class="edit-profile-footer">
                <input data-remodal-action="cancel" type="button" value="Cancel">
                <input data-remodal-action="confirm" type="submit" value="Save">
            </div>
        </div>
    </div>