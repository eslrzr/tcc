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