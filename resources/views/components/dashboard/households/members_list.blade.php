<div class="rounded shadow-sm border p-4">
        <h3>Members</h3>
        @if ($household->authUserCanAddMembers())
            <div class="text-right">
                <button type="button" class="mb-2 px-3 py-1 bg-info text-white rounded shadow-sm border" data-toggle="modal" data-target="#addMemberModal">
                    Add Member
                </button>
            </div>
        @endif
        @if ($household->authUserCanViewMembers())
            @if (count($members) > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Income</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                            <tr>
                                <td>{{ $member->first_name }}</td>
                                <td>
                                    @money($member->additional_income * 100, $household->currency->currency_short)
                                </td>
                                <td>
                                    @if ($household->authUserCanEditMembers())
                                        <a href="/members/{{ $member->id }}/edit" class="text-info">
                                            Edit
                                        </a>
                                    @endif
                                    @if ($household->authUseCanDeleteMembers())
                                        <form method="POST" action="/members/{{ $member->id }}">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="border-0 text-danger p-0 bg-transparent">
                                                Remove
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $members->links("vendor.pagination.bootstrap-4") }}
            @else
                <p class="text-center text-muted">
                    No members added
                </p>
            @endif
        @endif
    </div>