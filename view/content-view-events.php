<?php wp_nonce_field( 'security-nonce', 'security' ); ?>

<div id="calendar"></div>

<script type="text/javascript">
	jQuery(function($){
		$('#calendar').fullCalendar({
		    events: function(start, end, timezone, callback) {
		        $.ajax({
		            url: "<?php _e(admin_url( "/admin-ajax.php" )) ?>",
		            method: 'POST',
		            data: {
		                // our hypothetical feed requires UNIX timestamps
		                security: $('#security').val(),
		                action: 'action_get_appointments',
		                start: start.unix(),
		                end: end.unix()
		            },
		            success: function(results) {
		                var events = [];
		                var result = $.parseJSON(results);

		                for(var i in result){
		                	events.push({
		                        title: result[i]['title'],
		                        start: result[i]['start']
		                    });
		                }
		                console.log(result);
		                callback(events);
		            }
		        });
		    },
		height: "auto",
		eventMouseover: function(calEvent, jsEvent, view) {
	         //alert('Event: ' + calEvent.title);
	        // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
	        // alert('View: ' + view.name);
	        $(this).tooltip({title: calEvent.title});
    	}
		});
	})
</script>