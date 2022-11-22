<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">attendance update</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('attendance.update', $employee_attendance->id) }}" method="POST" class="form form-submit"
                enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Employee name</label>
                            <select name="employee_id"  class="form-control"id="">
                                <option label="--Select employee name--">--Select employee name--</option>
                                @foreach ($employess as $item)
                                <option value="{{ $item->id }}" {{$item->id==$employee_attendance->employee_id?'selected':''}}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Employee attendance date</label>
                            <input type="date" name="date" id="" class="form-control"
                                value="{{$employee_attendance->date->format('Y-m-d')  }}" aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Employee attendance clock in</label>
                            <input type="time" name="clock_in" id="" class="form-control"
                            value="{{$employee_attendance->clock_in }}" aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Employee attendance clock out</label>
                            <input type="time" name="clock_out" id="" class="form-control"
                            value="{{$employee_attendance->clock_out }}" aria-describedby="helpId">
                        </div>
                    </div>

                </div>
                <br>
                <button type="submit" class="btn btn-primary btn-rounded float-right">Update employee attendance now</button>
            </form>

        </div>
    </div>
</div>
