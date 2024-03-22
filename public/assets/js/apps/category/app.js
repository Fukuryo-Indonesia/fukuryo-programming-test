const slugCategory = document.querySelector("#slug");
const nameCategory = document.querySelector("#name");
const descriptionCategory = document.querySelector("#description");

let url, data, method;

const fnCategory = {
    init: {
        buttons: {
            btnAdd: document.querySelector("#btn-add"),
            btnSave: document.querySelector("#btn-save"),
        },
        modals: {
            modalCategory: new bootstrap.Modal(
                document.querySelector("#modal-category")
            ),
        },
        dtTable: {
            tbCategory: $("#tb-category").DataTable({
                ajax: {
                    url: `${baseUrl}/masters/categories/get-all-data`,
                },
                serverSide: true,
                paging: true,
                processing: true,
            }),
        },
    },

    onEdit: async (slug) => {
        await fetch(`${baseUrl}/masters/categories/${slug}/edit`)
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
                slugCategory.value = response.slug;
                nameCategory.value = response.name;
                descriptionCategory.value = response.description;

                fnCategory.init.buttons.btnSave.setAttribute(
                    "data-type",
                    "edit-data"
                );

                fnCategory.init.modals.modalCategory.show();
            });
    },

    onDisable: async (slug, csrf) => {
        swalWithBootstrapButtons
            .fire({
                title: "Warning",
                text: "Are you sure to disable the data?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M5 12l5 5l10 -10"></path>
         </svg> Disabled`,
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
                        `${baseUrl}/masters/categories/activated/${slug}`,
                        JSON.stringify({ _token: csrf }),
                        "post"
                    );

                    unBlockUI();

                    if (results.data.status) {
                        swalWithBootstrapButtons.fire(
                            "Berhasil",
                            results.data.message,
                            "success"
                        );

                        fnCategory.init.dtTable.tbCategory.ajax
                            .url(`${baseUrl}/masters/categories/get-all-data`)
                            .draw();
                    } else {
                        if (typeof results.data.message == "string") {
                            swalWithBootstrapButtons.fire(
                                "Terjadi Kesalahan",
                                results.data.message,
                                "error"
                            );
                        }
                    }
                }
            });
    },

    onEnable: async (slug, csrf) => {
        swalWithBootstrapButtons
            .fire({
                title: "Warning",
                text: "Are you sure to enable the data?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M5 12l5 5l10 -10"></path>
         </svg> Enabled`,
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
                        `${baseUrl}/masters/categories/activated/${slug}`,
                        JSON.stringify({ _token: csrf }),
                        "post"
                    );

                    unBlockUI();

                    if (results.data.status) {
                        swalWithBootstrapButtons.fire(
                            "Berhasil",
                            results.data.message,
                            "success"
                        );

                        fnCategory.init.dtTable.tbCategory.ajax
                            .url(`${baseUrl}/masters/categories/get-all-data`)
                            .draw();
                    } else {
                        if (typeof results.data.message == "string") {
                            swalWithBootstrapButtons.fire(
                                "Terjadi Kesalahan",
                                results.data.message,
                                "error"
                            );
                        }
                    }
                }
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
                        `${baseUrl}/masters/categories/${slug}`,
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

                        fnCategory.init.dtTable.tbCategory.ajax
                            .url(`${baseUrl}/masters/categories/get-all-data`)
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

fnCategory.init.buttons.btnAdd.addEventListener("click", () => {
    slugCategory.value = "";
    nameCategory.value = "";
    descriptionCategory.value = "";

    fnCategory.init.buttons.btnSave.setAttribute("data-type", "add-data");

    fnCategory.init.modals.modalCategory.show();
});

fnCategory.init.buttons.btnSave.addEventListener("click", async () => {
    switch (fnCategory.init.buttons.btnSave.dataset.type) {
        case "add-data":
            url = `${baseUrl}/masters/categories`;

            data = JSON.stringify({
                name: nameCategory.value,
                description: descriptionCategory.value,
                _token: fnCategory.init.buttons.btnSave.dataset.csrf,
            });

            method = "post";
            break;

        case "edit-data":
            url = `${baseUrl}/masters/categories/${slugCategory.value}`;

            data = JSON.stringify({
                name: nameCategory.value,
                description: descriptionCategory.value,
                _token: fnCategory.init.buttons.btnSave.dataset.csrf,
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
                    fnCategory.init.modals.modalCategory.hide();

                    fnCategory.init.dtTable.tbCategory.ajax
                        .url(`${baseUrl}/masters/categories/get-all-data`)
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
