@extends('coordinator.coordinator_master')
@section('coordinator')
<div class="container-fluid px-4">
    <h1 class="mt-4">Programs</h1>
    <ol class="breadcrumb mb-4 px-1">
        <li class="breadcrumb-item active">Manage Programs</li>
    </ol>
    <div class="pull-right mb-4">
        <a class="btn btn-purple" href="{{ route('programs.create') }}"> Add New Program</a>
    </div>
    <div class="row px-3">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Code</th>
                    <th scope="col">Program Name</th>
                    <th scope="col">Coordinator</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $number = 0; ?>
                @foreach ($programs as $p)
                    <?php $number++; ?>
                    <tr>
                        <td>{{ $number }}</td>
                        <td>{{ $p->code }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->coordinator->name }}</td>
                        <td>
                            <form action="{{ route('programs.destroy', $p->id) }}" method="POST">

                                <a class="btn btn-purple"
                                    href="{{ route('programs.show', $p->id) }}">Show</a>

                                <a class="btn btn-purple"
                                    href="{{ route('programs.edit', $p->id) }}">Edit</a>

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-purple">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
@endsection
