<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Permintaan Akses</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        table {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-spacing: 0;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        td {
            padding: 25px;
            text-align: left;
            vertical-align: top;
        }

        h1 {
            color: #333333;
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        p {
            color: #555555;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .cta-button {
            background-color: #007bff;
            color: white;
            padding: 14px 28px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            transition: background-color 0.3s ease, transform 0.3s ease;
            border: 1px solid #007bff;
        }

        .cta-button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #777777;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 0 0 8px 8px;
            margin-top: 25px;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .footer p {
            margin-top: 10px;
        }

        /* Responsive Styles */
        @media (max-width: 600px) {
            table {
                width: 100% !important;
            }

            td {
                padding: 20px;
            }

            h1 {
                font-size: 22px;
            }

            p {
                font-size: 14px;
            }

            .cta-button {
                padding: 12px 24px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td style="text-align: center;">
            </td>
        </tr>
        <tr>
            <td>
                <h1>{{ $details['message'] }}</h1>
                <p>Catatan: {{$details['notes']}}</p>
                <a href="https://aplikasi.atrbpn.go.id/manajemen/mintaakses/my-request" class="cta-button">Lihat Selengkapnya</a>
            </td>
        </tr>
        <tr>
            <td class="footer">
                <p>&copy; {{ date('Y') }} Kementerian ATR/BPN. Semua Hak Dilindungi.</p>
            </td>
        </tr>
    </table>
</body>

</html>
