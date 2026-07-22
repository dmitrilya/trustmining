<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-text-size-adjust: none;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f1f5f9; padding: 20px 0;">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%"
                    style="max-width: 600px; background-color: #ffffff; border: 1px border-slate-200; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                    <tr>
                        <td align="center" style="padding: 25px 0;">
                            <img src="{{ url('/img/logo-full.png') }}" alt="Logo" style="display: block; height: 40px; border: 0;">
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 30px 25px; text-align: left;">
                            <h2 style="margin: 0 0 15px 0; font-size: 18px; font-bold; color: #1e293b;">
                                {{ $title }}
                            </h2>
                            <p style="margin: 0 0 25px 0; font-size: 14px; line-height: 1.6; color: #475569; white-space: pre-line;">
                                {!! $body !!}
                            </p>

                            @if ($link)
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td align="center" style="padding-bottom: 10px;">
                                            <a href="{{ $link }}" target="_blank"
                                                style="display: inline-block; padding: 12px 30px; font-size: 14px; font-weight: bold; color: #ffffff; background-color: #4f46e5; border-radius: 30px; text-decoration: none;">
                                                {{ $linkText }}
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px 25px; background-color: #f8fafc; border-t: 1px solid #e2e8f0; text-align: center;">
                            <p style="margin: 0 0 12px 0; font-size: 12px; color: #64748b;">
                                <a href="{{ url('/') }}" target="_blank"
                                    style="color: #4f46e5; text-decoration: none; margin: 0 10px;">{{ __('Home') }}</a> |
                                <a href="{{ route('calculator') }}" target="_blank"
                                    style="color: #4f46e5; text-decoration: none; margin: 0 10px;">{{ __('Mining calculator') }}</a> |
                                <a href="{{ route('support') }}" target="_blank"
                                    style="color: #4f46e5; text-decoration: none; margin: 0 10px;">{{ __('Support') }}</a>
                            </p>

                            <p style="margin: 0; font-size: 11px; line-height: 1.4; color: #94a3b8;">
                                {{ __('You received this email because you enabled email notifications in your profile.') }}<br>
                                <a href="{{ $unsubscribeLink }}" target="_blank"
                                    style="color: #ef4444; text-decoration: underline;">
                                    {{ __('Unsubscribe') }}
                                </a>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
