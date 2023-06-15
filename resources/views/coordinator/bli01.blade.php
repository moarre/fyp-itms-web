@extends('coordinator.coordinator_master')
@section('coordinator')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Coordinator (BLI-01)</h1>
        <div class="btn-group pull-right mb-4">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-expanded="false">
                Manage Students
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="{{ route('programs.index') }}"> Program</a></li>
                <li><a class="dropdown-item" href="{{ route('semesters.index') }}"> Semester</a></li>
            </ul>
        </div>

        <div class="row px-3 mb-3" id="searche">
            <h2 class="mt-4">Search Students</h2>
            {{-- Filter section start --}}
            <form method="GET" id="search-form">
                <div class="mb-3">
                    <div class="input-group mb-2">
                        <input type="text" name="name" class="form-control" placeholder="Name">
                    </div>
                    <div class="input-group mb-2">
                        <input type="text" name="ic" class="form-control" placeholder="IC">
                    </div>
                    <div class="input-group mb-2">
                        <input type="text" name="student_number" class="form-control" placeholder="Student Number">
                    </div>
                    <div class="input-group mb-2">
                        <input type="text" name="program_code" class="form-control" placeholder="Program Code">
                    </div>
                    <div class="input-group mb-2">
                        <input type="text" name="semester" class="form-control" placeholder="Semester">
                    </div>
                    @csrf
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
            {{-- Filter section end --}}
        </div>


        <div class="row px-3">
            <h2 class="mt-4">List of Students</h2>
            <form method="POST" id="pdf-form" action="{{ route('coordinator.pdf.upload') }}">
                <table class="table table-striped table-hover" id="student-table">
                    <thead>
                        <tr>
                            <th scope="col">
                                <div class="form-group">
                                    <input type="checkbox" class="check_all" name="check_all">
                                </div>
                            </th>
                            <th scope="col">Bil</th>
                            <th scope="col">Student Number</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Program</th>
                            <th scope="col">Session</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $number = 0; ?>
                        @foreach ($students as $student)
                            <?php $number++; ?>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <input type="checkbox" class="check_item" name="check_item[]"
                                            value="{{ $student->id }}">
                                    </div>
                                </td>
                                <td>{{ $number }}</td>
                                <td>{{ $student->student_number }}</td>
                                <td>{{ $student->fullname }}</td>
                                <td>{{ Arr::get($student, 'program.code') }}</td>
                                <td>{{ Arr::get($student, 'semester.session') }}</td>
                                <td>
                                    <form action="{{ route('coordinator.destroy', $student->id) }}" id="delete-form"
                                        method="POST">

                                        <a class="btn btn-info"
                                            href="{{ route('coordinator.show', $student->id) }}">Show</a>

                                        <a class="btn btn-primary"
                                            href="{{ route('coordinator.edit', $student->id) }}">Edit</a>

                                        <a class="btn btn-warning"
                                            href="{{ route('coordinator.pdf', $student->id) }}">Generate
                                            SLI-01</a>

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @csrf
                @method('POST')
                <button type="submit" class="btn btn-primary">Generate SLI-01</button>
            </form>
        </div>
    </div>

    {{-- enable jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- checkboxes --}}
    <script>
        $(document).ready(function() {
            $('#search-form').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('coordinator.search') }}',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        console.log('success');
                        // Replace the table body with the filtered results
                        $("#student-table tbody").html(response.html);
                    },
                    error: function(error) {
                        console.log(error);
                    },
                });
            });

            // Toggle all checkboxes
            $(".check_all").click(function() {
                $(".check_item").prop("checked", $(this).prop("checked"));
            });

            // Submit form when submit button is clicked
            $("form#pdf-form").submit(function(event) {
                event.preventDefault();

                // Get the checked items
                var checkedItems = $(".check_item:checked");

                // Build an array of checked item IDs
                var itemIds = $.map(checkedItems, function(item) {
                    return $(item).val();
                });

                // Add the item IDs to the form data
                var formData = $(this).serializeArray();
                formData.push({
                    name: "item_ids",
                    value: itemIds
                });

                // Submit the form
                $.ajax({
                    url: $(this).attr("action"),
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $("#pdf-message").text(response);
                        $("#alert-pdf").removeClass("hide").addClass("show");
                    }
                });
            });

            // Delete student on form submission
            $("form#delete-form").submit(function(event) {
                event.preventDefault();

                // Get the form action
                var actionUrl = $(this).attr("action");

                // Submit the form
                $.ajax({
                    url: actionUrl,
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response);
                        location.reload();
                    }
                });
            });
        });
    </script>
@endsection
