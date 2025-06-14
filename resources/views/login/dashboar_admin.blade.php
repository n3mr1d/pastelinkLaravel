<x-html doc="{{ $doc }}" css="{{ $css }}" class=" bg-dark text-light ">
    @if(session('message') || $errors->any())
    <x-alert status="{{ session('status') }}">
        {{ session('message') }}
        @if($errors->any())
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </x-alert>
@endif
<h1 class="text-light text-center"><i class="fa fa-dashboard me-3 p-3 " aria-hidden="true"></i>Dashboard Admin</h1>
<div class="container-fluid mt-4">
    <div class="card bg-dark border-secondary shadow-lg">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0 text-center">
                <i class="fas fa-plus-circle me-2"></i>Add New Link
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('addlink') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-light" for="title">Title:</label>
                    <input class="form-control bg-dark text-light border-secondary" 
                           type="text" 
                           name="title" 
                           id="title"
                           required
                           minlength="4"
                           maxlength="100">
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-light" for="link">URL:</label>
                    <input class="form-control bg-dark text-light border-secondary" 
                           type="url" 
                           name="link" 
                           id="link"
                           required
                           placeholder="https://example.com">
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-light" for="category">Category:</label>
                    <select class="form-select bg-dark text-light border-secondary" 
                            name="category" 
                            id="category"
                            required>
                        <option value="">Select a category</option>
                        <option value="marketplace">Marketplace</option>
                        <option value="chat room">Chat Room</option>
                        <option value="forums">Forums</option>
                        <option value="service">Service</option>
                        <option value="search">Search</option>
                        <option value="directory link">Directory Link</option>
                        <option value="youtube">YouTube</option>
                        <option value="uploader">Uploader</option>
                        <option value="hosting">Hosting</option>
                        <option value="news">News</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Add Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card bg-dark border-secondary shadow-lg">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0 text-center">
                <i class="fas fa-link me-2"></i>List Links : {{$link->total()}}
            </h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Links</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($link as $index => $item)
                        <tr>
                            <td class="text-center">{{ $link->firstItem() + $index }}</td>
                            <td>{{ $item->link }}</td>
                            <td class="text-center">
                                <form method="POST" action="{{ route('dellink') }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="link_id" value="{{ $item->id }}">
                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    
                                    @foreach(request()->except(['_token', '_method']) as $key => $value)
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endforeach
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-dark text-white-50">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $link->firstItem() }} to {{ $link->lastItem() }} of {{ $link->total() }} entries
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item {{ $link->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link bg-dark border-secondary" href="{{ $link->previousPageUrl() }}{{ request()->has('user_table') ? '&user_table='.request('user_table') : '' }}{{ request()->has('session_table') ? '&session_table='.request('session_table') : '' }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        @for ($i = 1; $i <= $link->lastPage(); $i++)
                            <li class="page-item {{ $link->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link bg-dark border-secondary" href="{{ $link->url($i) }}{{ request()->has('user_table') ? '&user_table='.request('user_table') : '' }}{{ request()->has('session_table') ? '&session_table='.request('session_table') : '' }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ !$link->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link bg-dark border-secondary" href="{{ $link->nextPageUrl() }}{{ request()->has('user_table') ? '&user_table='.request('user_table') : '' }}{{ request()->has('session_table') ? '&session_table='.request('session_table') : '' }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card bg-dark border-secondary shadow-lg">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0 text-center">
                <i class="fas fa-link me-2"></i>User Total : {{$user->total()}}
            </h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">User</th>
                            <th class="text-center">total links</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $index => $itemuser)
                        <tr>
                            <td class="text-center">{{ $user->firstItem() + $index }}</td>
                            <td>{{ $itemuser->username }}</td>
                            <td class="text-center">{{count($itemuser->links)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-dark text-white-50">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $user->firstItem() }} to {{ $user->lastItem() }} of {{ $user->total() }} entries
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item {{ $user->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link bg-dark border-secondary" href="{{ $user->previousPageUrl() }}{{ request()->has('links_table') ? '&links_table='.request('links_table') : '' }}{{ request()->has('session_table') ? '&session_table='.request('session_table') : '' }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        @for ($i = 1; $i <= $user->lastPage(); $i++)
                            <li class="page-item {{ $user->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link bg-dark border-secondary" href="{{ $user->url($i) }}{{ request()->has('links_table') ? '&links_table='.request('links_table') : '' }}{{ request()->has('session_table') ? '&session_table='.request('session_table') : '' }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ !$user->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link bg-dark border-secondary" href="{{ $user->nextPageUrl() }}{{ request()->has('links_table') ? '&links_table='.request('links_table') : '' }}{{ request()->has('session_table') ? '&session_table='.request('session_table') : '' }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
    <div class="container-fluid">
        <div class="card bg-dark border-secondary shadow-lg">
            <div class="card-header bg-secondary text-white">
                <h4 class="mb-0 text-center">
                    <i class="fas fa-link me-2"></i>active session Total : {{$sessions->total()}}
                </h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th class="text-center">No</th>
                                <th>active username</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sessions as $index => $sessionskun)
                            <tr>
                                <td class="text-center">{{ $sessions->firstItem() + $index }}</td>
                                <td class="text-center">{{ $sessionskun->username }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-dark text-white-50">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        Showing {{ $sessions->firstItem() }} to {{ $sessions->lastItem() }} of {{ $sessions->total() }} entries
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item {{ $sessions->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link bg-dark border-secondary" href="{{ $sessions->previousPageUrl() }}{{ request()->has('links_table') ? '&links_table='.request('links_table') : '' }}{{ request()->has('session_table') ? '&session_table='.request('session_table') : '' }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $sessions->lastPage(); $i++)
                                <li class="page-item {{ $sessions->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link bg-dark border-secondary" href="{{ $sessions->url($i) }}{{ request()->has('links_table') ? '&links_table='.request('links_table') : '' }}{{ request()->has('session_table') ? '&session_table='.request('session_table') : '' }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li class="page-item {{ !$sessions->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link bg-dark border-secondary" href="{{ $sessions->nextPageUrl() }}{{ request()->has('links_table') ? '&links_table='.request('links_table') : '' }}{{ request()->has('session_table') ? '&session_table='.request('session_table') : '' }}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
      
</x-html>