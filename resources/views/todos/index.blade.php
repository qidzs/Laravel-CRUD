<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Simple To-Do List</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="text-center mb-4">To-Do List</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Form to add a task -->
                        <form action="{{ route('todos.store') }}" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" @error('task') is-invalid @enderror" name="task" placeholder="Add task here" required value="{{ old('task') }}">
                                @error('task')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <button class="btn btn-primary" type="submit">Add</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <ul class="list-group mb-4">
                            @foreach ($data as $item)
                                @if (is_null($item->deleted_at))
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="task-text">
                                            {!! $item->is_done ? '<del>' : '' !!}
                                            {{ $item->task }}
                                            {!! $item->is_done ? '</del>' : '' !!}
                                        </span>

                                        <div class="btn-group">
                                            <!-- Delete button -->
                                            <form action="{{ route('todos.delete', ['id' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm">✕</button>
                                            </form>

                                            <!-- Edit button and form -->
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->index }}">✎</button>
                                        </div>
                                    </li>
                                    <li class="list-group-item collapse" id="collapse-{{ $loop->index }}">
                                        <form action="{{ route('todos.update', ['id' => $item->id]) }}" method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" @error('task') is-invalid @enderror" name="task" value="{{ $item->task }}">
                                                @error('task')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <button class="btn btn-outline-primary" type="submit">Update</button>
                                            </div>
                                            <div class="d-flex">
                                                <div class="form-check me-3">
                                                    <input class="form-check-input" type="radio" name="is_done" value="1" {{ $item->is_done ? 'checked' : '' }}>
                                                    <label class="form-check-label">Complete</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="is_done" value="0" {{ !$item->is_done ? 'checked' : '' }}>
                                                    <label class="form-check-label">Incomplete</label>
                                                </div>
                                            </div>
                                        </form>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="data-display">
        <div class="db-container">
            <br>
            <h1>Display Data</h1>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-condensed">
                    <thead>
                        <tr>
                            <th><strong>Task</strong></th>
                            <th><strong>Date</strong></th>
                            <th><strong>Time</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$item->task}}</td>
                                <td>{{$item->created_at->format('Y-m-d')}}</td>
                                <td>{{$item->created_at->format('H:i:s')}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
