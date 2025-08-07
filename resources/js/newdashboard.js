document.addEventListener("DOMContentLoaded", function () {

    const dropArea = document.getElementById("drop-area");
    const inputFile = document.getElementById("input-file");
    const imageView = document.getElementById("img-view");

                    inputFile.addEventListener("change", uploadImage);

                    function uploadImage() {
                        let imgLink = URL.createObjectURL(inputFile.files[0]);
                        imageView.style.backgroundImage = `url(${imgLink})`;
                        imageView.textContent = " ";
                        imageView.style.border = "none";
                        imageView.style.backgroundSize = "cover";
                        imageView.style.backgroundPosition = "center";
                        imageView.style.backgroundRepeat = "no-repeat";
                    }

                    dropArea.addEventListener("dragover", function (e) {
                        e.preventDefault();
                    });
                    dropArea.addEventListener("drop", function (e) {
                        e.preventDefault();
                        inputFile.files = e.dataTransfer.files;
                        uploadImage();
                    });

                    const conts = document.getElementById('contributors'); // UL element
                    const inputc = document.getElementById('input-contributor'); // Input field
                    const hiddenContributors = document.querySelector('input[name="contributors"]'); // Hidden input

                    // Add contributor when Enter is pressed
                    inputc.addEventListener('keydown', function (event) {
                        if (event.key === 'Enter') {
                            event.preventDefault();
                            const contContent = inputc.value.trim();
                            const contributorId = parseInt(contContent, 10);

                            // Validate: must be numeric, positive
                            if (!contContent || isNaN(contributorId) || contributorId < 0) {
                                alert("Please enter a valid positive integer contributor ID.");
                                inputc.value = '';
                                return;
                            }

                            // Prevent duplicate entries
                            const existingIds = Array.from(conts.querySelectorAll('li')).map(li => li.dataset.id);
                            if (existingIds.includes(String(contributorId))) {
                                alert("This contributor ID has already been added.");
                                inputc.value = '';
                                return;
                            }

                            // Backend check: does the user ID exist?
                            fetch(`/api/check-user/${contributorId}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.exists) {
                                        const cont = document.createElement('li');
                                        cont.setAttribute('data-id', contributorId);
                                        cont.textContent = contributorId;

                                        const delBtn = document.createElement('button');
                                        delBtn.textContent = ' x';
                                        delBtn.classList.add('delete-button');
                                        delBtn.addEventListener('click', () => {
                                            cont.remove();
                                            updateContributorsHidden();
                                        });

                                        cont.appendChild(delBtn);
                                        conts.appendChild(cont);
                                        updateContributorsHidden();
                                    } else {
                                        alert("This contributor ID does not exist.");
                                    }
                                    inputc.value = '';
                                })
                                .catch(error => {
                                    console.error('Error checking contributor:', error);
                                    alert("An error occurred while checking the contributor.");
                                    inputc.value = '';
                                });
                        }
                    });

                    // Remove contributor
                    conts.addEventListener('click', function (event) {
                        if (event.target.classList.contains('delete-button')) {
                            event.target.parentNode.remove();
                            updateContributorsHidden();
                        }
                    });

                    // Update the hidden input with an array of contributor IDs
                    function updateContributorsHidden() {
                        const contributorIds = Array.from(conts.querySelectorAll('li')).map(li => li.dataset.id);
                        hiddenContributors.value = JSON.stringify(contributorIds);
                        console.log('Contributors:', hiddenContributors.value); // Corrected debug log
                    }

                    // Force update right before form submission
                    const form = document.querySelector('form');
                    form.addEventListener('submit', function () {
                        updateContributorsHidden();
                    });

                    const tagsUl = document.getElementById('tags');
                    const inputTag = document.getElementById('input-tag');
                    const hiddenTags = document.querySelector('input[name="tags"]');

                    inputTag.addEventListener('keydown', function (event) {
                        if (event.key === 'Enter') {
                            event.preventDefault();
                            const tagContent = inputTag.value.trim();
                            if (tagContent !== '') {
                                const tag = document.createElement('li');
                                tag.textContent = tagContent;
                                tag.innerHTML += '<button class="delete-button"> x</button>';
                                tagsUl.appendChild(tag);
                                inputTag.value = '';
                                updateTagsHidden();
                            }
                        }
                    });

                    tagsUl.addEventListener('click', function (event) {
                        if (event.target.classList.contains('delete-button')) {
                            event.target.parentNode.remove();
                            updateTagsHidden();
                        }
                    });

                    function updateTagsHidden() {
                        const tags = Array.from(tagsUl.querySelectorAll('li')).map(li => li.firstChild.textContent.trim());
                        hiddenTags.value = JSON.stringify(tags);
                    }
})