<!--Start Logout System-->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<script>
    function logout(){
        $.toast({
            heading: '{{ __('Sign out!') }}!',
            position: 'top-right',
            text: '{{ __('আপনি সফলভাবে “আসো” থেকে সাইন আউট হয়েছেন।') }}',
            showHideTransition: 'slide',
            icon: 'success'
        })
        setTimeout(function() {
            //your code to be executed after 1 second
            document.getElementById('logout-form').submit();
        }, 1000);
    }
</script>
<!--End Logout System-->
