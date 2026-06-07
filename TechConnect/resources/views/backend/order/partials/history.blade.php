@if(count($histories) > 0)
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>No.</th>
        <th>User</th>
        <th>Role</th>
        <th>Previous Status</th>
        <th>New Status</th>
        <th>Remarks</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      @foreach($histories as $key => $history)
        <tr>
          <td>{{ $key + 1 }}</td>
          <td>{{ $history->user->name ?? 'System' }}</td>
          <td>{{ ucfirst($history->role) }}</td>
          <td>{{ ucfirst(str_replace('_', ' ', $history->previous_status)) ?? '-' }}</td>
          <td>{{ ucfirst(str_replace('_', ' ', $history->new_status)) }}</td>
          <td>{{ $history->remarks ?? '-' }}</td>
          <td>{{ $history->created_at->format('Y-m-d H:i') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@else
  <p class="text-center text-muted">No history found for this order.</p>
@endif
