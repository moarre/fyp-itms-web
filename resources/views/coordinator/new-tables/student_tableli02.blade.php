<?php $number = 0; ?>
@foreach ($students as $student)
    <?php $number++; ?>
    <tr>
        {{-- <td>
            <div class="form-group">
                <input type="checkbox" class="check_item" name="check_item[]" value="{{ $student->id }}">
            </div>
        </td> --}}
        <td>{{ $number }}</td>
        <td>{{ $student->student_number }}</td>
        <td>{{ $student->fullname }}</td>
        <td>{{ Arr::get($student, 'program.code') }}</td>
        <td>{{ Arr::get($student, 'semester.session') }}</td>
        <td>
            @if ($student->li02_id)
                <a class="btn btn-purple"
                    href="{{ route('bli02.view', $student->li02_id) }}">View</a>

                <a class="btn btn-purple"
                    href="{{ route('bli02.download', $student->li02_id) }}">Download
                </a>
            @else
                <b>No BLI02 Available</b>
            @endif

        </td>
    </tr>
@endforeach
