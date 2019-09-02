<div class="modal fade" id="destroyHouseholdModal" tabindex="-1" role="dialog" aria-labelledby="destroyHouseholdModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="destroyHouseholdModalTitle">Confirm Deletion of Household</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="/households/{{ $household->id }}" method="POST">
            <div class="modal-body">
                @csrf
                @method("DELETE")
                <p>
                    Are you sure you want to remove household <strong>{{ $household->name }}</strong>?
                    <br />
                    All household data, expenses and members tied to the household will be pemranently deleted. There is no going back after this point.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="px-3 py-1 bg-secondary text-white rounded shadow-sm border" data-dismiss="modal">Keep the household</button>
                <button type = "submit" class="px-3 py-1 bg-info text-white rounded shadow-sm border">
                    Yes, I am sure
                </button>
            </div>
        </form>
    </div>
    </div>
</div>