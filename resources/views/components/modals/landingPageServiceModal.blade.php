<div class="modal fade" id="pageServiceModal" tabindex="-1" role="dialog" aria-labelledby="pageServiceModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-0 border-theme">
            <form id="pageServiceForm" action="{{ route('maintenance.service.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="pageServiceModalTitle">Create Landing Page Service</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="container">

                        <div class="from-group mb-2">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>

                        <div class="from-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" rows="4"></textarea>
                        </div>

                    </div>

                </div>
                <div class="modal-footer rounded-0">
                    <button class="text text-light btn btn-primary rounded-0" type="submit" id="pageServiceModalButton">Create</button>
                    <button class="btn btn-secondary rounded-0" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
