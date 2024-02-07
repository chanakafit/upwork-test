<?php
/** @var yii\web\View $this */
/** @var \app\models\Pet[] $pets */

use yii\helpers\Url;

$isPetsAvailable = sizeof($pets) > 0;

?>

<div class="container">

    <section id="show-form">
        <div class="text-left mb-4"><b>What kind of pets have you had?</b></div>
        <div class="pets-container" data-id="0">
            <span class="title">Kind of Petsss</span>

            <div id="info-msg" style="display:none" class="">
                <span class="text-info"> Search By Specific Entity #1756 aa </span><span class="text-secondary"><i
                            class="fa fa-times fa-lg" onclick="infomsg()" style="margin-left:1rem ;"></i></span>
            </div>
            <div id="confirm-msg" style="display:none" class="">
            <span class="text-danger"> <p>Are you sure want to delete ?#1843 <span class="text-success"
                                                                                   id="confirmDelete"><i
                                class="fa fa-check fa-lg" aria-hidden="true"></i>
</span><span id="confirmCancel"><i style="margin-left:1rem ;" class="fa fa-times fa-lg"
                                   aria-hidden="true"></i></span></p></span>
            </div>
            <div id="success-msg" class="text-success" style="display: none;"><p>
                    <span id="success-msg-content"></span>
                    <span class="text-secondary"><i style="margin-left:1rem ;" class="fa fa-times fa-lg" onclick="successmsg()"></i></span></p><p>
                </p></div>
            <!-- Wrapper of search container -->
            <div class="wrapper">
                <!-- Selected pets -->
                <ul class="selected-pets  js-selected" id="selected-options" style="display: <?= $isPetsAvailable ? 'block': 'none'?>;">
                    <?php foreach ($pets as $pet): ?>
                        <li><input type="checkbox" name="sd_pets[]" value="5" class="selected-checkbox"
                                   id="selected-checkbox-5" style="display: <?= $isPetsAvailable ? 'none': 'inline-block'?>;">
                            <div class="content-container">
                                <div class="image-container"><img src="<?= Yii::$app->homeUrl.$pet->imageFile ?>" alt="Image description"></div>
                                <div class="text-container"><label for="selected-checkbox-5"><?= $pet->name ?></label><span
                                            class="location"><?= $pet->location ?></span></div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Search input field -->
                    <input type="text" placeholder="Enter min 3 characters" class="search-input" id="search-input"
                           autocomplete="off" style="display: <?= $isPetsAvailable ? 'none':'block' ?>;">
                <!-- Display the actions. -->

                <!-- List of pet items ----------------  -->


                <div class="dropdown js-selected-option " id="scrollable-options-div" style="display: none;">
                    <div class="dropdown-details">
                        <p class="total-result" id="total-options"></p>
                        <div class="btns d-flex flex-wrap ">
                            <label><input type="checkbox" id="select-all">Select All</label>
                            <label><input type="checkbox" id="clear-selection">Clear</label>
                        </div>
                    </div>
                    <ul multiple="" search="true"
                        class="pets-list-container checkbox-option scrollable-options striped-list"></ul>

                </div>
                <div id="nothing-found" class="text-danger" style="display: none;">No Result Found</div>
            </div>

            <div class="btns-container">
                <label id="select-all-top" class="all-btn" style="display: none;"><input id="select-all-top-btn"
                                                                                                 type="checkbox"
                                                                                                 checked="true">All
                </label>
                <div class="icons">
                    <i id="submit-btn" class="fa-solid fa-floppy-disk save" data-label="when-checked"
                       onclick="saveMyform()" style="display: none;">
                        <span>Save #89</span>
                    </i>
                    <i id="cancel-btn" class="fa fa-times cancel" data-label="when-checked"
                       style="display: none;">
                        <span>Cancel #90</span>
                    </i>
                    <i id="delete-btn" class="fa fa-trash delete" data-label="when-saved" style="display: <?= $isPetsAvailable ? 'inline-block': 'none'?>;">
                        <span>Delete #91</span>
                    </i>
                    <i id="edit-btn" class="fa-solid fa-pen-to-square edit" data-label="when-saved"
                       style="display: <?= $isPetsAvailable ? 'inline-block': 'none'?>;">
                        <span>Edit #88</span>
                    </i>
                    <i class="fa fa-info-circle info" data-label="for-all" onclick="infomsg()">
                        <span>Info #87</span>
                    </i>

                </div>
            </div>
        </div>
        <!-- Modal -->

    </section>

    <script>
        var selectedOptionsDiv = document.getElementById('selected-options');
        var successMsg = document.getElementById('success-msg');
        var successMsgContent = document.getElementById('success-msg-content');
        var confirmMsg = document.getElementById('confirm-msg');


        //search and drop down
        var searchInput = document.getElementById('search-input');

        var checkboxDropDown = document.querySelector('.checkbox-option');
        var selectAllCheckbox = document.getElementById('select-all');
        var clearSelectionCheckbox = document.getElementById('clear-selection');
        var scrollableOptionsDiv = document.getElementById('scrollable-options-div');


        var editButton = document.getElementById('edit-btn');
        var deleteButton = document.getElementById('delete-btn');
        var cancelButton = document.getElementById('cancel-btn');

        var selectAllTopBtn = document.getElementById('select-all-top-btn');


        var searchQuery = '';
        var isEditMode = false; // Variable to track whether the edit button has been clicked


        selectAllTopBtn.addEventListener('change', function () {
            var checked = $(this).is(':checked'); // Checkbox state
            var checkboxes = document.querySelectorAll('input[name="sd_pets[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = checked;
            });
            updateCorrespondingPets();

        });


        deleteButton.addEventListener("click", function (event) {
            if (confirmMsg.style.display === 'none') {
                confirmMsg.style.display = 'block';
            } else {
                confirmMsg.style.display = 'none';
            }
            // Show the confirmation modal
            // $('#confirmationModal').modal('show');
        });
        // Handle the edit button click event
        editButton.addEventListener('click', function () {
            isEditMode = true; // Set the edit mode to true
            selectAllTopBtn.checked = true;
            searchInput.style.display = 'block'; // Show the search field
            scrollableOptionsDiv.style.display = 'none'; // Show the checkboxes and options
            document.getElementById('cancel-btn').style.display = 'inline-block'; // Show the cancel button
            // document.getElementById('submit-btn').style.display = 'inline-block'; // Show the submit button
            document.getElementById('select-all-top').style.display = 'inline-block'; // Show the all button
            document.getElementById('edit-btn').style.display = 'none'; // Hide the edit button
            document.getElementById('delete-btn').style.display = 'none'; // Hide the delete button
            const selected_checkboxes = document.querySelectorAll('input[name="sd_pets[]"]');
            selected_checkboxes.forEach(select_cb => {
                select_cb.style.display = "inline-block";
            });
        });
        // Handle the cancel button click event
        cancelButton.addEventListener('click', function () {
            isEditMode = false; // Set the edit mode to false
            searchInput.style.display = 'none'; // Hide the search field
            scrollableOptionsDiv.style.display = 'none'; // Hide the checkboxes and options
            document.getElementById('cancel-btn').style.display = 'none'; // Show the cancel button// Hide the cancel button
            document.getElementById('submit-btn').style.display = 'none'; // Show the submit button// Hide the submit button
            document.getElementById('select-all-top').style.display = 'none'; // Show the all button// Hide the all button
            document.getElementById('edit-btn').style.display = 'inline-block'; // Show the edit button
            document.getElementById('delete-btn').style.display = 'inline-block'; // Show the delete button
            initial_task();
        });

        searchInput.addEventListener('input', function () {
            searchQuery = this.value.trim().toLowerCase();
            var hasSearchQuery = searchQuery.length >= 3;
            if (hasSearchQuery) {
                filterOptions(searchQuery);
            } else {
                //hide the scrollable options div
                scrollableOptionsDiv.style.display = "none";
                document.getElementById('nothing-found').style.display = 'none';
            }

        });
        document.getElementById("confirmDelete").addEventListener("click", function () {
            confirmMsg.style.display = 'none';

            var url = "<?= Url::to(['user-pet/delete-pet']) ?>";
            const response = fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
            })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Request failed:', response.status, response.statusText);
                    }
                })
                .then(data => {
                    successMsgContent.innerHTML = data.message;
                    successMsg.style.display = 'block';
                    initial_task();

                })
                .catch(error => {
                    console.log('Error:', error.message);
                });


        });
        document.getElementById("confirmCancel").addEventListener("click", function () {
            confirmMsg.style.display = 'none';
        });

        async function saveMyform() {
            event.preventDefault();

            const displaycheckboxes = document.querySelectorAll('input[name="sd_pets[]"]:checked');
            const selectedValues = Array.from(displaycheckboxes).map(checkbox => checkbox.value);

            try {
                var url = "<?= Url::to(['user-pet/submit-form'])?>";
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        selectedOptions: selectedValues
                    }),
                });

                if (response.ok) {
                    const data = await response.json();

                    successMsgContent.innerHTML = data.message;
                    successMsg.style.display = 'block';


                    // setTimeout(function() {
                    //     successMsg.style.display = 'none';
                    // }, 3000);
                    if (data.userpets.length > 0) {
                        updateUserPets(data.userpets);
                    } else {
                        document.getElementById('edit-btn').style.display = 'none'; // Hide the edit button
                        document.getElementById('delete-btn').style.display = 'none'; // Hide the delete button
                        document.getElementById('select-all-top').style.display = 'none'; // Hide the select all top button
                        document.getElementById('cancel-btn').style.display = 'none'; // Hide the cancel button
                        document.getElementById('submit-btn').style.display = 'none'; // Hide the save button
                        searchInput.style.display = 'block'; // hide the search field
                        searchInput.value = '';
                        selectedOptionsDiv.style.display = 'none';
                        selectedOptionsDiv.innerHTML = '';
                        scrollableOptionsDiv.style.display = 'none'; // Show the checkboxes and options
                    }
                    // Handle the response data
                } else {
                    // Handle the error case
                    console.log('Error:', response.status);
                }
            } catch (error) {
                // Handle any network or request error
                console.error('Error:', error);
            }
        }

        function filterOptions(searchQuery) {
            // Refresh the state of the "Clear" checkbox
            clearSelectionCheckbox.checked = false;
            // const url = 'list-pet';
            var url = "<?= Url::to(['user-pet/list-pet']) ?>";
            funcRequest(url, searchQuery);
        }

        async function funcRequest(url, searchQuery) {
            const response = await fetch(`${url}?searchQuery=${encodeURIComponent(searchQuery)}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                checkboxDropDown.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(item => {
                        const listItem = document.createElement('li');

                        // Create checkbox
                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.name = 'selected_pets[]';
                        checkbox.dataset.name = item.name;
                        checkbox.dataset.location = item.location;
                        checkbox.dataset.image = item.imageFile;
                        checkbox.value = item.id;
                        checkbox.className = "listed-checkbox";
                        checkbox.id = 'checkbox-' + item.id;
                        let existid = 'selected-' + checkbox.id;
                        let myele = document.getElementById(existid);
                        if (myele) {
                            checkbox.checked = document.getElementById(existid).checked;
                        }
                        checkbox.addEventListener('change', updateSelectedPets);

                        // Create container for image, label, and location
                        const contentContainer = document.createElement('div');
                        contentContainer.className = "content-container";

                        // Create image container
                        const imageContainer = document.createElement('div');
                        imageContainer.className = "image-container";
                        const image = document.createElement('img');

                        image.src = '<?= Yii::$app->homeUrl ?>' + item.imageFile; // Replace with the actual image path
                        image.alt = 'Image description'; // Replace with an appropriate alt text for the image
                        imageContainer.appendChild(image);
                        contentContainer.appendChild(imageContainer);

                        // Create text container
                        const textContainer = document.createElement('div');
                        textContainer.className = "text-container";

                        // Create label
                        const label = document.createElement('label');
                        var labelText = item.name;
                        highlightMatchedLetters(label, labelText, searchQuery);
                        label.htmlFor = checkbox.id;
                        textContainer.appendChild(label);

                        // Create location
                        const location = document.createElement('span');
                        location.className = "location";
                        location.textContent = item.location; // Replace with the actual location property of the item
                        textContainer.appendChild(location);

                        contentContainer.appendChild(textContainer);

                        // Append checkbox and contentContainer to listItem
                        listItem.appendChild(checkbox);
                        listItem.appendChild(contentContainer);

                        // Append listItem to checkboxDropDown
                        checkboxDropDown.appendChild(listItem);
                    });
                    // Display the total number of listed options
                    var totalOptionsElement = document.getElementById('total-options');
                    totalOptionsElement.textContent = 'Total Options: ' + data.length;
                    // Show/hide the scrollable options div based on the visibility of options
                    scrollableOptionsDiv.style.display = data.length > 0 ? 'block' : 'none';
                    document.getElementById('nothing-found').style.display = 'none';

                    updateSelectAllCheckbox();
                } else {
                    document.getElementById('nothing-found').innerHTML = "No Result Found";
                    document.getElementById('nothing-found').style.display = 'block';
                }

            } else {
                console.log('Request failed');
            }
        }

        function highlightMatchedLetters(label, labelText, searchQuery) {
            if (searchQuery.length > 0) {
                var regex = new RegExp('(' + searchQuery + ')', 'gi');
                label.innerHTML = labelText.replace(regex, '<span class="highlight">$1</span>');
            } else {
                label.innerHTML = labelText;
            }
        }

        selectAllCheckbox.addEventListener('change', function () {
            var checked = $(this).is(':checked'); // Checkbox state
            var checkboxes = document.querySelectorAll('.listed-checkbox');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = checked;
            });
            updateSelectedPets();
        });

        function updateSelectAllCheckbox() {
            var checkboxes = document.querySelectorAll('.listed-checkbox');
            var allOptionsSelected = true;
            for (var i = 0; i < checkboxes.length; i++) {
                if (!checkboxes[i].checked) {
                    allOptionsSelected = false;
                    break;
                }
            }
            selectAllCheckbox.checked = allOptionsSelected;

            var displayCheckboxes = document.querySelectorAll('input[name="sd_pets[]"]');
            var allDispalyOptionsSelected = true;
            for (var i = 0; i < displayCheckboxes.length; i++) {
                if (!displayCheckboxes[i].checked) {
                    allDispalyOptionsSelected = false;
                    break;
                }
            }
            selectAllTopBtn.checked = allDispalyOptionsSelected;


            // document.getElementById('submit-btn').style.display = 'inline-block';
        }

        clearSelectionCheckbox.addEventListener('change', function () {
            selectAllCheckbox.checked = false;
            var checkboxes = document.querySelectorAll('.listed-checkbox');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
                let selectedid = 'selected-' + checkbox.id
                var myEle = document.getElementById(selectedid);
                if (myEle) {
                    document.getElementById(selectedid).checked = checkbox.checked;
                }

            });
            clearSelectionCheckbox.checked = false;
            scrollableOptionsDiv.style.display = "none";
            searchInput.value = '';
            closeDropDown();
            updateSelectAllCheckbox();

        });

        function closeDropDown() {
            const displaycheckboxes = document.querySelectorAll('input[name="sd_pets[]"]:checked');

            if (displaycheckboxes.length > 0) {
                selectedOptionsDiv.style.display = 'block';
                document.getElementById('submit-btn').style.display = 'inline-block';
                document.getElementById('cancel-btn').style.display = 'inline-block';
            } else {
                searchInput.value = '';
                // selectedOptionsDiv.style.display = 'none';
                // selectedOptionsDiv.innerHTML = '';
                scrollableOptionsDiv.style.display = "none";
                document.getElementById('submit-btn').style.display = 'none';
                document.getElementById('cancel-btn').style.display = 'none';
            }
        }

        // initially  selected pets list
        function updateUserPets(userpets) {
            selectedOptionsDiv.innerHTML = '';
            userpets.forEach(user_pet => {
                const listItem = document.createElement('li');

                // selected checkbox
                const selectedcheckbox = document.createElement('input');
                selectedcheckbox.type = 'checkbox';
                selectedcheckbox.name = 'sd_pets[]';
                selectedcheckbox.value = user_pet.id;
                selectedcheckbox.className = "selected-checkbox";
                selectedcheckbox.id = 'selected-checkbox-' + user_pet.id;
                selectedcheckbox.checked = 'true';
                selectedcheckbox.addEventListener('change', updateCorrespondingPets);

                // Create container for image, label, and location
                const contentContainer = document.createElement('div');
                contentContainer.className = "content-container";

                // Create image container
                const imageContainer = document.createElement('div');
                imageContainer.className = "image-container";
                const image = document.createElement('img');
                image.src = '<?= Yii::$app->homeUrl ?>' + user_pet.imageFile; // Replace with the actual image path
                image.alt = 'Image description'; // Replace with an appropriate alt text for the image
                imageContainer.appendChild(image);
                contentContainer.appendChild(imageContainer);

                // Create text container
                const textContainer = document.createElement('div');
                textContainer.className = "text-container";

                // Create label
                const label = document.createElement('label');
                var labelText = user_pet.name;
                highlightMatchedLetters(label, labelText, searchQuery);
                label.htmlFor = selectedcheckbox.id;
                textContainer.appendChild(label);

                // Create location
                const location = document.createElement('span');
                location.className = "location";
                location.textContent = user_pet.location; // Replace with the actual location property of the
                textContainer.appendChild(location);

                contentContainer.appendChild(textContainer);

                // Append checkbox and contentContainer to listItem
                listItem.appendChild(selectedcheckbox);
                listItem.appendChild(contentContainer);

                // Append listItem to selectedOptionsDiv
                selectedOptionsDiv.appendChild(listItem);
            });
            searchInput.value = '';
            const selected_checkboxes = document.querySelectorAll('input[name="sd_pets[]"]');
            selected_checkboxes.forEach(select_cb => {
                select_cb.style.display = "none";
            });

            selectedOptionsDiv.style.display = 'block';
            scrollableOptionsDiv.style.display = "none";
            searchInput.style.display = 'none'; // hide the search field
            document.getElementById('submit-btn').style.display = 'none';
            document.getElementById('cancel-btn').style.display = 'none';

            document.getElementById('edit-btn').style.display = 'inline-block';
            document.getElementById('delete-btn').style.display = 'inline-block';
            document.getElementById('select-all-top').style.display = 'none';


        }


        // Update the selected pets list
        function updateSelectedPets() {

            const checkboxes = document.querySelectorAll('input[name="selected_pets[]"]');

            checkboxes.forEach(checkbox => {
                let selectid = 'selected-' + checkbox.id;
                let myele = document.getElementById(selectid);
                if (myele) {
                    document.getElementById(selectid).checked = checkbox.checked;
                } else {
                    if (checkbox.checked) {
                        const listItem = document.createElement('li');
                        listItem.className = "recent-add";


                        const selectedcheckbox = document.createElement('input');
                        selectedcheckbox.type = 'checkbox';
                        selectedcheckbox.name = 'sd_pets[]';
                        selectedcheckbox.value = checkbox.value;
                        selectedcheckbox.className = "selected-checkbox";
                        selectedcheckbox.id = 'selected-checkbox-' + checkbox.value;
                        selectedcheckbox.checked = 'true';
                        selectedcheckbox.addEventListener('change', updateCorrespondingPets);


                        // Create container for image, label, and location
                        const contentContainer = document.createElement('div');
                        contentContainer.className = "content-container";

                        // Create image container
                        const imageContainer = document.createElement('div');
                        imageContainer.className = "image-container";
                        const image = document.createElement('img');
                        image.src = '<?= Yii::$app->homeUrl ?>' + checkbox.dataset.image; // Replace with the actual image path
                        image.alt = 'Image description'; // Replace with an appropriate alt text for the image
                        imageContainer.appendChild(image);
                        contentContainer.appendChild(imageContainer);

                        // Create text container
                        const textContainer = document.createElement('div');
                        textContainer.className = "text-container";

                        // Create label
                        const label = document.createElement('label');
                        label.textContent = checkbox.dataset.name;
                        label.htmlFor = selectedcheckbox.id;
                        textContainer.appendChild(label);

                        // Create location
                        const location = document.createElement('span');
                        location.className = "location";
                        location.textContent = checkbox.dataset.location; // Replace with the actual location property of the
                        textContainer.appendChild(location);

                        contentContainer.appendChild(textContainer);


                        // Append checkbox and contentContainer to listItem
                        listItem.appendChild(selectedcheckbox);
                        listItem.appendChild(contentContainer);

                        // Append listItem to selectedOptionsDiv
                        selectedOptionsDiv.appendChild(listItem);
                    }


                }

            });
            updateSelectAllCheckbox();
            closeDropDown();
        }


        function updateCorrespondingPets() {
            const selected_checkboxes = document.querySelectorAll('input[name="sd_pets[]"]');

            selected_checkboxes.forEach(select_cb => {
                let selected_id = select_cb.id;
                const myArray = selected_id.split("-");
                let id = myArray[1] + '-' + myArray[2];
                let myele = document.getElementById(id);
                if (myele) {
                    document.getElementById(id).checked = select_cb.checked;
                }

            });
            document.getElementById('submit-btn').style.display = 'inline-block'; // show the save button
            updateSelectAllCheckbox();
        }

        function initial_task() {
            var url = '<?= Url::to(['/user-pet/user-pet-list']) ?>';
            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Request failed:', response.status, response.statusText);
                    }
                })
                .then(data => {
                    if (data.length > 0) {
                        console.log(data);
                        updateUserPets(data);
                    } else {
                        document.getElementById('edit-btn').style.display = 'none'; // Hide the edit button
                        document.getElementById('delete-btn').style.display = 'none'; // Hide the delete button
                        searchInput.style.display = 'block'; // hide the search field
                        searchInput.value = '';
                        selectedOptionsDiv.style.display = 'none';
                        selectedOptionsDiv.innerHTML = '';
                    }

                })
                .catch(error => {
                    console.log('Error:', error.message);
                });
        }

        (function () {
            initial_task();
        })();
    </script>
    <script>
        var infoMsg = document.getElementById('info-msg');


        // Initial state
        let isActive = false;

        // Function to toggle the button state
        function infomsg() {
            isActive = !isActive;
            if (isActive) {
                infoMsg.style.display = 'block';
            } else {
                infoMsg.style.display = 'none';
            }
        }

        function successmsg() {
            successMsg.style.display = 'none';
        }
    </script>

    <style>
        span {
            white-space: nowrap;
        }

        ul {
            list-style-type: none;
            padding-inline-start: 0px !important;
        }

        .scrollable-options {
            max-height: 100px;
            overflow-y: auto;
            padding: 5px;
        }

        .scrollable-options-div {
            border: 1px solid #ccc;
        }

        ul.striped-list > li:nth-of-type(odd) {
            background-color: #e9e9f9;
            border-bottom: none;
        }

        ul.striped-list > li {
            padding: 5px;
        }

        .highlight {
            color: red;
        }

        #selected-options li {
            display: inline-flex;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            padding: 0px 5px;
            border-radius: 4px;
            cursor: pointer;
            margin: 3px;
        }

        #selected-options input {
            display: inline-block;
            margin-right: 5px;
        }

        label {
            margin-bottom: 0rem !important;
        }

        .recent-add {
            background: #7bf17b !important;
        }

        /* #success-msg {
            min-height: 2.5rem;
            border: 1px #badbcc;
            border-radius: 5px;
            margin: 10px 0px;
            background: #d1e7dd;
            padding: 10px;
            text-align: justify;
            color: #0f5132;
        } */


        .content-container {
            display: flex;
            align-items: center;
        }

        .image-container {
            margin: 1px;
            width: 40px;
            height: 40px;
            /* border-radius: 0%; */
            overflow: hidden;
            padding: 4px;
        }

        .image-container img {
            vertical-align: middle;
            border-style: none;
            /* width: 40px; */
            border-radius: 20px;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .text-container {
            flex-grow: 1;
            margin: 1px;
            padding: 4px;
        }

        .text-container label {
            display: block;
            margin-top: -8px !important;
            font-size: 17px;
            font-weight: bold;
            height: 20px;
        }

        .text-container .location {
            display: block;
            line-break: auto;
            font-size: 10px;
            height: 12px;
            margin-top: 3px;
        }

        p {
            margin: 0 !important;
        }
    </style>
</div>