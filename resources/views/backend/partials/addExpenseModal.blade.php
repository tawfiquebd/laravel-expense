
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('expense.add') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Name of Expense">
{{--                        @if($errors->has('name'))--}}
{{--                            <span class="text-danger ml-1">{{ $errors->first('name') }}</span>--}}
{{--                        @endif--}}
                    </div>
                    <div class="form-group">
                        <label for="cost">Cost</label>
                        <input class="form-control" type="text" name="cost" id="cost" value="{{ old('cost') }}" placeholder="Cost">
{{--                        @if($errors->has('cost'))--}}
{{--                            <span class="text-danger ml-1">{{ $errors->first('cost') }}</span>--}}
{{--                        @endif--}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Expense</button>
                </div>
            </form>
        </div>
    </div>
</div>
