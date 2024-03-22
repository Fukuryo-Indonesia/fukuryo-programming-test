<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta17
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ config('app.name') . ' | ' . $title }}</title>
    {{-- <script defer data-api="/stats/api/event" data-domain="preview.tabler.io" src="/stats/js/script.js"></script> --}}
    <meta name="msapplication-TileColor" content="" />
    <meta name="theme-color" content="" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="MobileOptimized" content="320" />
    <link rel="icon" href="{{ asset('assets/image/favicon.ico') }}?{{ rand() }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('assets/image/favicon.ico') }}?{{ rand() }}" type="image/x-icon" />
    <!-- CSS files -->
    <link href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}?{{ rand() }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/sweetalert/sweetalert2.min.css') }}?{{ rand() }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/toastify/toastify.css') }}?{{ rand() }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/freezeui/freeze-ui.min.css') }}?{{ rand() }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/datatable/datatables.min.css') }}?{{ rand() }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/tabler/css/tabler.min.css') }}?{{ rand() }}" rel="stylesheet" />
    @stack('mystyles')
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
    <script>
        const baseUrl = "{{ url('') }}"
    </script>
</head>

<body>
    <div class="page">
        <!-- Sidebar -->
        @include('partials.sidebar')
        <!-- Navbar -->
        @include('partials.topbar')
        <div class="page-wrapper">
            <!-- Page header -->
            @yield('content')
            <footer class="footer footer-light bg-teal text-white d-print-none">
                <div class="container-fluid">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-lg-auto ms-lg-auto text-white">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item"><a href="https://fukuryo.co.id"
                                        class="link-secondary bg-transparent text-white">Fukuryo Indonesia</a></li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright &copy; 2023
                                    <a href="." class="link-secondary bg-transparent text-white">Tabler</a>.
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="link-secondary bg-transparent text-white" rel="noopener">
                                        v1.0.0-beta17
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- Tabler Core -->
    <script src="{{ asset('assets/vendor/jquery/jquery-3.6.0.min.js') }}?{{ rand() }}"></script>
    <script src="{{ asset('assets/vendor/tabler/libs/bootstrap/dist/js/popper.min.js') }}?{{ rand() }}"></script>
    <script src="{{ asset('assets/vendor/tabler/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}?{{ rand() }}">
    </script>
    <script src="{{ asset('assets/vendor/tabler/libs/bootstrap/dist/js/bootstrap.min.js') }}?{{ rand() }}">
    </script>
    <script src="{{ asset('assets/vendor/fontawesome/js/all.min.js') }}?{{ rand() }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert2.all.min.js') }}?{{ rand() }}"></script>
    <script src="{{ asset('assets/vendor/toastify/toastify.js') }}?{{ rand() }}"></script>
    <script src="{{ asset('assets/vendor/freezeui/freeze-ui.min.js') }}?{{ rand() }}"></script>
    <script src="{{ asset('assets/vendor/datatable/datatables.min.js') }}?{{ rand() }}"></script>
    <script src="{{ asset('assets/vendor/tabler/js/tabler.min.js') }}?{{ rand() }}"></script>
    <script>
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success mx-2',
                cancelButton: 'btn btn-danger mx-2'
            },
            buttonsStyling: false
        })

        const blockUI = () => {
            FreezeUI({
                text: 'Processing'
            });
        }

        const unBlockUI = () => {
            UnFreezeUI();
        }

        const onSaveJson = async (url, data, method) => {
            return await fetch(url, {
                method: method,
                body: data,
                headers: {
                    "Content-Type": "application/json",
                },
            }).then(response => {
                if (!response.ok) {
                    unBlockUI()
                    swalWithBootstrapButtons.fire('Error', "Terjadi kesalahan saat menyimpan data", 'error')
                }

                return response.json()
            }).then(response => {
                return response
            });
        }

        const onSaveForm = async (url, data, method) => {
            return await fetch(url, {
                method: method,
                body: data,
            }).then(response => {
                if (!response.ok) {
                    unBlockUI()
                    swalWithBootstrapButtons.fire('Error', "Terjadi kesalahan saat menyimpan data", 'error')
                }

                return response.json()
            }).then(response => {
                return response
            });
        }

        const createDropdown = async (url, element, placeholder, selected) => {
            element.clearStore();
            element.clearChoices();

            element.setChoices([{
                label: placeholder,
                value: "",
            }, ]);

            if (typeof url == "object") {
                element.setChoices(url);
            } else {
                await fetch(url)
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(
                                swalWithBootstrapButtons.fire(
                                    "Error",
                                    "Terjadi kesalahan saat mengambil data",
                                    "error"
                                )
                            );
                        }

                        return response.json();
                    })
                    .then((response) => {
                        element.setChoices(response);
                    });
            }

            element.setChoiceByValue(selected);
        }
    </script>
    @stack('myscript')
</body>

</html>
