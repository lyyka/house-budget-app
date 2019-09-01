<div class="rounded shadow-sm border p-4">
        <h3>Members</h3>
        <div class="text-right">
            <button type="button" class="mb-2 px-3 py-1 bg-info text-white rounded shadow-sm border" data-toggle="modal" data-target="#addMemberModal">
                Add Member
            </button>
        </div>
        @if (count($members) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Income</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                        <tr>
                            <th scope="row">{{ $member->first_name }}</th>
                            <td>
                                @money($member->additional_income * 100, $household->currency->currency_short)
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center text-muted">
                No members added
            </p>
        @endif
    </div>