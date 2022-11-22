<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Employee update</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('employee.update', $admin_employee->id) }}" method="POST" class="form form-submit"
                enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Employee name</label>
                            <input type="text" name="name" id="" class="form-control"
                                value="{{$admin_employee->name }}" aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Employee email</label>
                            <input type="email" name="email" id="" class="form-control"
                            value="{{$admin_employee->email }}" aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Employee age</label>
                            <input type="number" name="age" id="" class="form-control"
                            value="{{$admin_employee->age }}" aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Employee date of birth</label>
                            <input type="date" name="birth" id="" class="form-control"
                            value="{{$admin_employee->birth->format('Y-m-d')}}" aria-describedby="helpId"> 
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Employee gender</label>
                            <br>
                            <div class="form-check form-check-primary form-check-inline">
                                <div><input class="form-check-input" type="radio" name="gender" value="Female" {{ $admin_employee->gender=='Female'?'checked':'' }}
                                        id="form-check-radio-default">{{ old('sex') == 'female' ? 'checked' : '' }}Femal
                                </div>
                                <br>
                                <div><input class="form-check-input" type="radio" name="gender" value="Male"
                                        id="form-check-radio-default"{{ $admin_employee->gender=='Male'?'checked':'' }}>{{ old('sex') == 'male' ? 'checked' : '' }}Male
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        json_decode($admin_employee->hobbies);
                    @endphp
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Employee Hobbies</label>
                            <div class="form-check">
                              <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input" name="hobbies[]" id="" value="cricket" {{ in_array('cricket',json_decode($admin_employee->hobbies))?'checked':'' }}>cricket
                              </label>
                            </div>
                            <div class="form-check">
                              <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input" name="hobbies[]" id="" value="football" {{ in_array('football',json_decode($admin_employee->hobbies))?'checked':'' }}>Football
                              </label>
                            </div>
                            <div class="form-check">
                              <label class="form-check-label">
                                 <input type="checkbox" class="form-check-input" name="hobbies[]" id="" value="hocky" {{ in_array('hocky',json_decode($admin_employee->hobbies))?'checked':'' }}>Hocky
                              </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                    <i class="fa fa-picture-o"></i> Choose Employee Image
                                </a>
                            </span>
                            <input id="thumbnail" class="form-control" type="text" value="{{$admin_employee->image }}"  name="image">
                        </div>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary btn-rounded float-right">Update employee now</button>
            </form>

        </div>
    </div>
</div>

<script src="{{ asset('vendor') }}/laravel-filemanager/js/stand-alone-button.js"></script>

<script>
    $('#lfm').filemanager('image');
    var options = {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{ csrf_token() ',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{ csrf_token() '
    };
</script>
