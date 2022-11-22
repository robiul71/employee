<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Create attendance</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('attendance.store') }}" method="post" class="form form-submit">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Employee name</label>
                            <select name="employee_id"  class="form-control"id="">
                                <option label="--Select employee name--">--Select employee name--</option>
                                @foreach ($employess as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Employee attendance date</label>
                            <input type="date" name="date" id="" class="form-control"
                                placeholder="Employee attendance date here...." aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Employee attendance clock in</label>
                            <input type="time" name="clock_in" id="" class="form-control"
                                placeholder="Employee attendance clock_in here...." aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Employee attendance clock out</label>
                            <input type="time" name="clock_out" id="" class="form-control"
                                placeholder="Employee attendance clock_in here...." aria-describedby="helpId">
                        </div>
                    </div>
                  
                </div>
                <br>
                <button type="submit" class="btn btn-primary btn-rounded float-right">Create employee attendance now</button>
            </form>

        </div>
    </div>
</div>

