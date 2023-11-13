<script>
    const formContainer = $("#level-container");
    formContainer.on("click", ".add", function () {
        const newRow = $("<div>").addClass("row").html(`
            <div class="col-sm-3 col-lg-3">
                <label>Color <span style="color:red">*</span></label>
                <select class="form-control" name="color[]" required>
                    <option value="" selected>Select Color</option>
                    <?php include("fetchColor.php"); ?>
                </select>
            </div>
            <div class="col-sm-3 col-lg-3">
                <label>Size <span style="color:red">*</span></label>
                <select class="form-control" name="size[]" required>
                    <option value="" selected>Select Color</option>
                    <?php include("fetchSize.php"); ?>
                </select>
            </div>
            <div class="col-sm-3 col-lg-2">
                <label>Price <span style="color:red">*</span></label>
                <input type="text" style="text-align: center" class="form-control" name="price[]" required>
            </div>
            <div class="col-sm-3 col-lg-2">
                <label>Stock <span style="color:red">*</span></label>
                <input type="text" style="text-align: center" class="form-control" name="stock[]" required>
            </div>

            <div class="col-sm-3 col-lg-2" style="position: relative;top: 33px;left: 57px;">
                <button type="button" class="add" style="background-color: transparent;border: none;"> 
                    <i class="fa fa-plus-circle" style="font-size: 31px; color: green;"></i>
                </button>
                <button type=button class="remove" style="background-color: transparent;border: none;">
                    <i class="fa fa-trash"  style="font-size: 31px; color: red;"></i>
                </button>
            </div>
        `);
        formContainer.append(newRow);
    });

    formContainer.on("click", ".remove", function () {
        const row = $(this).closest(".row");
        if (row.length > 0) {
            row.remove();
        }
    });

    function previewBeforeUpload(id) {
        document.querySelector("#" + id).addEventListener("change", function (e) {
            if (e.target.files.length == 0) {
                return;
            }
            const imagePreviews = document.querySelector('.imagePreviews');
            const errorContainer = document.querySelector('.error-container');
            const submitButton = document.querySelector('#add_product_btn');
            const files = e.target.files; // Corrected

            imagePreviews.innerHTML = '';
            errorContainer.innerHTML = '';


            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                let url = URL.createObjectURL(file);

                let previewElement = document.createElement("div");
                previewElement.classList.add("preview-item");

                if (file.type.startsWith("image/")) {
                    previewElement.innerHTML = `<img src="${url}" alt="${file.name}" />`;
                } else if (file.type.startsWith("video/")) {
                    submitButton.disabled = true;
                    const errorText = document.createElement('p');
                    errorText.textContent = 'Please upload image only';
                    errorContainer.appendChild(errorText);
                    exit();
                } else {
                    previewElement.innerText = file.name;
                }

                imagePreviews.appendChild(previewElement); // Corrected
            }

        });
    }
    previewBeforeUpload("fileInput");

    function previewBeforeUploadVideo(id) {
        document.querySelector("#" + id).addEventListener("change", function (e) {
            if (e.target.files.length == 0) {
                return;
            }
            const videoPreviews = document.querySelector('.videoPreviews'); // Corrected
            const errorContainer = document.querySelector('.video-container');
            const submitButton = document.querySelector('#add_product_btn');
            const files = e.target.files; // Corrected

            videoPreviews.innerHTML = ''; // Corrected
            errorContainer.innerHTML = '';

            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                let url = URL.createObjectURL(file);

                let previewElement = document.createElement("div");
                previewElement.classList.add("preview-item1");

                if (file.type.startsWith("video/")) {
                    previewElement.innerHTML = `<video width="100%" height="100%" controls><source src="${url}" type="${file.type}">Your browser does not support the video tag.</video>`;
                    videoPreviews.appendChild(previewElement);
                } else {
                    // Handle other file types here (if needed)
                    previewElement.innerText = file.name;
                }
            }

        });
    }
    previewBeforeUploadVideo("fileInputVideo");











    function previewBeforeUploadUpdate(id) {
        document.querySelector("#" + id).addEventListener("change", function (e) {
            if (e.target.files.length == 0) {
                return;
            }
            let file = e.target.files[0];
            let url = URL.createObjectURL(file);
            document.querySelector("#" + id + "-preview img").src = url;
        });
    }

    previewBeforeUploadUpdate("file-1");
    previewBeforeUploadUpdate("file-2");
    previewBeforeUploadUpdate("file-3");
    previewBeforeUploadUpdate("file-4");
    previewBeforeUploadUpdate("file-5");
    previewBeforeUploadUpdate("file-6");
    previewBeforeUploadUpdate("file-7");
    previewBeforeUploadUpdate("file-8");
    previewBeforeUploadUpdate("file-9");
    previewBeforeUploadUpdate("file-10");








    // function previewBeforeUploadVideoUpdate(id) {
    //     const fileInput = document.getElementById(id);

    //     fileInput.addEventListener("change", function (e) {
    //         const previewElement = document.getElementById(`${id}-preview`);

    //         if (e.target.files.length === 0) {
    //             // No file selected
    //             return;
    //         }

    //         const file = e.target.files[0];
    //         const url = URL.createObjectURL(file);

    //         // Display the video preview
    //         previewElement.innerHTML = `
    //             <video width="100%" height="100%" controls>
    //                 <source src="${url}" type="video/mp4">
    //             </video>
    //         `;
    //     });
    // }
    // previewBeforeUploadVideoUpdate("file-21");
    // previewBeforeUploadVideoUpdate("file-22");
    // previewBeforeUploadVideoUpdate("file-23");
    // previewBeforeUploadVideoUpdate("file-24");
    // previewBeforeUploadVideoUpdate("file-25");




</script>
