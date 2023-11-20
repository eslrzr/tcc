<div @class(['row'])>
    <div @class(['col-12'])>
        <div @class(['card', 'card-widget'])>
            <div @class(['card-header'])>
                <div class="user-block">
                    <span @class(['username', 'ml-auto'])>{{ $document->name }}</span>
                </div>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
            </div>
            <input id="loaded-comments-{{ $document->id }}" type="hidden">
            <div id="document-comments-{{ $document->id }}" @class(['card-footer', 'card-comments'])>
                <div @class(['loading' . $document->id ])>
                    <div @class(['row', 'd-flex', 'justify-content-center'])>
                        <div @class(['col-6', 'd-flex', 'justify-content-center'])>
                            <div @class(['skeleton', 'skeleton-text', 'skeleton-text-body'])></div>
                        </div>
                    </div>
                </div>
            </div>
            <div @class(['card-footer'])>
                <div @class(['input-group', 'input-group-sm', 'input-group-append'])>
                    <input id="comment-text-{{ $document->id }}" type="text" @class(['form-control']) placeholder="{{ __('alerts.press_enter_send_comment') }}" @required(true)>
                    <button id="comment-document-button-{{ $document->id }}" @class(['btn', 'btn-primary']) style="border-radius: 0px 5px 5px 0px;"><i @class(['fas', 'fa-paper-plane'])></i> {{ __('general.send') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>