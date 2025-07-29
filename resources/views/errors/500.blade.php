<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error</title>
    <!-- Add your stylesheets and other meta tags here -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #495057;
            margin: 0;
            padding: 0;
        }

        .page-not-found {
            text-align: center;
            padding: 50px 20px;
        }

        .container-ctn {
            max-width: 800px;
            margin: 0 auto;
        }

        .page-not-found img {
            max-width: 100%;
            height: auto;
        }

        h1 {
            font-size: 2em;
            margin-top: 20px;
        }

        .button-page-not-found {
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out,
            border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            cursor: pointer;
        }

        .btnSw {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btnSw:hover {
            color: #fff;
            background-color: #c82333;
            border-color: #c82333;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            h1 {
                font-size: 1.5em;
            }

            .btn {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<section class="page-not-found">
    <div class="container-ctn">
        <div class="row text-center justify-content-center">
            <img src="{{ asset('storage/images/errors/500.png') }}" alt="Server Error" width="400" height="200">
            <h1>Server Error</h1>
            <div class="button-page-not-found">
                <a onclick="window.history.go(-1); return false;" class="btn btnSw active">Back</a>
                <a href="{{ url('/') }}" class="btn btnSw">Home</a>
            </div>
        </div>
    </div>
</section>

</body>
</html>
