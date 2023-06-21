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
        <td>{{ Arr::get($student, 'program.code') }}</td>
        <td>{{ Arr::get($student, 'semester.session') }}</td>
        <td>
            <form action="{{ route('coordinator.destroy', $student->id) }}" id="delete-form" method="POST">

                <a class="btn btn-purple" href="{{ route('bli02.view', $student->li02_id) }}">View</a>

                <a class="btn btn-purple" href="{{ route('bli02.download', $student->li02_id) }}">Download
                </a>

                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-purple">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
