<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog"
     @isset($staticBackdrop) data-backdrop="static" data-keyboard="false" @endisset>
    <div class="modal-dialog {{ $size ?? '' }}" role="document">
        <div class="modal-content">

            {{--Modal header --}}
            <div class="modal-header">
                <h4 class="modal-title">
                    @isset($icon)<i class="{{ $icon }} mr-2"></i>@endisset
                    @isset($title){{ $title }}@endisset
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route($route) }}" method="POST">
                @csrf
                {{-- Modal body --}}
                <div class="modal-body">
                    @include($slot, $slotData ?? [])
                </div>

                {{-- Modal footer --}}
                <div class="modal-footer">
                    <div class="mr-auto">
                        @include('adminlte::components.form.button', [
                            'type' => 'button',
                            'label' => __('general.cancel'),
                            'icon' => 'fas fa-times',
                            'theme' => 'secondary',
                            'attributes' => [
                                'data-dismiss' => 'modal',
                            ],
                        ])
                    </div>
                    @include('adminlte::components.form.button', [
                        'type' => 'submit',
                        'label' => __('general.save'),
                        'icon' => 'fas fa-save',
                        'theme' => 'primary',
                    ])
                </div>
            </form>
        </div>
    </div>
</div>