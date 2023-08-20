@push('js')
    <script>
        // Call the function on page load to check if user is logged in
        $(() => {
            checkUserLoggedIn();
            checkReturnMessages();
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

        // Function to check if there is any return message
        function checkReturnMessages() {
            if ("{{ session()->has('success') }}") {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: "{{ session()->get('success') }}",
                    showConfirmButton: false,
                    timer: 1200
                })
            } else if ("{{ session()->has('error') }}") {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: "{{ session()->get('error') }}",
                    showConfirmButton: false,
                    timer: 1200
                })
            }
        }
    </script>
@endpush