<input type="hidden" name="id" value="{{ $document->id }}">
<div @class(['row'])>
    <div @class(['col-6'])>
        <div @class(['form-group'])>
            <label for="document-title"><i @class(['fas', 'fa-file-signature'])></i> {{ __('form.document_title') }}</label>
            <input id="document-title" type="text" name="name" value="{{ old('name', $document->name) }}" @class(['form-control']) placeholder="{{ __('form.document_title') }}" @required(true)>
        </div>
    </div>
    <div @class(['col-6'])>
        <div @class(['form-group'])>
            <label for="document-type"><i @class(['fas', 'fa-file'])></i> {{ __('form.document_type') }}</label>
            <select id="document-type" @class(['form-control']) name="document_type_id" @required(true)>
                @foreach($slotData as $documentType)
                    @if ($documentType->id == old('document_type_id', $document->document_type_id))
                        <option value="{{ old('document_type_id', $document->document_type_id) }}" @disabled(true) @selected(true)>{{ $documentType->name }}</option>
                    @endif
                    <option value="{{ $documentType->id }}">{{$documentType->code . ' - ' . $documentType->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
@if($document->employee_name)
    <div @class(['row'])>
        <div @class(['col-6'])>
            <div @class(['form-group'])>
                <label for="link"><i @class(['fas', 'fa-link'])></i> {{ __('form.linked_to') }}</label>
                <select id="link" @class(['form-control']) @disabled(true)>
                    <option value="" @disabled(true) @selected(true)>{{ trans_choice('general.employees', 1) }}</option>
                </select>
            </div>
        </div>
        <div @class(['col-6', 'employees-select'])>
            <div @class(['form-group'])>
                <label for="employees"><i @class(['fas', 'fa-user-tie'])></i>  {{ trans_choice('general.employees', 1) }}</label>
                <select id="employees" @class(['form-control']) @disabled(true)>
                    <option value="" @disabled(true) @selected(true)>{{ $document->employee_name }}</option>
                </select>
            </div>
        </div>
    </div>
@endif
@if($document->service_name)
    <div @class(['row'])>
        <div @class(['col-6'])>
            <div @class(['form-group'])>
                <label for="link"><i @class(['fas', 'fa-link'])></i> {{ __('form.linked_to') }}</label>
                <select id="link" @class(['form-control']) @disabled(true)>
                    <option value="" @disabled(true) @selected(true)>{{ trans_choice('general.services', 1) }}</option>
                </select>
            </div>
        </div>
        <div @class(['col-6', 'services-select'])>
            <div @class(['form-group'])>
                <label for="services"><i @class(['fas', 'fa-wrench'])></i>  {{ trans_choice('general.services', 1) }}</label>
                <select id="services" @class(['form-control']) @disabled(true)>
                    <option value="" @disabled(true) @selected(true)>{{ $document->service_name }}</option>
                </select>
            </div>
        </div>
    </div>
@endif