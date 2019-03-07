<!-- Transform Lead -->

    <div class="remodal" data-remodal-id="transform-lead">
        <form action='transformLead.php' method='post' class='contact-delete-contact'>
        	<h3>Are you sure you want to change this lead to a contact?</h3>
        	
        	
        	<input type='hidden' name='id' value='<?php echo $lead->data()->id ?>'>
        	
        	
                <button type='submit' class='button'><i class='fas fa-address-book'></i>Change</button>
                <button type='button' data-remodal-action='cancel' class='button'><i class='fas fa-ban'></i>Cancel</button>
        </form>
    </div>