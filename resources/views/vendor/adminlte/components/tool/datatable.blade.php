{{-- Table --}}
<div class="table-responsive">
    <table id="{{ $id }}" style="width:100%" class="table table-bordered table-striped dataTable dtr-inline">
        {{-- Table head --}}
        <thead @isset($headTheme) class="thead-{{ $headTheme }}" @endisset>
            <tr>
                @foreach($heads as $th)
                    <th @isset($th['classes']) class="{{ $th['classes'] }}" @endisset
                        @isset($th['width']) style="width:{{ $th['width'] }}%" @endisset
                        @isset($th['no-export']) dt-no-export @endisset>
                        {{ is_array($th) ? ($th['label'] ?? '') : $th }}
                    </th>
                @endforeach
            </tr>
        </thead>

        {{-- Table body --}}
        <tbody>
        {{-- automatic data->item for each value --}}
        @foreach($data as $item)
            <tr>
                @foreach($heads as $th => $value)
                    <td>
                        @if ($th == 'actions')
                            {!! $item->$th['buttons']['html'] !!}
                        @else
                            {{ $item->$th }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>

        {{-- Table footer --}}
        @isset($withFooter)
            <tfoot @isset($footerTheme) class="thead-{{ $footerTheme }}" @endisset>
                <tr>
                    @foreach($heads as $th)
                        <th>{{ is_array($th) ? ($th['label'] ?? '') : $th }}</th>
                    @endforeach
                </tr>
            </tfoot>
        @endisset
    </table>
</div>

{{-- Add plugin initialization and configuration code --}}

@push('js')
    <script>
        $('#{{ $id }}').DataTable({
            language: {
                // vendor
                url: '/vendor/datatables-plugins/lang/{{ $language }}.json',
            },
        });
    </script>
@endpush

{{-- Add CSS styling --}}

@isset($beautify)
    @push('css')
    <style type="text/css">
        #{{ $id }} tr td,  #{{ $id }} tr th {
            vertical-align: middle;
            text-align: center;
        }
    </style>
    @endpush
@endisset
