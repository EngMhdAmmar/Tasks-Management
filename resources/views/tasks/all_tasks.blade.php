@extends('layouts.tasks_url') @section('content') @use('App\Enums\ScheduleType') @use('App\Enums\Priority')
<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="#">
                    <h2 class="brand-text">IxCoders</h2>
                </a>
            </li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('profile.show') }}"><i
                            data-feather="user"></i><span class="menu-title text-truncate"
                            data-i18n="Email">Profile</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('tasks.index') }}"><i
                            data-feather="check"></i><span class="menu-title text-truncate" data-i18n="Email">My Leading
                            Tasks</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('tasks.user') }}"><i
                            data-feather="check-square"></i><span class="menu-title text-truncate" data-i18n="Email">My
                            Tasks</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('tasks.all') }}"><i
                            data-feather="list"></i><span class="menu-title text-truncate" data-i18n="Email">All
                            Tasks</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('logout') }}"><i
                            data-feather="log-out"></i><span class="menu-title text-truncate"
                            data-i18n="Email">Logout</span></a>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
<!-- BEGIN: Content-->
<div class="app-content content todo-application">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-area-wrapper container-xxl p-0">
        <div class="sidebar-left">
            <div class="sidebar">
                <div class="sidebar-content todo-sidebar">
                    <div class="todo-app-menu">
                        <div class="add-task" style="display: flex; justify-content: space-evenly">
                            @if ($tasks->previousPageUrl())
                            <a href="{{ $tasks->previousPageUrl() }}" class="btn btn-primary">Previous</a> @else
                            <a class="btn btn-outline-secondary" disabled>Previous</a> @endif @if ($tasks->hasMorePages())
                            <a href="{{ $tasks->nextPageUrl() }}" class="btn btn-primary">Next</a> @else
                            <a class="btn btn-outline-secondary" disabled>Next</a> @endif
                        </div>
                        <div class="sidebar-menu-list">
                            <div class="list-group list-group-labels">
                                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="bullet bullet-sm bullet-primary me-1"></span>To Do Last
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="bullet bullet-sm bullet-warning me-1"></span>Normal
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="bullet bullet-sm bullet-danger me-1"></span>Important
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-right">
            <div class="content-wrapper container-xxl p-0">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <div class="body-content-overlay"></div>
                    <div class="todo-app-list">
                        <!-- Todo search starts -->
                        <div class="app-fixed-search d-flex align-items-center">
                            <div class="sidebar-toggle d-block d-lg-none ms-1">
                                <i data-feather="menu" class="font-medium-5"></i>
                            </div>
                            <div class="d-flex align-content-center justify-content-between w-100">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i data-feather="search"
                                                class="text-muted"></i></span>
                                    <input type="text" class="form-control" id="todo-search" placeholder="Search task" aria-label="Search..." aria-describedby="todo-search" />
                                </div>
                            </div>
                        </div>
                        <!-- Todo search ends -->
                        <!-- Todo List starts -->
                        <div class="todo-task-list-wrapper list-group">
                            <ul class="todo-task-list media-list" id="todo-task-list">
                                @foreach ($tasks as $task)
                                <li class="todo-item" id="todo-item-{{ $task->id }}" onclick="openCommetsModal(this)">
                                    <div class="todo-title-wrapper">
                                        <div class="todo-title-area">
                                            <div class="title-wrapper">
                                                <span class="todo-title">{{ $task->title }}</span>
                                            </div>
                                        </div>
                                        <div class="todo-item-action">
                                            <div class="badge-wrapper me-1">
                                                @if ($task->priority == Priority::To_Do_Last)
                                                <span class="badge rounded-pill badge-light-primary">To Do
                                                                Last</span> @elseif ($task->priority == Priority::Normal)
                                                <span class="badge rounded-pill badge-light-warning">Normal</span> @elseif($task->priority == Priority::Important)
                                                <span class="badge rounded-pill badge-light-danger">Important</span> @endif
                                            </div>
                                            <small class="text-nowrap text-muted me-1">{{ \Carbon\Carbon::parse($task->dead_line)->format('Y-m-d') }}</small>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            <div class="no-results">
                                <h5>No Items Found</h5>
                            </div>
                        </div>
                        <!-- Todo List ends -->
                    </div>
                    <!-- Right Sidebar starts -->
                    @if (isset($task))
                    <div class="modal modal-slide-in sidebar-todo-modal fade" id="comment-modal">
                        <div class="modal-dialog sidebar-lg">
                            <div class="modal-content p-0">
                                <form id="form-modal-todo-edit" class="todo-modal needs-validation" action=" {{ isset($task) ? route('comment.store', $task->id) : '' }}" method="POST" enctype="multipart/form-data"> @csrf @method('POST')
                                    <div class="modal-header align-items-center mb-1">
                                        <h5 class="modal-title">Edit Task</h5>
                                        <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                                            <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                                        </div>
                                    </div>
                                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                        <div class="action-tags">
                                            <div class="mb-1">
                                                <label for="formFile" class="form-label">Attachment</label>
                                                <input name="file" class="form-control " type="file" id="formFile">
                                            </div>
                                            <div class="mb-1">
                                                <label class="form-label">Comment</label>
                                                <input type="hidden" id="descriptionInput1" name="comment" class="@error('description') is-invalid @enderror"> @error('description')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                                <div id="task-desc1" class="border-bottom-0 edit-task-description" data-placeholder="Write A Comment"></div>
                                                <div class="d-flex justify-content-end desc-toolbar border-top-0 ql-toolbar ql-snow">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="my-1">
                                            <input type="submit" value="Send" class="btn btn-primary update-todo-item me-1">
                                            <button type="button" class="btn btn-outline-secondary add-todo-item me-1" data-bs-dismiss="modal">Back</button>
                                        </div>
                                        <div class="my-1">
                                            <div class="todo-task-list-wrapper list-group">
                                                <ul class="todo-task-list media-list" id="todo-task-list">
                                                    @foreach ($task->comments as $comment)
                                                    <a href="{{ route('comment.download', $comment->id) }}">
                                                        <li class="todo-item" id="todo-item">
                                                            <div class="todo-title-wrapper">
                                                                <div class="todo-title-area">
                                                                    @if ($comment->attachment != null)
                                                                    <i data-feather="paperclip"></i> @endif
                                                                    <div class="title-wrapper">
                                                                        <span class="todo-title" style="word-wrap: break-word; width: 250px">{{ $comment->comment }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="todo-item-action">
                                                                    <div class="badge-wrapper me-1">
                                                                    </div>
                                                                    <small class="text-nowrap text-muted me-1">{{ $comment->user->name }}</small>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </a>
                                                    @endforeach
                                                </ul>
                                                <div class="no-results">
                                                    <h5>No Items Found</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- Right Sidebar ends -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>
<script>
    tasks = @json($tasks->items());
        function openCommetsModal(elem) {
            taskId = Number(elem.id.replace('todo-item-', ''));
            task = tasks.find(obj => obj.id == taskId);
            $("#comment-modal").modal('show');
        }
</script>
@endsection