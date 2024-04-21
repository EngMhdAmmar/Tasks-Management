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
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{route('tasks.all')}}"><i data-feather="list"></i><span
                            class="menu-title text-truncate" data-i18n="Email">All Tasks</span></a>
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
                        <div class="add-task">
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#new-task-modal">
                                Add Task
                            </button>
                        </div>
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
                                <li class="todo-item" id="todo-item-{{ $task->id }}" onclick="openEditModal(this)">
                                    <div class="todo-title-wrapper">
                                        <div class="todo-title-area">
                                            <div class="title-wrapper">
                                                <span class="todo-title">{{ $task->title }}</span>
                                            </div>
                                        </div>
                                        <div class="todo-item-action">
                                            <div class="badge-wrapper me-1">
                                                @if ($task->priority == Priority::To_Do_Last)
                                                <span class="badge rounded-pill badge-light-primary">To Do Last</span> @elseif ($task->priority == Priority::Normal)
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
                    <!-- Begin Add Task -->
                    <div class="modal modal-slide-in sidebar-todo-modal fade" id="new-task-modal">
                        <div class="modal-dialog sidebar-lg">
                            <div class="modal-content p-0">
                                <form id="form-modal-todo" class="todo-modal" action="{{ route('tasks.store') }}" method="POST">
                                    @csrf @method('POST')
                                    <div class="modal-header align-items-center mb-1">
                                        <h5 class="modal-title">Add Task</h5>
                                        <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                                            <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                                        </div>
                                    </div>
                                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                        <div class="action-tags">
                                            <div class="mb-1">
                                                <label for="todoTitleAdd" class="form-label">Title</label>
                                                <input type="text" id="todoTitleAdd" name="title" class="new-todo-item-title form-control @error('title') is-invalid @enderror" placeholder="Title" /> @error('title')
                                                <div class="alert alert-danger">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="mb-1">
                                                <label for="task-due-date" class="form-label">DeadLine</label>
                                                @error('dead_line')
                                                <div class="alert alert-danger">{{ $message }}</div>@enderror
                                                <input type="text" class="form-control task-due-date @error('dead_line') is-invalid @enderror" id="task-due-date" name="dead_line" />
                                            </div>
                                            <div class="mb-1">
                                                <label for="task-tag" class="form-label d-block">Schedule</label>
                                                <select class="form-select task-tag" id="task-tag" name="schedule">
                                                    @foreach (ScheduleType::cases() as $type)
                                                    <option value="{{ $type->value }}">
                                                        {{ str($type->name)->replace('_', ' ') }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-1">
                                                <label for="task-priority" class="form-label d-block">Priority</label>
                                                <select class="form-select task-tag" id="task-tag" name="priority">
                                                    @foreach (Priority::cases() as $priority)
                                                    <option value="{{ $priority->value }}">
                                                        {{ str($priority->name)->replace('_', ' ') }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-1">
                                                <label for="task-tag" class="form-label d-block">To User</label>
                                                <select class="form-select task-tag" id="task-tag" name="user_id">
                                                    @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-1">
                                                <label class="form-label">Description</label>
                                                <input type="hidden" id="descriptionInput" name="description" class="@error('description') is-invalid @enderror">
                                                <div id="task-desc" class="border-bottom-0" data-placeholder="Write Your Description"></div>
                                                <div class="d-flex justify-content-end desc-toolbar border-top-0">
                                                </div>
                                                @error('description')
                                                <div class="alert alert-danger">{{ $message }}</div>@enderror
                                            </div>
                                        </div>
                                        <div class="my-1">
                                            <input type="submit" value="Add" class="btn btn-primary d-none add-todo-item me-1">
                                            <button type="button" class="btn btn-outline-secondary add-todo-item d-none" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Add Task -->
                    <!-- Begin Edit Task -->
                    <div class="modal modal-slide-in sidebar-todo-modal fade" id="edit-task-modal">
                        <div class="modal-dialog sidebar-lg">
                            <div class="modal-content p-0">
                                <form id="form-modal-todo-edit" class="todo-modal needs-validation" action="action=" {{ isset($task) ? route( 'tasks.update', $task->id) : '' }}" " method="POST"> @csrf @method('POST')
                                    <div class="modal-header align-items-center mb-1">
                                        <h5 class="modal-title">Edit Task</h5>
                                        <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                                            <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                                        </div>
                                    </div>
                                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                        <div class="action-tags">
                                            <div class="mb-1">
                                                <label for="edit-todo-title" class="form-label">Title</label>
                                                <input type="text" id="edit-todo-title" name="title" class="edit-todo-item-title form-control @error('title') is-invalid @enderror" placeholder="Title" /> @error('title')
                                                <div class="alert alert-danger">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="mb-1">
                                                <label for="task-due-date" class="form-label">DeadLine</label>
                                                <input type="text" class="form-control task-due-date @error('dead_line') is-invalid @enderror" id="task-due-date" name="dead_line" /> @error('dead_line')
                                                <div class="alert alert-danger">{{ $message }}</div>@enderror
                                            </div>
                                            <div class="mb-1">
                                                <label for="task-tag" class="form-label d-block">Schedule</label>
                                                <select class="form-select task-tag" id="task-tag" name="schedule">
                                                    @foreach (ScheduleType::cases() as $type)
                                                    <option value="{{ $type->value }}">{{ str($type->name)->replace('_', ' ') }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-1">
                                                <label for="task-priority" class="form-label d-block">Priority</label>
                                                <select class="form-select task-tag" id="task-priority" name="priority">
                                                    @foreach (Priority::cases() as $priority)
                                                    <option value="{{ $priority->value }}">
                                                        {{ str($priority->name)->replace('_', ' ') }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-1">
                                                <label for="task-user" class="form-label d-block">To User</label>
                                                <select class="form-select task-tag" id="task-user" name="user_id">
                                                    @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-1">
                                                <label class="form-label">Description</label>
                                                <input type="hidden" id="descriptionInput1" name="description" class="@error('description') is-invalid @enderror"> @error('description')
                                                <div class="alert alert-danger">{{ $message }}</div>@enderror
                                                <div id="task-desc1" class="border-bottom-0 edit-task-description" data-placeholder="Write Your Description"></div>
                                                <div class="d-flex justify-content-end desc-toolbar border-top-0 ql-toolbar ql-snow">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="my-1">
                                            <input type="submit" value="Update" class="btn btn-primary update-todo-item me-1">
                                            <a  id="delete-btn" class="btn btn-outline-danger me-1"> Delete </a>
                                            <button type="button" class="btn btn-outline-secondary add-todo-item me-1" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Edit Task -->
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
    function openEditModal(elem) {
            taskId = Number(elem.id.replace('todo-item-', ''));
            task = tasks.find(obj => obj.id == taskId);
            console.log(task);
            $("#edit-task-modal").modal('show');
            let form = $("#form-modal-todo-edit");
            url = '{{ route('tasks.update', ':id') }}'
            url = url.replace(":id", taskId);
            form.attr("action", url);
            deleteUrl = '{{ route('tasks.destroy', ':id') }}'
            deleteUrl = deleteUrl.replace(":id", taskId);
            $('#delete-btn').attr('href', deleteUrl);
            form.find('#edit-todo-title').val(task.title);
            form.find('#task-due-date').val(task.dead_line.substring(0, 10));
            form.find('#task-tag').val(task.schedule);
            form.find('#task-priority').val(task.priority);
            form.find('#task-user').val(task.user_id);
            form.find('.edit-task-description .ql-editor').text(task.description);
        }
</script>
@endsection