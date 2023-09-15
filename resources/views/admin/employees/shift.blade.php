<div class="row">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Dia</th>
                <th>Manhã</th>
                <th>Tarde</th>
                <th>Noite</th>
            </tr>
        </thead>
        <tbody>
            {{-- Monday --}}
            <tr>
                <td>
                    <label for="monday">{{ __('date.monday') }}</label>
                    <input id="monday" type="hidden" name="shift[mon]" value="">
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="monday-morning" name="shift[mon]" value="MON-M">
                            <label for="monday-morning"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="monday-afternoon" name="shift[mon]" value="MON-A">
                            <label for="monday-afternoon"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="monday-night" name="shift[mon]" value="MON-N">
                            <label for="monday-night"></label>
                        </div>
                    </div>
                </td>
            </tr>

            {{-- Tuesday --}}
            <tr>
                <td>
                    <label for="tuesday">{{ __('date.tuesday') }}</label>
                    <input id="tuesday" type="hidden" name="shift[tue]" value="">
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="tuesday-morning" name="shift[tue]" value="TUE-M">
                            <label for="tuesday-morning"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="tuesday-afternoon" name="shift[tue]" value="TUE-A">
                            <label for="tuesday-afternoon"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="tuesday-night" name="shift[tue]" value="TUE-N">
                            <label for="tuesday-night"></label>
                        </div>
                    </div>
                </td>
            </tr>

            {{-- Wednesday --}}
            <tr>
                <td>
                    <label for="wednesday">{{ __('date.wednesday') }}</label>
                    <input id="wednesday" type="hidden" name="shift[wed]" value="">
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="wednesday-morning" name="shift[wed]" value="WED-M">
                            <label for="wednesday-morning"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="wednesday-afternoon" name="shift[wed]" value="WED-A">
                            <label for="wednesday-afternoon"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="wednesday-night" name="shift[wed]" value="WED-N">
                            <label for="wednesday-night"></label>
                        </div>
                    </div>
                </td>
            </tr>

            {{-- Thursday --}}
            <tr>
                <td>
                    <label for="thursday">{{ __('date.thursday') }}</label>
                    <input id="thursday" type="hidden" name="shift[thu]" value="">
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="thursday-morning" name="shift[thu]" value="THU-M">
                            <label for="thursday-morning"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="thursday-afternoon" name="shift[thu]" value="THU-A">
                            <label for="thursday-afternoon"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="thursday-night" name="shift[thu]" value="THU-N">
                            <label for="thursday-night"></label>
                        </div>
                    </div>
                </td>
            </tr>

            {{-- Friday --}}
            <tr>
                <td>
                    <label for="friday">{{ __('date.friday') }}</label>
                    <input id="friday" type="hidden" name="shift[fri]" value="">
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="friday-morning" name="shift[fri]" value="FRI-M">
                            <label for="friday-morning"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="friday-afternoon" name="shift[fri]" value="FRI-A">
                            <label for="friday-afternoon"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="friday-night" name="shift[fri]" value="FRI-N">
                            <label for="friday-night"></label>
                        </div>
                    </div>
                </td>
            </tr>

            {{-- Saturday --}}
            <tr>
                <td>
                    <label for="saturday">{{ __('date.saturday') }}</label>
                    <input id="saturday" type="hidden" name="shift[sat]" value="">
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="saturday-morning" name="shift[sat]" value="SAT-M">
                            <label for="saturday-morning"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="saturday-afternoon" name="shift[sat]" value="SAT-A">
                            <label for="saturday-afternoon"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="saturday-night" name="shift[sat]" value="SAT-N">
                            <label for="saturday-night"></label>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-12">
        <div class="text-center">
            <p id="reference-week"></p>
        </div>
    </div>
</div>
