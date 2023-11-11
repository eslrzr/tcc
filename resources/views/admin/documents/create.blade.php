<div @class(['row'])>
    <div @class(['col-6'])>
        <div @class(['form-group'])>
            <label for="document-title"><i @class(['fas', 'fa-file-signature'])></i> {{ __('form.document_title') }}</label>
            <input id="document-title" type="text" name="name" @class(['form-control']) placeholder="{{ __('form.document_title') }}" @required(true)>
        </div>
    </div>
    <div @class(['col-6'])>
        <div @class(['form-group'])>
            <label for="document-type"><i @class(['fas', 'fa-file'])></i> {{ __('form.document_type') }}</label>
            <select id="document-type" @class(['form-control']) name="document_type_id" @required(true)>
                <option value="" @disabled(true) @selected(true)>{{ __('form.document_type') }}</option>
                @foreach($slotData as $documentType)
                    <option value="{{ $documentType->id }}">{{$documentType->code . ' - ' . $documentType->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div @class(['row'])>
    <div @class(['col-12'])>
        <div @class(['form-group'])>
            <label for="form-document"><i @class(['fas', 'fa-file-upload'])></i> {{ __('form.upload_file') }}</label>
            <input id="form-document" @class(['form-control']) type="file" name="file" accept="image.*, application/pdf">
        </div>
    </div>
</div>
<div @class(['row'])>
    <div @class(['col-6'])>
        <div @class(['form-group'])>
            <label for="link"><i @class(['fas', 'fa-link'])></i> {{ __('form.linked_to') }}</label>
            <select id="link" @class(['form-control']) name="linked_to" @required(true)>
                <option value="" @disabled(true) @selected(true)>{{ __('form.linked_to') }}</option>
                <option value="{{ \app\Models\Document::$LINKED_TO_EMPLOYEE }}">{{ trans_choice('general.employees', 1) }}</option>
                <option value="{{ \app\Models\Document::$LINKED_TO_SERVICE }}">{{ trans_choice('general.services', 1) }}</option>
            </select>
        </div>
    </div>
    <div @class(['col-6', 'employees-select']) hidden>
        <div @class(['form-group'])>
            <label for="employees"><i @class(['fas', 'fa-group'])></i>  {{ trans_choice('general.employees', 2) }}</label>
            <select id="employees" @class(['form-control']) name="employee_id">
                <option value="" @disabled(true) @selected(true)>{{ trans_choice('general.employees', 2) }}</option>
            </select>
        </div>
    </div>
    <div @class(['col-6', 'services-select']) hidden>
        <div @class(['form-group'])>
            <label for="services"><i @class(['fas', 'fa-wrench'])></i>  {{ trans_choice('general.services', 2) }}</label>
            <select id="services" @class(['form-control']) name="service_id">
                <option value="" @disabled(true) @selected(true)>{{ trans_choice('general.services', 2) }}</option>
            </select>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function () {
            $('#link').on('change', function () {
                if ($(this).val() === '{{ \app\Models\Document::$LINKED_TO_EMPLOYEE }}') {
                    $('.employees-select').removeAttr('hidden');
                    $('.services-select').attr('hidden', 'hidden');
                    $.ajax({
                        url: '{{ route("employeesAll") }}',
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $('#employees').empty();
                            $.each(data, function (key, value) {
                                $('#employees').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                } else if ($(this).val() === '{{ \app\Models\Document::$LINKED_TO_SERVICE }}') {
                    $('.services-select').removeAttr('hidden');
                    $('.employees-select').attr('hidden', 'hidden');
                    $.ajax({
                        url: '{{ route("servicesAll") }}',
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $('#services').empty();
                            $.each(data, function (key, value) {
                                $('#services').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('.employees-select').attr('hidden', 'hidden');
                    $('.services-select').attr('hidden', 'hidden');
                }
            });
        });
    </script>
@endpush