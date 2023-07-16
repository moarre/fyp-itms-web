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
            <a class="btn btn-purple" href="{{ route('bli03.view', $student->id) }}">Show
                Details</a>

            <a class="btn btn-purple" href="{{ route('bli04.email', $student->id) }}">Email the
                Company</a>
        </td>
    </tr>
@endforeach