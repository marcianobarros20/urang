<script type="text/javascript">
    $(document).ready(function(){
        $('#change_password').click(function(){
            var password = $('#n_pass').val();
            var conf_password = $('#confirm_password').val();
            if (password && conf_password) 
            {
                if (password == conf_password) 
                {
                    return true;
                }
                else
                {
                    $('#errorJs').show();
                    $('#errorJs').html("<strong>"+"Error!"+"</strong>"+" Password and confirm password didnt match"+'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
                    return false;
                }
            }
            else
            {
                $('#errorJs').show();
                $('#errorJs').html("<strong>"+"Error!"+"</strong>"+" Password and confirm password could not be blank"+'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
                return false;
            }
        });
        //check for session disable back after logout
        $.ajax({
            url: "{{route('checkForSession')}}",
            type: "POST",
            data: {_token: "{{Session::token()}}"},
            success: function(data) {
                //console.log(data);
                if (data == 0) 
                {
                    //i.e no session
                    document.location.href="{!! route('get-admin-login') !!}";
                }
            }
        });
    });
</script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{url('/')}}/public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{url('/')}}/public/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="{{url('/')}}/public/bower_components/raphael/raphael-min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{url('/')}}/public/dist/js/sb-admin-2.js"></script>