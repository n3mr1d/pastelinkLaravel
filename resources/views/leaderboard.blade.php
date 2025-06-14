<x-html class="main-home" doc="{{ $doc }}" where="{{ $doc }}" css="{{ $css }}">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white">
                    <h1 class="mb-0 text-center"><i class="fas fa-trophy me-2"></i>Leaderboard</h1>
                   
                </div>
                <div class="bg-dark text-center py-2">
                    <span class="text-light me-3">
                        <i class="fas fa-users me-1"></i> User Total: {{count($total)}}
                    </span>
                    <span class="text-light">
                        <i class="fas fa-link me-1"></i> Total Links: {{$link}}
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="bg-dark  table table-hover table-dark mb-0">
                            <thead class="text-white">
                                <tr>
                                    <th class="text-center">Rank</th>
                                    <th>Username</th>
                                    <th class="text-end">Total Links</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($leaderboard->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-light">
                                            <h5>No users found</h5>
                                        </td>
                                    </tr>
                                @else
                                @foreach($leaderboard as $index => $user)
                               
                                    <tr class="{{ $index < 3 ?  ['onerank', 'tworank', 'threerank'][$index] : '' }}">
                                        <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar me-3">
                                                    <i class="fas fa-user-circle fa-2x"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $user->username }}</div>
                                                    <small class="text-muted">Member since {{ $user->created_at->format('M Y') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <span class="badge bg-primary rounded-pill p-2">
                                                {{ $user->total_links }} <i class="fas fa-link ms-1"></i>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-dark text-white-50 text-center">
                    Last updated: {{ now()->format('M d, Y H:i') }}
                </div>
            </div>
        </div>
    </div>
</div>

</x-html>