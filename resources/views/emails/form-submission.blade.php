<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: sans-serif; color: #0b1220;">
    <h2 style="margin-bottom: 4px;">{{ $formName }}</h2>

    @if ($bodyMessage)
        <p style="white-space: pre-line;">{{ $bodyMessage }}</p>
    @endif

    <table cellpadding="6" style="border-collapse: collapse; margin-top: 16px;">
        @foreach ($data as $key => $value)
            <tr>
                <td style="font-weight: bold; border-bottom: 1px solid #e5e7eb; vertical-align: top;">{{ $key }}</td>
                <td style="border-bottom: 1px solid #e5e7eb; white-space: pre-line;">{{ $value }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
