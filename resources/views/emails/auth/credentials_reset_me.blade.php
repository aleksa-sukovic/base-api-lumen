<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Welcome to {{ env('APP_NAME') }}</title>
    <style>
        table {
            width: 500px;
            margin-left: auto;
            margin-right: auto;
            color: white;
            border-collapse: collapse;
            font-family: Arial, Helvetica, sans-serif;
        }

        thead {
            background-color: #90AFC5;
        }

        thead h1 {
            font-weight: 300;
            margin-bottom: 0.2rem;
        }

        thead p {
            font-weight: 100;
            margin-top: 0.8rem;
            font-size: 15px;
            margin-bottom: 1.5rem;
            color: rgb(255, 255, 255);
            margin-left: 1.4rem;
            margin-right: 1.4rem;
        }

        tbody {
            background-color: white;
            color: rgb(78, 90, 92);
        }

        tbody td {
            padding: 1.4rem 1rem 0 1rem;
        }

        .button {
            display: inline-block;
            padding: 1rem 2rem;
            background-color: #336B87;
            text-decoration: none;
            margin-bottom: 1.4rem;
            margin-top: 0.1rem;

            color: white;
            font-weight: bold;
            border-radius: 8px;
        }

        .button:hover {
            background-color: rgb(41, 83, 104);
            cursor: pointer;
        }

        .row-info {
            background-color: rgb(248, 248, 248);
            text-align: center;
        }

        .row-info p {
            margin: 0 0 1rem 0;
        }

        .footer {
            padding-bottom: 1rem;
            background-color: rgb(248, 248, 248);
        }

        .footer p {
            text-align: center;
            margin: 0;
        }
    </style>
</head>

<body>
    <table style="width: 500px;margin-left: auto;margin-right: auto;color: white;border-collapse: collapse;font-family: Arial, Helvetica, sans-serif;">
        <thead style="background-color: #90AFC5;">
            <tr>
                <th colspan="2">
                    <h1 style="font-weight: 300;margin-bottom: 0.2rem;">Zahtijev za promjenu pristupnih podataka</b></h1>
                    <p style="font-weight: 100;margin-top: 0.8rem;font-size: 15px;margin-bottom: 1.5rem;color: rgb(255, 255, 255);margin-left: 1.4rem;margin-right: 1.4rem;">
                        Base Admin
                    </p>
                </th>
            </tr>
        </thead>
        <tbody style="background-color: white;color: rgb(78, 90, 92);">
            <tr class="row-info" style="background-color: rgb(248, 248, 248);text-align: center;">
                <td colspan="2" style="padding: 1.4rem 1rem 0 1rem;">
                    <p style="margin: 0 0 1rem 0;">
                        Podnijeli ste zahtijev za promjenu pristupnih podataka. Pratite link ispod da nastavite.
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;padding: 1.4rem 1rem 0 1rem;">
                    <a
                        href="{{ env('ADMIN_URL') . '/reset-credentials/' . $user->password_reset_code }}"
                        class="button"
                        style="display: inline-block;padding: 1rem 2rem;background-color: #336B87;text-decoration: none;margin-bottom: 1.4rem;margin-top: 0.1rem;color: white;font-weight: bold;border-radius: 8px;">
                            Nastavi
                    </a>
                </td>
            </tr>
            <tr>
                <td class="footer" style="padding: 1.4rem 1rem 0 1rem;padding-bottom: 1rem;background-color: rgb(248, 248, 248);">
                    <p style="text-align: center;margin: 0;">
                        U koliko niste podnijeli ova zahtijev, molimo vas da ignorisete ovaj mejl.
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
