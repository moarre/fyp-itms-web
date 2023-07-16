<?php $number = 0; ?>
@foreach ($students as $student)
    <?php $number++; ?>
    <tr>
        <td>
            <div class="form-group">
                <input type="checkbox" class="check_item" name="check_item[]" value="{{ $student->id }}">
            </div>
        </td>
        <td>{{ $number }}</td>
        <td>{{ $student->student_number }}</td>
        <td>{{ $student->fullname }}</td>
        <td>{{ $student->program->code }}</td>
        <td>{{ $student->semester->session }}</td>
        <td>
            <form action="{{ route('coordinator.destroy', $student->id) }}" id="delete-form" method="POST">
                <a class="btn btn-purple" href="{{ route('coordinator.show', $student->id) }}">Show</a>
                <a class="btn btn-purple" href="{{ route('coordinator.edit', $student->id) }}">Edit</a>
                <a class="btn btn-purple" href="{{ route('coordinator.pdf', $student->id) }}">Generate SLI-01</a>
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-purple">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
