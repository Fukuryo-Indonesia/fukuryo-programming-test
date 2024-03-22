const slugAuthor = document.querySelector("#slug");
const nameAuthor = document.querySelector("#name");
const addressAuthor = document.querySelector("#address");

let startDate = moment();

const fnAuthor = {
    init: {
        buttons: {
            btnAdd: document.querySelector("#btn-add"),
            btnSave: document.querySelector("#btn-save"),
        },
        datePickers: {
            dobPicker: new Litepicker({
                element: document.querySelector("#dob"),
                buttonText: {
                    previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
                },
                format: "DD/MM/YYYY",
                singleMode: true,
                startDate: startDate,
                lang: "id-ID",
            }),
        },
        modals: {
            modalAuthor: new bootstrap.Modal(
                document.querySelector("#modal-author")
            ),
        },
        dtTable: {
            tbAuthor: $("#tb-author").DataTable({
                ajax: {
                    url: `${baseUrl}/masters/authors/get-all-data`,
                },
                serverSide: true,
                pagging: true,
                processing: true,
            }),
        },
    },

    onEdit: async (slug) => {
        await fetch(`${baseUrl}/masters/authors/${slug}/edit`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(
                        swalWithBootstrapButtons.fire(
                            "Failed",
                            "Something wrong while get the data",
                            "error"
                        )
                    );
                }

                return response.json();
            })
            .then((response) => {
                slugAuthor.value = response.slug;
                nameAuthor.value = response.name;
                addressAuthor.value = response.address;

                fnAuthor.init.datePickers.dobPicker.setDate(
                    moment(response.dob, "YYYY-MM-DD")
                );

                fnAuthor.init.buttons.btnSave.setAttribute(
                    "data-type",
                    "edit-data"
                );

                fnAuthor.init.modals.modalAuthor.show();
            });
    },

    onDelete: async (slug, csrf) => {
        swalWithBootstrapButtons
            .fire({
                title: "Warning",
                text: "Are you sure to delete the data?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M5 12l5 5l10 -10"></path>
         </svg> Delete`,
                cancelButtonText: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M18 6l-12 12"></path>
            <path d="M6 6l12 12"></path>
         </svg> Cancel`,
            })
            .then(async (result) => {
                if (result.isConfirmed) {
                    blockUI();

                    const results = await onSaveJson(
                        `${baseUrl}/masters/authors/${slug}`,
                        JSON.stringify({ _token: csrf }),
                        "delete"
                    );

                    unBlockUI();

                    if (results.data.status) {
                        swalWithBootstrapButtons.fire(
                            "Success",
                            results.data.message,
                            "success"
                        );

                        fnAuthor.init.dtTable.tbAuthor.ajax
                            .url(`${baseUrl}/masters/authors/get-all-data`)
                            .draw();
                    } else {
                        if (typeof results.data.message == "string") {
                            swalWithBootstrapButtons.fire(
                                "Something Wrong",
                                results.data.message,
                                "error"
                            );
                        }
                    }
                }
            });
    },
};

fnAuthor.init.buttons.btnAdd.addEventListener("click", () => {
    slugAuthor.value = "";
    nameAuthor.value = "";
    addressAuthor.value = "";

    fnAuthor.init.buttons.btnSave.setAttribute("data-type", "add-data");

    fnAuthor.init.modals.modalAuthor.show();
});

fnAuthor.init.buttons.btnSave.addEventListener("click", async () => {
    switch (fnAuthor.init.buttons.btnSave.dataset.type) {
        case "add-data":
            url = `${baseUrl}/masters/authors`;

            data = JSON.stringify({
                name: nameAuthor.value,
                address: addressAuthor.value,
                dob: moment(
                    fnAuthor.init.datePickers.dobPicker.getDate().toJSDate()
                ).format("YYYY-MM-DD"),
                _token: fnAuthor.init.buttons.btnSave.dataset.csrf,
            });

            method = "post";
            break;

        case "edit-data":
            url = `${baseUrl}/masters/authors/${slugAuthor.value}`;

            data = JSON.stringify({
                name: nameAuthor.value,
                address: addressAuthor.value,
                dob: moment(
                    fnAuthor.init.datePickers.dobPicker.getDate().toJSDate()
                ).format("YYYY-MM-DD"),
                _token: fnAuthor.init.buttons.btnSave.dataset.csrf,
            });

            method = "put";
            break;
    }

    blockUI();

    const results = await onSaveJson(url, data, method);

    unBlockUI();

    if (results.data.status) {
        swalWithBootstrapButtons
            .fire("Success", results.data.message, "success")
            .then((result) => {
                if (result.isConfirmed) {
                    fnAuthor.init.modals.modalAuthor.hide();

                    fnAuthor.init.dtTable.tbAuthor.ajax
                        .url(`${baseUrl}/masters/authors/get-all-data`)
                        .draw();
                }
            });
    } else {
        if (results.data.message.name[0]) {
            swalWithBootstrapButtons.fire(
                "Something Wrong",
                results.data.message.name[0],
                "error"
            );

            return false;
        }

        if (results.data.message.slug[0]) {
            swalWithBootstrapButtons.fire(
                "Something Wrong",
                results.data.message.slug[0],
                "error"
            );

            return false;
        }

        if (results.data.message.dob[0]) {
            swalWithBootstrapButtons.fire(
                "Something Wrong",
                results.data.message.dob[0],
                "error"
            );

            return false;
        }

        if (typeof results.data.message == "string") {
            swalWithBootstrapButtons.fire(
                "Something Wrong",
                results.data.message,
                "error"
            );

            return false;
        }
    }
});
