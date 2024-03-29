<div class="rounded shadow-sm border p-4 bg-white">
    <h3><i class="fas fa-users"></i> Members</h3>
    @can('add-members', $household)
        <div class="text-right">
            <button type="button" class="mb-2 px-3 py-1 bg-info text-white rounded shadow-sm border" data-toggle="modal" data-target="#addMemberModal">
                Add Member
            </button>
        </div>
    @endcan
    @can('view-members', $household)
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
                                @can('edit-members', $member)
                                    <a href="/members/{{ $member->id }}/edit" class="text-info">
                                        Edit
                                    </a>
                                @endcan
                                @can('delete-members', $member)
                                    <form method="POST" action="/members/{{ $member->id }}">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="border-0 text-danger p-0 bg-transparent">
                                            Remove
                                        </button>
                                    </form>
                                @endcan
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
    @endcan
</div>