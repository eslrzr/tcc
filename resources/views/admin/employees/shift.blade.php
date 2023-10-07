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
                    <input id="monday" type="hidden" name="shift[mon][date]" value="">
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="monday-morning" name="shift[mon][morning]" value="1">
                            <label for="monday-morning"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="monday-afternoon" name="shift[mon][afternoon]" value="1">
                            <label for="monday-afternoon"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="monday-night" name="shift[mon][night]" value="1">
                            <label for="monday-night"></label>
                        </div>
                    </div>
                </td>
            </tr>

            {{-- Tuesday --}}
            <tr>
                <td>
                    <label for="tuesday">{{ __('date.tuesday') }}</label>
                    <input id="tuesday" type="hidden" name="shift[tue][date]" value="">
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="tuesday-morning" name="shift[tue][morning]" value="1">
                            <label for="tuesday-morning"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="tuesday-afternoon" name="shift[tue][afternoon]" value="1">
                            <label for="tuesday-afternoon"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="tuesday-night" name="shift[tue][night]" value="1">
                            <label for="tuesday-night"></label>
                        </div>
                    </div>
                </td>
            </tr>

            {{-- Wednesday --}}
            <tr>
                <td>
                    <label for="wednesday">{{ __('date.wednesday') }}</label>
                    <input id="wednesday" type="hidden" name="shift[wed][date]" value="1">
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="wednesday-morning" name="shift[wed][morning]" value="1">
                            <label for="wednesday-morning"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="wednesday-afternoon" name="shift[wed][afternoon]" value="1">
                            <label for="wednesday-afternoon"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="wednesday-night" name="shift[wed][night]" value="1">
                            <label for="wednesday-night"></label>
                        </div>
                    </div>
                </td>
            </tr>

            {{-- Thursday --}}
            <tr>
                <td>
                    <label for="thursday">{{ __('date.thursday') }}</label>
                    <input id="thursday" type="hidden" name="shift[thu][date]" value="">
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="thursday-morning" name="shift[thu][morning]" value="1">
                            <label for="thursday-morning"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="thursday-afternoon" name="shift[thu][afternoon]" value="1">
                            <label for="thursday-afternoon"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="thursday-night" name="shift[thu][night]" value="1">
                            <label for="thursday-night"></label>
                        </div>
                    </div>
                </td>
            </tr>

            {{-- Friday --}}
            <tr>
                <td>
                    <label for="friday">{{ __('date.friday') }}</label>
                    <input id="friday" type="hidden" name="shift[fri][date]" value="">
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="friday-morning" name="shift[fri][morning]" value="1">
                            <label for="friday-morning"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="friday-afternoon" name="shift[fri][afternoon]" value="1">
                            <label for="friday-afternoon"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="friday-night" name="shift[fri][night]" value="1">
                            <label for="friday-night"></label>
                        </div>
                    </div>
                </td>
            </tr>

            {{-- Saturday --}}
            <tr>
                <td>
                    <label for="saturday">{{ __('date.saturday') }}</label>
                    <input id="saturday" type="hidden" name="shift[sat][date]" value="">
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="saturday-morning" name="shift[sat][morning]" value="1">
                            <label for="saturday-morning"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="saturday-afternoon" name="shift[sat][afternoon]" value="1">
                            <label for="saturday-afternoon"></label>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="saturday-night" name="shift[sat][night]" value="1">
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
<div class="row">
    <div class="col-12">
        <div class="text-center">
            <p id="period-value"></p>
        </div>
    </div>
</div>
<input type="hidden" name="employee_id" value="{{ $employee->id }}">
