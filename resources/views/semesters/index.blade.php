@extends('semesters.semester_master')
@section('semesters')
<div class="container-fluid px-4">
    <h1 class="mt-4">Semesters</h1>
    <ol class="breadcrumb mb-4 px-1">
        <li class="breadcrumb-item active">Manage Semesters</li>
    </ol>
    <div class="pull-right mb-4">
        <a class="btn btn-success" href="{{ route('semesters.create') }}"> Add New Semester</a>
    </div>
    <div class="row px-3">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Session</th>
                    <th scope="col">Semester</th>
                    <th scope="col">Year</th>
                    <th scope="col">Coordinator</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $number = 0; ?>
                @foreach ($semesters as $s)
                    <?php $number++; ?>
                    <tr>
                        <td>{{ $number }}</td>
                        <td>{{ $s->session }}</td>
                        <td>{{ $s->numSemester }}</td>
                        <td>{{ $s->yearSemester }}</td>
                        <td>{{ $s->coordinator->name }}</td>
                        <td>
                            <form action="{{ route('semesters.destroy', $s->id) }}" method="POST">

                                <a class="btn btn-info"
                                    href="{{ route('semesters.show', $s->id) }}">Show</a>

                                <a class="btn btn-primary"
                                    href="{{ route('semesters.edit', $s->id) }}">Edit</a>

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
@endsection
