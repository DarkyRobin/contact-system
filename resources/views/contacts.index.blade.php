<div class="card">
    <div class="card-header">{{ __('Dashboard') }}</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @section('content')
            <!-- Search form -->
            <form id="search-form">
                <input type="text" name="keyword" id="keyword" placeholder="Search...">
                <button type="submit">Search</button>
            </form>
            <div id="contacts-list">
                <h2>Contacts</h2>
                <!-- Display contacts here -->
                @if ($contacts->isEmpty())
                    <p>No contacts found.</p>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->phone }}</td>
                                    <td>
                                        <form action="{{ route('contacts.destroy', $contact) }}" method="POST"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this contact?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination links -->
                    {{ $contacts->links() }}
                @endif
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script>
                // AJAX Search
                $('#search-form').submit(function(event) {
                    event.preventDefault();
                    var keyword = $('#keyword').val();
                    $.ajax({
                        url: '{{ route('contacts.search') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            keyword: keyword
                        },
                        success: function(response) {
                            $('#contacts-list').html(response);
                        }
                    });
                });

                // AJAX Delete
                $(document).on('submit', '.delete-form', function(event) {
                    event.preventDefault();
                    var form = $(this);
                    if (window.confirm('Are you sure you want to delete this contact?')) {
                        $.ajax({
                            url: form.attr('action'),
                            method: 'POST',
                            data: form.serialize(),
                            success: function(response) {
                                $('#contacts-list').html(response);
                            }
                        });
                    }
                });

                // Add contact
                $('#add-contact-form').submit(function(event) {
                    event.preventDefault();
                    var form = $(this);
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            $('#contacts-list').html(response);
                            form[0].reset();
                        }
                    });
                });
            </script>
        @endsection
        {{ __('You are logged in!') }}
    </div>
