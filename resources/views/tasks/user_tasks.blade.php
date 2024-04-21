@extends('layouts.tasks_url') @section('content')
    @use('App\Enums\ScheduleType') @use('App\Enums\Priority')
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
                                    <a href="{{ $tasks->previousPageUrl() }}" class="btn btn-primary">Previous</a>
                                @else
                                    <a class="btn btn-outline-secondary" disabled>Previous</a>
                                    @endif @if ($tasks->hasMorePages())
                                        <a href="{{ $tasks->nextPageUrl() }}" class="btn btn-primary">Next</a>
                                    @else
                                        <a class="btn btn-outline-secondary" disabled>Next</a>
                                    @endif
                            </div>
                            <div class="sidebar-menu-list">
                                <div class="list-group list-group-labels">
                                    <a href="#"
                                        class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="bullet bullet-sm bullet-primary me-1"></span>To Do Last
                                    </a>
                                    <a href="#"
                                        class="list-group-item list-group-item-action d-flex align-items-center">
                                        <span class="bullet bullet-sm bullet-warning me-1"></span>Normal
                                    </a>
                                    <a href="#"
                                        class="list-group-item list-group-item-action d-flex align-items-center">
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
                                        <input type="text" class="form-control" id="todo-search"
                                            placeholder="Search task" aria-label="Search..."
                                            aria-describedby="todo-search" />
                                    </div>
                                </div>
                            </div>
                            <!-- Todo search ends -->
                            <!-- Todo List starts -->
                            <div class="todo-task-list-wrapper list-group">
                                <ul class="todo-task-list media-list" id="todo-task-list">
                                    @foreach ($tasks as $task)
                                        <li class="todo-item" id="todo-item-{{ $task->id }}"
                                            onclick="openStatusModal(this)">
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
                                                                Last</span>
                                                        @elseif ($task->priority == Priority::Normal)
                                                            <span
                                                                class="badge rounded-pill badge-light-warning">Normal</span>
                                                        @elseif($task->priority == Priority::Important)
                                                            <span
                                                                class="badge rounded-pill badge-light-danger">Important</span>
                                                        @endif
                                                    </div>
                                                    <small
                                                        class="text-nowrap text-muted me-1">{{ \Carbon\Carbon::parse($task->dead_line)->format('Y-m-d') }}</small>
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
                            <div class="modal modal-slide-in sidebar-todo-modal fade" id="edit-task-modal">
                                <div class="modal-dialog sidebar-lg">
                                    <div class="modal-content p-0">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title"></h4>
                                                <div class="d-flex">
                                                    <div class="author-info">
                                                        <small class="text-muted me-25">by</small>
                                                        <small class="text-body" id="leader-name"></small>
                                                        <br>
                                                        <small class="text-muted me-25">Created</small>
                                                        <smallt class="text-muted" id="created-at"></smallt>
                                                        <span class="text-muted ms-50 me-25">|</span>
                                                        <small class="text-muted me-25">Deadline</small>
                                                        <small class="text-muted" id="dead-line"></small>
                                                    </div>
                                                </div>
                                                <div class="my-1 py-25" id="schedule-priority">
                                                </div>
                                                <p class="card-text mb-2" id="description">
                                                </p>
                                                <hr class="my-2" />
                                                <div class="col-xl-6 col-12" style="width: 100%">
                                                    <div class="card">
                                                        <div
                                                            class="
                                card-header
                                d-flex
                                flex-sm-row flex-column
                                justify-content-md-between
                                align-items-start
                                justify-content-start
                                ">
                                                        </div>
                                                        <div class="card-body">
                                                            <div id="radialbars-chart"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="my-2" />
                                                <div class="my-1">
                                                    <span id="btn-approve"></span>
                                                    <button type="button"
                                                        class="btn btn-outline-secondary add-todo-item me-1"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
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
        let chart;
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                chart: {
                    height: 350,
                    type: 'radialBar',
                },
                series: [0],
                labels: ['Progress'],
            }
            chart = new ApexCharts(document.querySelector("#radialbars-chart"), options);
            chart.render();
        });

        function openStatusModal(elem) {
            taskId = Number(elem.id.replace('todo-item-', ''));
            task = tasks.find(obj => obj.id == taskId);
            $("#card-title").html(task.title);
            $("#leader-name").html(task.leader.name);
            $("#created-at").html(task.created_at.substring(0, 10));
            $("#dead-line").html(task.dead_line.substring(0, 10));
            let html = `<span class="badge rounded-pill badge-light-`;
            if (task.priority == 0)
                html += `primary">To Do Last </span>`;
            else if (task.priority == 1) {
                html += `warning">Normal </span>`;
            } else {
                html += `danger">Important </span>`;
            }
            html += `<span class="badge rounded-pill badge-light-`
            if (task.schedule == 0)
                html += `success">None </span>`;
            else if (task.schedule == 1) {
                html += `danger">Daily </span>`;
            } else if (task.schedule == 2) {
                html += `warning">Weekly </span>`;
            } else {
                html += `primary">Monthly </span>`;
            }
            let btn;
            let url = '{{ route('tasks.approveAndComplete', ':id') }}'
            url = url.replace(":id", task.id);
            if (task.status == 0) {
                btn = `<a href="` + url + `"class="btn btn-outline-primary update-todo-item me-1"> Approve </a>`;
            } else if (task.status == 1) {
                btn = `<a href="` + url + `"class="btn btn-outline-primary update-todo-item me-1"> Mark as completed </a>`;
            } else {
                btn = `<a class="btn btn-outline-success update-todo-item me-1"> completed </a>`;
            }
            $("#btn-approve").html(btn);
            $("#schedule-priority").html(html);
            $("#description").html(task.description);
            let series;
            if (task.status == 2) {
                series = [100];
            } else if (task.status == 1) {
                series = [67];
            } else {
                series = [33]
            }
            chart.updateSeries(series)
            $("#edit-task-modal").modal('show');
        }
    </script>
@endsection
