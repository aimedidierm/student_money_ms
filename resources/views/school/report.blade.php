<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Students list report</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-opacity-50">
    <div style="margin: auto; padding: 16px; max-width: 100%;">
        <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem;">List of all students in school</h2>

        <table style="width: 100%; border-collapse: collapse; border: 1px solid #e2e8f0;">
            <thead>
                <tr>
                    <th style="padding: 8px; border: 1px solid #0c0c0c;">Creation date</th>
                    <th style="padding: 8px; border: 1px solid #101111;">Name</th>
                    <th style="padding: 8px; border: 1px solid #101111;">Reg number</th>
                    <th style="padding: 8px; border: 1px solid #101111;">Parent</th>
                    <th style="padding: 8px; border: 1px solid #101111;">Balance</th>
            <tbody>
                @if ($students->isEmpty())
                <tr>
                    <td style="padding: 8px; border: 1px solid #0c0c0c;" colspan="5">No available students</td>
                </tr>
                @else
                @foreach ($students as $student)
                <tr>
                    <td style="padding: 8px; border: 1px solid #0c0c0c;">{{$student->created_at}}</td>
                    <td style="padding: 8px; border: 1px solid #0c0c0c;">{{$student->name}}</td>
                    <td style="padding: 8px; border: 1px solid #0c0c0c;">{{$student->regNumber}}</td>
                    <td style="padding: 8px; border: 1px solid #0c0c0c;">
                        @if ($student->parent != null)
                        {{$student->parent->name}}
                        @else
                        Not connected
                        @endif
                    </td>
                    <td style="padding: 8px; border: 1px solid #0c0c0c;">{{$student->balance}} Rwf</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</body>

</html>