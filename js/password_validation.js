 <script type="text/javascript">

    $(document).ready(function() {
      $("#form1").validate({
      
      //setting up the rules for validation
      
        rules: {
          
          old_password: {
            required: true
          },
        
          new_password:{
            required: true,
             pwchecklowercase: true,
                pwcheckuppercase: true,
                pwchecknumber: true,
                pwcheckconsecchars: true,
                pwcheckspechars: true,
                pwcheckallowedchars: true,
                minlength: 5,
                maxlength: 25
                     
          },
          confirm_password:{
            required: true,
            equalTo:"#new_password"
                     
          }     
      
        },//rules
      
      //setting up custom messages
      
        messages: {
            
            
          old_password:{
          required:"Enter your old password"
          },
          
          new_password:{
          required:"Enter new password"
          },
          confirm_password:{
            required:"Enter to confirm new password"
          }
        }//messages

        });//validate

      });//function
      
    </script> 