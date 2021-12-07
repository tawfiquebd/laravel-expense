<!-- Modal -->

@foreach($expenses as $exp)
<div class="modal fade" id="editModal-{{$exp->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ $exp->name }}" placeholder="Name of Expense">
                    </div>
                    <div class="form-group">
                        <label for="cost">Cost</label>
                        <input class="form-control" type="text" name="cost" id="cost" value="{{ $exp->cost }}" placeholder="Cost">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
