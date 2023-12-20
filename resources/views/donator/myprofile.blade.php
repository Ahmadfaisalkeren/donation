<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Profile</title>

    @include('donator.components.css')
</head>

<body>
    @include('donator.navbar')

    <div class="container mt-3">
        <div class="card">
            <div class="card-header bg-donker">
                <p class="text-white">My Profile</p>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                        @foreach ($myprofile as $user)
                            <tr>
                                <td>Name</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <!-- Add more profile fields as needed -->
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('donator.components.scripts')
</body>

</html>
