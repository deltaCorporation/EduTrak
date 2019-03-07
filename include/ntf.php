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
       
       <script type="text/javascript" >

function deleteNtf(id){
var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                $('#ntf-sidebar-content').load(document.URL +  ' #ntf-sidebar-subcontent');
                $('#ntf').load(document.URL +  ' #ntf');
            }
        };
        xmlhttp.open("GET", "deleteNtf.php?id=" + id, true);
        xmlhttp.send();
}
       
       
        
 </script>
</div>
</div>

    </aside>

