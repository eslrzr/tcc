@push('js')
    <script>
        // Call the function on page load to check if user is logged in
        $(() => {
            checkUserLoggedIn();
        });
        
        setInterval(function () {
            checkUserLoggedIn();
        }, 60000);

        // Function to check user is logged in or not
        function checkUserLoggedIn() {
            $.ajax({
                url: "{{ route('isLoggedIn') }}",
                type: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.status == 0) {
                        window.location.href = "{{ route('login') }}";
                    }
                }
            });
        }
    </script>
@endpush