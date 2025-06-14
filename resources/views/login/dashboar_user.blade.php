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
<h1 class="text-light text-center"><i class="fa fa-dashboard me-3 p-3 " aria-hidden="true"></i>Dashboard</h1>

<div class="container mb-4">
    <div class="card bg-dark border-secondary shadow-lg">
        <div class="card-header bg-gradient bg-secondary text-white">
            <h4 class="mb-0">
                <i class="fas fa-user-circle me-2"></i>User Profile
            </h4>
        </div>
        <div class="card-body w-100 d-flex justify-content-between">
            <div class="row align-items-center w-100 justify-content-between d-flex justify-item-center">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-light mb-3"><i class="fas fa-id-card me-2"></i> User Information</h5>
                            <ul class="list-group list-group-flush bg-transparent">
                                <li class="list-group-item bg-transparent text-light border-secondary">
                                    <strong>Username:</strong> {{ $whoami->username }}
                                </li>
                                <li class="list-group-item bg-transparent text-light border-secondary">
                                    <strong>Email:</strong> {{ $whoami->email ?? '0' }}
                                </li>
                                <li class="list-group-item bg-transparent text-light border-secondary">
                                    <strong>Member Since:</strong> {{ $whoami->created_at->format('M d, Y') }}
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-light mb-3"><i class="fas fa-chart-line me-2"></i> Statistics</h5>
                            <ul class="list-group list-group-flush bg-transparent">
                                <li class="list-group-item bg-transparent text-light border-secondary">
                                    <strong>Total Links:</strong> {{ $mylink->total() }}
                                </li>
                                <li class="list-group-item bg-transparent text-light border-secondary">
                                    <strong>Last Activity:</strong> {{ $whoami->updated_at->diffForHumans() }}
                                </li>
                                <li class="list-group-item bg-transparent text-light border-secondary">
                                    <strong>Role</strong> {{ $whoami->is_admin ?'admin':'user' }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-dark text-white-50">
            <small><i class="fas fa-info-circle me-1"></i> Last updated: {{ $whoami->updated_at->format('Y-m-d H:i:s') }}</small>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="card bg-dark border-secondary shadow-lg">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0 text-center">
                <i class="fas fa-plus-circle me-2"></i>Bulk Link Import (JSON Format)
            </h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('bulk') }}" id="bulkForm" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label text-light" for="json_data">JSON Data:</label>
                    <textarea class="form-control bg-dark text-light border-secondary" 
                              name="json_data" 
                              id="json_data" 
                              rows="15" 
                              placeholder='[{"title":"Example","link":"https://example.onion","category":"marketplace"},...]'
                              required></textarea>
                    <div class="form-text text-muted">Enter valid JSON array of link objects</div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-light" for="json_file">Or Upload JSON File:</label>
                    <input class="form-control bg-dark text-light border-secondary" 
                           type="file" 
                           name="json_file" 
                           id="json_file"
                           accept=".json,application/json">
                    <div class="form-text text-muted">Max 2MB .json file</div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="overwrite" id="overwrite">
                        <label class="form-check-label text-light" for="overwrite">
                            Overwrite existing links
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i>Process Bulk Import
                    </button>
                </div>

                <div class="mt-3">
                    <div class="alert alert-info">
                        <strong>JSON Format Example:</strong>
                        <pre class="mt-2 mb-0">[
    {
        "title": "Example Market",
        "link": "https://examplemarket.onion",
        "category": "marketplace"
    },
    {
        "title": "Chat Room",
        "link": "https://chatroom.onion",
        "category": "chat room"
    }
]</pre>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container-fluid mt-4">
    <div class="card bg-dark border-secondary shadow-lg">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0 text-center">
                <i class="fas fa-plus-circle me-2"></i>Add New Link (single link add)
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('useradd') }}" method="POST">
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
                           placeholder="https://example.onion">
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
                <i class="fas fa-link me-2"></i>List Links : {{$mylink->total()}}
            </h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Links</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Catagory</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mylink as $index => $item)
                        <tr>
                            <td class="text-center">{{ $mylink->firstItem() + $index }}</td>
                            <td>{{ $item->link }}</td>
                            <td>{{$item->title}}</td>
                            <td class="bg-danger">{{$item->catagory}}</td>
                            <td class="text-center">
                                <form method="POST" action="{{ route('dawdel') }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="link_id" value="{{ $item->id }}">
                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
                    Showing {{ $mylink->firstItem() }} to {{ $mylink->lastItem() }} of {{ $mylink->total() }} entries
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item {{ $mylink->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link bg-dark border-secondary" href="{{ $mylink->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        @for ($i = 1; $i <= $mylink->lastPage(); $i++)
                            <li class="page-item {{ $mylink->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link bg-dark border-secondary" href="{{ $mylink->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ !$mylink->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link bg-dark border-secondary" href="{{ $mylink->nextPageUrl() }}" aria-label="Next">
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