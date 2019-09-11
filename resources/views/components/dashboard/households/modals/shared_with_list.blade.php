<div class="modal fade" id="sharedWithList" tabindex="-1" role="dialog" aria-labelledby="sharedWithListTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sharedWithListTitle">People who have access</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (count($shared_with) == 0)
                    <p class="text-center text-muted my-3">
                        You have not shared this household with anyone
                    </p>
                @endif
                @foreach ($shared_with as $share)
                    @php
                        $this_share_permissions = json_decode($share->permissions);
                        $allowed = [];
                        $disabled = [];
                        foreach($sharing_permissions_list as $perm){
                            $key = strtolower(str_replace(" ", "_", $perm->name));
                            if($this_share_permissions->$key){
                                array_push($allowed, $perm->name);
                            }
                            else{
                                array_push($disabled, $perm->name);
                            }
                        }
                    @endphp
                    <p class="mb-1">
                        <strong>{{ $share->shared_with_email }}</strong>
                    </p>
                    <div class="mb-2">
                        <a href="/share/{{ $share->id }}/edit" class="text-info d-inline-block pr-1 border-right">
                            Edit permissions
                        </a>
                        <form action="/share/{{ $share->id }}/revoke" method="POST" class="pl-1 d-inline-block">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="border-0 p-0 bg-transparent text-danger">
                                Revoke access
                            </button>
                        </form>
                    </div>
                    <p class="mb-1">
                        <span class="text-success">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        <span class="text-muted">
                            @foreach ($allowed as $allow)
                                {{ $allow }},
                            @endforeach
                        </span>
                    </span>
                    <p>
                        <span class="text-danger">
                            <i class="fas fa-times-circle"></i>
                        </span>
                        <span class="text-muted">
                            @foreach ($disabled as $disable)
                                {{ $disable }},
                            @endforeach
                        </span>
                    </p>
                    <hr />
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="px-3 py-1 bg-secondary text-white rounded shadow-sm border" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>