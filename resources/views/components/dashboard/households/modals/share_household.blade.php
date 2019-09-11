<div class="modal fade" id="shareHousehold" tabindex="-1" role="dialog" aria-labelledby="shareHouseholdTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareHouseholdTitle">Sharing Options</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/households/{{ $household->id }}/share" method="POST">
                @csrf
                <div class="modal-body">
                    <label for="share_to_email" class="d-block">Share to: <span class="text-info">*</span></label>
                    <input id="share_to_email" type="text" class="w-100 mb-4 rounded shadow-sm border py-2 px-3 @error('share_to_email') is-invalid @enderror" name="share_to_email" value="{{ old('share_to_email') }}" required placeholder="Share this household with an email" />
                    @error('share_to_email')
                        <label class = "d-block text-danger">{{ $message }}</label>
                    @enderror
                    <label class="d-block">Sharing permissions: <span class="text-info">*</span></label>
                    @php
                        $permissions_list = $sharing_permissions_list->sortBy('name');
                    @endphp
                    <div class="row">
                        <div class="col-lg-6">
                            @for ($i = 0; $i < count($permissions_list) / 2; $i++)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="sharing_permissions[]" id="sharing_permissions_{{ $permissions_list[$i]->id }}" value="{{ $permissions_list[$i]->name }}" />
                                    <label class="custom-control-label" for="sharing_permissions_{{ $permissions_list[$i]->id }}">
                                        {{ $permissions_list[$i]->name }}
                                    </label>
                                    <br />
                                </div>
                            @endfor
                        </div>
                        <div class="col-lg-6">
                            @for ($i = count($permissions_list) / 2; $i < count($permissions_list); $i++)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="sharing_permissions[]" id="sharing_permissions_{{ $permissions_list[$i]->id }}" value="{{ $permissions_list[$i]->name }}" />
                                    <label class="custom-control-label" for="sharing_permissions_{{ $permissions_list[$i]->id }}">
                                        {{ $permissions_list[$i]->name }}
                                    </label>
                                    <br />
                                </div>
                            @endfor
                        </div>
                    </div>
                    {{-- @foreach ($sharing_permissions_list->sortBy('name') as $permission)
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="sharing_permissions[]" id="sharing_permissions_{{ $permission->id }}" value="{{ $permission->name }}" />
                            <label class="custom-control-label" for="sharing_permissions_{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                            <br />
                        </div>
                    @endforeach --}}
                    @error('sharing_permissions')
                        <label class = "d-block text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="px-3 py-1 bg-secondary text-white rounded shadow-sm border" data-dismiss="modal">Close</button>
                    <button type = "submit" class="px-3 py-1 bg-info text-white rounded shadow-sm border">
                        Share
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>