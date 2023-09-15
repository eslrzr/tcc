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

        function isValidDate(date) {
            return date instanceof Date && !isNaN(d);
        }

        const maxDate = new Date().toISOString().split('T')[0];
        $('#form-not-future-date').attr({'max' : maxDate});

        $(document).ready(function() {
            $('#form-not-future-date').on('change', function() {
                const selectedDate = new Date($(this).val());
                const actualDate = new Date();
                if (selectedDate > actualDate || !isValidDate(selectedDate)) {
                    $(this).val(maxDate);
                }
            });
        });

        function cpfFormat(field) {
            field.value = field.value.replace(/\D/g, '');

            field.value = field.value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
        }

        function phoneNumberFormat(field) {
            field.value = field.value.replace(/\D/g, '');

            field.value = field.value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        }

        function salaryFormat(field) {
            field.value = field.value.replace(/[^\d.]/g, '');

            field.value = field.value.replace(/(\..*)\./g, '$1');
        }

        function getPreviousDayOfWeek(dayOfWeek) {
            const today = new Date();
            const currentDayOfWeek = today.getDay();
            const daysUntilPreviousDayOfWeek = (currentDayOfWeek - dayOfWeek - 6 + 7) % 7;
            const previousDay = new Date(today);
            previousDay.setDate(today.getDate() - daysUntilPreviousDayOfWeek - 7);
            return previousDay.toISOString().slice(0, 10); // Formato YYYY-MM-DD
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('monday').value = getPreviousDayOfWeek(2); // Segunda-feira
            document.getElementById('tuesday').value = getPreviousDayOfWeek(3); // Terça-feira
            document.getElementById('wednesday').value = getPreviousDayOfWeek(4); // Quarta-feira
            document.getElementById('thursday').value = getPreviousDayOfWeek(5); // Quinta-feira
            document.getElementById('friday').value = getPreviousDayOfWeek(6); // Sexta-feira
            document.getElementById('saturday').value = getPreviousDayOfWeek(7); // Sábado
        });

        function formatDate(date) {
            const formattedDate = new Date(date);
            const day = formattedDate.getDate();
            const month = formattedDate.getMonth() + 1; // Mês começa em 0 (janeiro)
            const year = formattedDate.getFullYear();
            return `${day}/${month}/${year}`;
        }

        const startDate = formatDate(getPreviousDayOfWeek(2));
        const endDate = formatDate(getPreviousDayOfWeek(7));

        // Exiba a informação da semana no elemento com o ID "reference-week"
        const weekInfo = `Semana de ${startDate} a ${endDate}`;
        document.getElementById('reference-week').textContent = weekInfo;
    </script>
@endpush

@if ($errors->any())
    @push('js')
        <script>
            $(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: '{{ $errors->first() }}',
                    showConfirmButton: false,
                    timer: 1200
                })
            });
        </script>
    @endpush
@endif

@if (session('success'))
    @push('js')
        <script>
            $(() => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 1200
                })
            });
        </script>
    @endpush
@endif