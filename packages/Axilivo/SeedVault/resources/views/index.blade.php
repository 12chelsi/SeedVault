 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeedVault Snapshots</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-4 bg-white shadow mt-10">

    <h1 class="text-2xl font-bold mb-4">📦 SeedVault Snapshots</h1>

    @if(session('success'))
        <div class="p-2 mb-4 bg-green-200">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="p-2 mb-4 bg-red-200">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ url('seedvault/create') }}">
        @csrf
        <button type="submit" class="mb-4 bg-blue-500 text-white px-4 py-2 rounded">Create Snapshot</button>
    </form>

    <form method="POST" action="{{ url('seedvault/restore') }}">
        @csrf
        <table class="table-auto w-full mb-4 border">
            <thead>
                <tr>
                    <th class="border p-2"><input type="checkbox" id="select-all-restore"></th>
                    <th class="border p-2">Snapshot File</th>
                </tr>
            </thead>
            <tbody>
                @foreach($files as $file)
                    <tr>
                        <td class="border p-2"><input type="checkbox" name="snapshots[]" value="{{ $file->getFilename() }}"></td>
                        <td class="border p-2">{{ $file->getFilename() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Restore Selected</button>
    </form>

    <form method="POST" action="{{ url('seedvault/delete') }}">
        @csrf
        @method('DELETE')

        <table class="table-auto w-full border">
            <thead>
                <tr>
                    <th class="border p-2"><input type="checkbox" id="select-all-delete"></th>
                    <th class="border p-2">Snapshot File</th>
                </tr>
            </thead>
            <tbody>
                @foreach($files as $file)
                    <tr>
                        <td class="border p-2"><input type="checkbox" name="snapshots[]" value="{{ $file->getFilename() }}"></td>
                        <td class="border p-2">{{ $file->getFilename() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded mt-4">Delete Selected</button>
    </form>

</div>

<script>
    document.getElementById('select-all-restore').addEventListener('click', function () {
        document.querySelectorAll('form[action$="restore"] input[type="checkbox"]').forEach(cb => cb.checked = this.checked);
    });

    document.getElementById('select-all-delete').addEventListener('click', function () {
        document.querySelectorAll('form[action$="delete"] input[type="checkbox"]').forEach(cb => cb.checked = this.checked);
    });
</script>

</body>
</html>
