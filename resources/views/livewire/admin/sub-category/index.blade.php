<div>
<!-- Modal -->
<div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">SubCategory Delete</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form wire:submit.prevent="destroySubCategory">
        <div class="modal-body">
            <h6>Are you sure you want to delete this data?</h6>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Yes. Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-md-12">
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <div class="card">
            <div class="card-header">
                <h3>SubCategory
                    <a href="{{ url('admin/sub_category/create') }}" class="btn btn-primary btn-sm float-end">Add SubCategory</a>
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sub_categories as $sub_category)
                        <tr>
                            <td>{{ $sub_category->id }}</td>
                            <td>{{ $sub_category->name }}</td>
                            <td>{{ $sub_category->status=='1' ?'Hidden':'Visible' }}</td>
                            <td>
                                <a href="{{url('admin/sub_category/'.$sub_category->id.'/edit')  }}" class="btn btn-success">Edit</a>
                                <a href="#" wire:click="deleteSubCategory({{ $sub_category->id }})" data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                    
                </table>
                <div>
                    {{ $sub_categories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@push('script')
    <script>
        window.addEventListener('close-modal',event=>{
            $('#deleteModal').modal('hide');
        })
    </script>
@endpush