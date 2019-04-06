<aside id="ntf-sidebar">
        <div class="ntf-sidebar-header">
            <div class="ntf-close">&times;</div>
            <h2>Notifications</h2>
        </div>
        <div class="ntf-sidebar-content" id="ntf-sidebar-content">
        <div id='ntf-sidebar-subcontent'>


        <?php 
        
        
        $ntf = new Notification();
        
        if(count($ntf->getNotifications()) == 0){
        	echo '<div class="no-ntf">There are no new notifications! </div>';
        }

        if (count($ntf->getUnseenUserNotifications($user->data()->id)) != 0){
            echo "
                <div class='ntf-clear-all'>
                    <button type='button' onclick='clearAll()'>Clear all</button>
                </div>
            ";
        }
        
        $seen = 0;
        
        foreach ($ntf->getNotifications() as $ntf){
        
	        if ($ntf->userID == $user->data()->id){

	        	if($ntf->seen == 0){

		        echo '
			          <div class="ntf-content">
				         <div class="ntf-header">
				             <div class="ntf-text-picture">
				             	<i class="fas fa-info"></i>
				             </div>
				             <button onclick="deleteNtf('.$ntf->id.')" id="" class="ntf-hide">
				             	<i class="fas fa-times"></i>
				             </button>
				         
				         </div>
				         <a href="'. $ntf->ntfLink    .'"  class="ntf-text">
				           
				             '. $ntf->content   .'
				         </a>
				         <div class="ntf-date">
				             <div class="ntf-data-data">' . $ntf->ntfDate .'</div>
				             <div class="clear"></div>
				         </div>
				    </div>
			        
		        
		        
		        
		        
		        
		        ';

		        $seen ++;
		        }
	        }
         
        
        }
        
        if($seen == 0){
	        echo '<div class="no-ntf">There are no new notifications! </div>';
        }
        
        
        
        
        
        
          ?>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script type="text/javascript" >

                function deleteNtf(id){
                    $.ajax({
                        url: 'deleteNtf.php',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function () {
                            $('#ntf-sidebar-content').load(document.URL +  ' #ntf-sidebar-subcontent');
                            $('#ntf').load(document.URL +  ' #ntf');
                        }

                    })
                }

                function clearAll() {

                    $.ajax({
                        url: 'deleteNtf.php',
                        type: 'POST',
                        data: {
                            type: 'all'
                        },
                        success: function () {
                            $('#ntf-sidebar-content').load(document.URL +  ' #ntf-sidebar-subcontent');
                            $('#ntf').load(document.URL +  ' #ntf');
                        }
                    });

                }
 </script>
</div>
</div>

    </aside>

