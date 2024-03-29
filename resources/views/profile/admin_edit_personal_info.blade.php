@extends('profile.admin_profile_layout')


@section('tab_head')

@stop

@section('tab_breadcrumb')
    <li class="breadcrumb-item active">
        <span>
            {{ $pageTitle }} 
          </span>
    </li>
@stop

@section('tab_content_2')

<div class="row">
    
    <div class="col-12">
        <form id="formData" action="{{ route("admin.updateProfilePersonalInfo") }}" method="Post" enctype="multipart/form-data" novalidate="false">
            @csrf
            <input type="hidden" name="delete_photo" id="delete_photo">
            <div class="card-body">

                <div class="row form-group mb-3">
                    <div class="col-lg-6">
                     
                        <div class="form-group">
                            <label class='text-primary' for="birthday"> {{ trans('profile/admin_lang.fields.birthday') }} <span class="text-danger">*</span></label>
                            <input value="{{ $user->userProfile->birthdayFormatted }}" type="text" class="form-control" id="birthday" name="user_profile[birthday]"  placeholder="{{ trans('profile/admin_lang.fields.birthday_helper') }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class='text-primary' for="identification"> {{ trans('profile/admin_lang.fields.identification') }} <span class="text-danger">*</span></label>
                            <input  value="{{ $user->userProfile->identification }}" maxlength="15" type="text" class="form-control" name="user_profile[identification]"  id="identification" placeholder="{{ trans('profile/admin_lang.fields.identification_helper') }}">
                        </div>
                    </div>
                </div>
                <div class="row form-group mb-3">
                    <div class="col-lg-6">
                     
                        <div class="form-group">
                            <label class='text-primary' for="phone"> {{ trans('profile/admin_lang.fields.phone') }} <span class="text-danger">*</span></label>
                            <input value="{{ $user->userProfile->phone }}" type="text"  maxlength="15" class="form-control" name="user_profile[phone]"  placeholder="{{ trans('profile/admin_lang.fields.phone_helper') }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class='text-primary' for="mobile"> {{ trans('profile/admin_lang.fields.mobile') }}</label>
                            <input  value="{{ $user->userProfile->mobile }}"  type="text"  maxlength="15" class="form-control" name="user_profile[mobile]"  id="mobile" placeholder="{{ trans('profile/admin_lang.fields.mobile_helper') }}">
                        </div>
                    </div>
                </div>

                <div class="row form-group mb-3">
                    <div class="col-lg-6">
                     
                        <div class="form-group">
                            <label class='text-primary' for="gender" class="col-12"> {{ trans('profile/admin_lang.fields.gender') }} <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="user_profile[gender]" id="gender"> 
                                @foreach ($genders as $key=>$value)
                                    <option value="{{ $key }}" @if($user->userProfile->gender ==$key) selected @endif>{{ $value }}</option>
                                @endforeach 
                            </select>    
                        </div>
                    </div>
                </div>
                <div class="row form-group mb-3">
                    <div class="col-12 col-md-6">                     
                        <div class="form-group">
                            <label class='text-primary' for="province_id" class="col-12"> {{ trans('profile/admin_lang.fields.province_id') }}<span class="text-danger">*</span></label>
                            <select class="form-control select2" name="user_profile[province_id]" id="province_id">
                                <option value="">{{ trans('profile/admin_lang.fields.province_id_helper') }}</option>   
                                @foreach ($provincesList as $province)
                                    <option value="{{ $province->id }}" @if($user->userProfile->province_id ==$province->id) selected @endif>{{ $province->name }}</option>
                                @endforeach 
                            </select>    
                        
                        </div>
                    </div>    
                    <div class="col-12 col-md-6">                     
                        <div class="form-group">
                            <label class='text-primary' for="municipio_id" class="col-12"> {{ trans('profile/admin_lang.fields.municipio_id') }} <span class="text-danger">*</span> </label>
                            <select class="form-control select2" name="user_profile[municipio_id]" id="municipio_id">
                                <option value="">{{ trans('profile/admin_lang.fields.municipio_id_helper') }}</option>   
                                @foreach ($municipiosList as $municipio)
                                    <option value="{{ $municipio->id }}" @if($user->userProfile->municipio_id ==$municipio->id) selected @endif>{{ $municipio->name }}</option>
                                @endforeach 
                            </select>    
                        </div>
                    </div>                        
                </div>
                <div class="row form-group mb-3">
                    <div class="col-lg-12">
                     
                        <div class="form-group">
                            <label class='text-primary' for="address"> {{ trans('profile/admin_lang.fields.address') }} <span class="text-danger">*</span></label>
                            <input value="{{ $user->userProfile->address }}" type="text" class="form-control" name="user_profile[address]"  placeholder="{{ trans('profile/admin_lang.fields.address_helper') }}">
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">{{ trans('general/admin_lang.save') }}</button>   
            </div>
        </form>
    </div>
</div>
@endsection

@section("tab_foot")
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
       $('#birthday').datepicker(
        {
            language: 'es',
            format: 'dd/mm/yyyy',
            orientation:'bottom',
            autoclose: true
        }
       );
    });
    $("#province_id").change(function(){
        $('#municipio_id').html("<option value='' >{{ trans('centers/admin_lang.fields.municipio_id_helper') }}</option>");
        $.ajax({
            url     : "{{ url('admin/municipios/municipios-list') }}/"+$(this).val(),
            type    : 'GET',
            "headers": {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
            data: {_method: 'delete'},
            success : function(data) {
                console.log(data)
                $.each(data, function(index, value) {
                    $('#municipio_id').append("<option value='"+value['id']+"' >"+value['name']+"</option>");
                   
                });
            }

        });
    });
</script>
{!! JsValidator::formRequest('App\Http\Requests\AdminProfilePersonalInfoRequest')->selector('#formData') !!}
@stop