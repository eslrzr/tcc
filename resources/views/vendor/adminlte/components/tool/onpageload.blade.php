@push('js')
    <script> 
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

        function cepFormat(field) {
            field.value = field.value.replace(/\D/g, '');
            field.value = field.value.replace(/(\d{5})(\d{3})/, '$1-$2');
        }

        function showToastMessage(success, message) {
            var icon = null;
            var background = null;
            var color = '#fff';

            switch (success) {
                case true:
                    icon = 'success';
                    background = '#00bc8c';
                    break;
                case false:
                    icon = 'error';
                    background = '#e74c3c';
                    break;
            }

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: message,
                showConfirmButton: false,
                timer: 1800,
                background: background,
                color: color,
            })
        }
    </script>
@endpush

@if ($errors->any())
    @push('js')
        <script>
            showToastMessage(false, '{{ $errors->first() }}');
        </script>
    @endpush
@endif

@if (session('success'))
    @push('js')
        <script>
            showToastMessage(true, '{{ session('success') }}');
        </script>
    @endpush
@endif