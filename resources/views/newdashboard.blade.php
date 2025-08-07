<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="icon" href="\storage\images\icons8-coffee-beans-100.png">
    @vite('resources/css/newdashboard.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Libre+Franklin:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <script>

        // === DASHBOARD SWITCH CONTENT === //
        function changeContent(contentId, btnSelected) {
            // gonna leave comments for each block of code here kasi baka makalimutan ko how all these work

            // to hide all divs under content onli by default
            document.querySelectorAll('.content > div').forEach(div => {
                div.classList.add('hidden'); // adds tailwind hidden to class name of selected divs
            });

            // unhide the selected div
            const currentContent = document.getElementById(contentId);
            if (currentContent) {
                currentContent.classList.remove('hidden'); // basically removes the tailwind hidden from class name to display block :DD
            }

            // style of button when not hovered/selected (sets unhovered/deselected to default)
            document.querySelectorAll('.icon').forEach(btn => {
                btn.classList.remove('active'); // remove underline
            });
            btnSelected.classList.add('active'); // add underline to selected button

        }
    </script>

    <div class = "container">
        <!-- === SIDE BAR === -->
        <div class = "sidebar">

            <div>
                <a class = "logo" href = "{{route('home')}}"><img height = 50px width=50px src = "{{asset('storage/images/icons8-coffee-beans-100.png')}}"><h2>Coffee &<br>Contemplation</h2></a>
                <h2>Dashboard</h2>
                <ul class = "dashboardOptions">
                    <li><a class = "icon active" href = "#" onclick = "changeContent('manage', this)"><img class = "manageIcon" width="24" height="24" src="https://img.icons8.com/material/24/6f4e37/dashboard-layout.png" alt="dashboard-layout"/><p>Manage Posts</p></a></li>
                    <li><a class = "icon " href = "#" onclick = "changeContent('create', this)"><img class = "manageIcon" width="24" height="24" src="https://img.icons8.com/external-solid-adri-ansyah/24/6f4e37/external-ui-essentials-ui-solid-adri-ansyah-4.png" alt="external-ui-essentials-ui-solid-adri-ansyah-4"/><p>Create Post</p></a></li>
                    <li><a class = "icon " href = "#" onclick = "changeContent('drafts', this)"><img class = "manageIcon" width="24" height="24" src="https://img.icons8.com/external-febrian-hidayat-glyph-febrian-hidayat/24/6f4e37/external-edit-user-interface-febrian-hidayat-glyph-febrian-hidayat.png" alt="external-edit-user-interface-febrian-hidayat-glyph-febrian-hidayat"/><p>Drafts</p></a></li>
                    <li><a class = "icon " href = "#" onclick = "changeContent('analytics', this)"><img class = "manageIcon" width="24" height="24" src="https://img.icons8.com/ios-glyphs/24/6f4e37/analytics.png" alt="analytics"/><p>Analytics</p></a></li>
                </ul>
            </div>
            <hr>
            <div>
                <h2>Account Settings</h2>
                <ul class = "accountOptions">
                    <li><a class = "icon" href = "#" onclick = "changeContent('profile', this)"><img class = "manageIcon" width="24" height="24" src="https://img.icons8.com/material-rounded/24/6f4e37/guest-male.png" alt="guest-male"/><p>Profile & Settings</p></a></li>
                    <li><a class = "icon" href = "#" onclick="logout()"><img class = "manageIcon" width="24" height="24" src="https://img.icons8.com/material-rounded/24/6f4e37/exit.png" alt="exit"/><p>Log Out</p></a></li>
                </ul>
            </div>
        </div>

        <div id="logout">
            <h1>Log Out?</h1>
            <div class="button-group2">
                <button class="button1" onclick="confLG()">Log Out</button>
                <button class="button2"onclick="cancelLG()"">Cancel</button>
            </div>
        </div>
        <div id="overlay"></div>
        <script>
            function logout() {
                document.getElementById("logout").style.display = "block";
                document.getElementById("overlay").style.display = "block";
            }

            function confLG() {
                alert("Logged out succesfully.")
            }
            function cancelLG() {
                document.getElementById("logout").style.display = "none";
                document.getElementById("overlay").style.display = "none";
            }
        </script>

        <div class = "content">
            <!-- === MANAGE POSTS === -->
            <div id = "manage">
                <div class = "manageHeading">
                    <div class = "manageHeadingText">
                        <h1>Manage Posts</h1>
                        <a href = "{{ url('/') }}">Back to Home</a>
                    </div>
                        <p>DASHBOARD&nbsp;&nbsp; >&nbsp;&nbsp; Manage Posts</p>
                </div>

                <form method="GET" action="{{ route('dashboard.sort') }}">
                    <div class="manageSettings draftSettings">
                        <div class="sortOverlay">
                            <label for="sortOptions">Sort by:</label>
                            <select name="sortOptions" id="sortOptions" onchange="this.form.submit()">
                                <option value="" disabled {{ !$sortFieldInput ? 'selected' : '' }} hidden></option>
                                <option value="title" {{ $sortFieldInput == 'title' ? 'selected' : '' }}>Title</option>
                                <option value="date" {{ $sortFieldInput == 'date' ? 'selected' : '' }}>Last Edited</option>
                                <option value="published_date" {{ $sortFieldInput == 'published_date' ? 'selected' : '' }}>Published Date</option>
                            </select>

                            <label for="sortOrder">Order:</label>
                            <select name="sortOrder" id="sortOrder" onchange="this.form.submit()">
                                <option value="" disabled {{ !$sortOrder ? 'selected' : '' }} hidden></option>
                                <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </div>
                    </div>
                </form>
                <div class="managePosts">
                    @forelse ($posts as $post)
                        <div class="post">
                            <div class="postImgContainer">
                                <img class="postImg" src="{{ $post->image_data ? route('posts.image', $post->id) : asset('storage/images/default.jpg') }}">
                            </div>
                            <div class="postDetails">
                                <div class="postTitleDate">
                                    <p class="title">
                                        @if(in_array($post->status, ['published', 'archived']))
                                            <a href="{{ route('article.show', ['id' => $post->id]) }}">
                                                {{ $post->title }}
                                            </a>
                                        @else
                                            {{ $post->title }}
                                        @endif
                                    </p>
                                    <p class="date">
                                        {{ strtoupper($post->status) }} &nbsp;•&nbsp;
                                        {{ \Carbon\Carbon::parse($post->updated_at)->format('F j, Y') }}
                                    </p>
                                    <p>Role: {{ $post->pivot->author_role }}</p>
                                </div>
                            </div>
                            <div class="postActions">
                                <div class="postStatus">
                                    <div class="displayedStatus border
                                    @if($post->status ===  'draft') text-yellow-900 border-yellow-900 bg-yellow-200
                                    @elseif($post->status === 'published') text-green-900 border-green-900 bg-green-200
                                    @elseif($post->status === 'archived') text-gray-900 border-gray-900 bg-gray-200
                                    @endif">
                                    {{ strtoupper($post->status) }}</div>
                                    <div class="statusOptions">
                                        <div data-value="draft" data-display="DRAFT">Set as Draft</div>
                                        <div data-value="published" data-display="PUBLISHED">Publish Post</div>
                                        <div data-value="archived" data-display="ARCHIVED">Keep to Archives</div>
                                    </div>
                                    <input type="hidden" name="status" value="{{ $post->status }}">
                                </div>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                                        <img class="postIcons" width="24" height="24" src="https://img.icons8.com/fluency-systems-filled/24/FA5252/filled-trash.png" alt="filled-trash"/>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p>No posts found.</p>
                    @endforelse
                </div>
            </div>

            <!-- === CREATE POSTS === -->
            <div id="create" class="hidden">
                <div class="createHeading">
                    <div class="createHeadingText">
                        <h1>Create Post</h1>
                        <a href="/">Back to Home</a>
                    </div>
                    <p>DASHBOARD&nbsp;&nbsp; >&nbsp;&nbsp; Create a Post</p>
                </div>

                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="formcontainer">
                        <br>
                        <label for="input-file" id="drop-area">
                            <input type="file" accept="image/*" id="input-file" name="image" hidden>
                            <div id="img-view">
                                <img src="\storage\images\icons8-cloud-upload-100.png">
                                <p>DRAG AND DROP OR CLICK</p>
                                <span>Upload an image from computer</span>
                            </div>
                        </label>

                        <label for="title">Title</label>
                        <input type="text" placeholder="Enter title here" name="title" required>

                        <label for="content">Content</label>
                        <textarea placeholder="Share your thoughts here" name="content" required></textarea>

                        <label for="contributor">Contributor IDs</label>
                        <div class="cont-input">
                            <ul id="contributors"></ul>
                            <input type="number" id="input-contributor" placeholder="Enter the names of contributors and press the enter key to confirm" />
                            <input type="hidden" name="contributors" value="[]">
                        </div>

                        <label for="tags">Tags</label>
                        <div class="tags-input">
                            <ul id="tags"></ul>
                            <input type="text" id="input-tag" placeholder="Enter tag and press the enter key to confirm" />
                            <input type="hidden" name="tags" value="[]">
                        </div>

                        <div class="button-group">
                            <button type="submit" name="status" value="published" class="button1">Publish</button>
                            <button type="submit" name="status" value="draft" class="button2">Save to Drafts</button>
                            <button type="button" class="button2">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

            <!--- === DRAFTS === --->
            <div id = "drafts" class = "hidden">
                <div class = "manageHeading draftHeading">
                    <div class = "manageHeadingText draftHeadingText">
                        <h1>Drafts</h1>
                        <a href = "#">Back to Home</a>
                    </div>
                        <p>DASHBOARD&nbsp;&nbsp; >&nbsp;&nbsp; Drafts</p>
                </div>
                <div class = "manageSettings draftSettings">
                    <div class = "sortOverlay">
                        <label for = "sortOptions">Sort by: </label>
                        <select id = "sortOptions">
                            <option value="" selected disabled hidden></option>
                            <option value = "title">Title</option>
                            <option value = "date">Last Edited</option>
                        </select>
                        <label for = "sortOrder">Order: </label>
                        <select id = "sortOrder">
                            <option value="" selected disabled hidden></option>
                            <option value = "ascending">Ascending</option>
                            <option value = "descending">Descending</option>
                        </select>
                    </div>
                </div>

                <div class="draftPosts">
                    @forelse ($drafts as $draft)
                        <div class="draft">
                            <div class="draftImgContainer">
                                <img class="draftImg" src="{{ $draft->image_data ? route('posts.image', $draft->id) : asset('storage/images/default.jpg') }}">
                            </div>
                            <div class="draftDetails">
                                <div class="draftTitleDate">
                                    <p class="draftTitle">{{ $draft->title }}</p>
                                    <p class="draftDate">
                                        Last Updated &nbsp;
                                        {{ \Carbon\Carbon::parse($draft->updated_at)->format('F j, Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class = "draftActions">
                                <button onclick = "changeContent('create', this)">
                                    <img class = "draftIcons" width="32" height="24" src="https://img.icons8.com/material-rounded/24/FAB005/edit.png" alt="edit"/>
                                </button>
                                <form action="{{ route('posts.destroy', $draft->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button style="background: none; border: none; padding: 0; cursor: pointer;" type="submit">
                                        <img class = "draftIcons" width="24" height="24" src="https://img.icons8.com/fluency-systems-filled/24/FA5252/filled-trash.png" alt="filled-trash"/>
                                    </button >
                                </form>
                            </div>
                        </div>
                    @empty
                        <p>No posts found.</p>
                    @endforelse
                </div>
            </div>

            <!--- === ANALYTICS === --->
            <div id = "analytics" class = "hidden">
                <div class = "manageHeading">
                    <div class = "manageHeadingText">
                        <h1>Analytics</h1>
                        <a href = "{{ url('/') }}">Back to Home</a>
                    </div>
                        <p>DASHBOARD&nbsp;&nbsp; >&nbsp;&nbsp; Analytics</p>
                </div>
                <div class = "total">
                    <h1>Total</h1>
                    <div class = "totalContainer">
                        <div class = "totalCount">
                            <img class = "countIcon" width="60" height="60" src="https://img.icons8.com/ios-filled/60/d16d6a/like.png" alt="like"/>
                            <h1>{{$analytics['likes']}}</h1>
                            <p>LIKES</p>
                        </div>
                        <div class = "totalCount">
                            <img class = "countIcon" width="60" height="60" src="https://img.icons8.com/ios-filled/60/77a0e6/speech-bubble-with-dots.png" alt="speech-bubble-with-dots"/>
                            <h1>{{$analytics['comments']}}</h1>
                            <p>COMMENTS</p>
                        </div>
                        <div class = "totalCount">
                            <img class = "countIcon" width="60" height="60" src="https://img.icons8.com/material/60/f9d978/visible--v1.png" alt="visible--v1"/>
                            <h1>{{$analytics['views']}}</h1>
                            <p>VIEWS</p>
                        </div>

                    </div>
                </div>
                <div class = "countContainer">
                    <div class = "countLabel">
                        <h1>Title</h1>
                        <div class = "labelIcons">
                            <img class = "countIcon" width="24" height="24" src="https://img.icons8.com/ios-filled/24/ffffff/like.png" alt="like"/>
                            <img class = "countIcon" width="24" height="24" src="https://img.icons8.com/ios-filled/24/ffffff/speech-bubble-with-dots.png" alt="speech-bubble-with-dots"/>
                            <img class = "countIcon" width="24" height="24" src="https://img.icons8.com/material/24/ffffff/visible--v1.png" alt="visible--v1"/>
                        </div>
                    </div>
                    <div class = "postCount">
                        @forelse ($posts as $post)
                            
                                <div class = "count">
                                    <div class = "postImgContainer countImgContainer">
                                        <img class="postImg" src="{{ $post->image_data ? route('posts.image', $post->id) : asset('storage/images/default.jpg') }}">
                                    </div>
                                    <div class = "postDetails countDetails">
                                        <div class = "postTitleDate">
                                            <p class="title">{{ $post->title }}</p>
                                            <p class="date">
                                                {{ strtoupper($post->status) }} &nbsp;•&nbsp;
                                                {{ \Carbon\Carbon::parse($post->updated_at)->format('F j, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class = "postAnalytics">
                                        <div class = "likes">
                                            <img width="24" height="24" src="https://img.icons8.com/ios-filled/24/d16d6a/like.png" alt="like"/>
                                            <h1>{{ $post->analytics->likes ?? 0 }}</h1>
                                        </div>
                                        <div class = "comments">
                                            <img width="24" height="24" src="https://img.icons8.com/ios-filled/24/77a0e6/speech-bubble-with-dots.png" alt="speech-bubble-with-dots"/>
                                            <h1>{{ $post->analytics->comments ?? 0 }}</h1>
                                        </div>
                                        <div class = "views">
                                            <img width="24" height="24" src="https://img.icons8.com/material/24/f9d978/visible--v1.png" alt="visible--v1"/>
                                            <h1>{{ $post->analytics->views ?? 0 }}</h1>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            <p>No posts found.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!--- PROFILE & SETTINGS -->
            <div id = "profile" class = "hidden">
                <div class = "manageHeading">
                    <div class = "manageHeadingText">
                        <h1>Profile & Settings</h1>
                        <a href = "{{ url('/') }}">Back to Home</a>
                    </div>
                        <p>ACCOUNT SETTINGS&nbsp;&nbsp; >&nbsp;&nbsp; Profile & Settings</p>
                </div>
                <form action="#" class="profile">
                    <div class="row">
                        <div class="col-1">
                            <label for="name">Name</label>
                        </div>
                        <div class="col-2">
                            <input type="text" placeholder="John Doe" name="name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1">
                            <label for="email">Email Address</label>
                        </div>
                        <div class="col-2">
                            <input type="text" placeholder="johndoe@gmail.com" name="email" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1">
                            <label for="password">Password</label>
                        </div>
                        <div class="col-2">
                            <input type="password" placeholder="********" name="password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-1">
                        </div>
                        <div class="col-2">
                            <div class="button-group">
                                <button class="button2" onclick="openChanges()">Save Changes</button>
                                <button class="button2">Cancel</button>
                                <button class="button1" onclick="openDel()">Delete Account</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="confpopup1" id="confpopup1">
                    <h1>Edit Account Details</h1>
                    <p>Enter password to confirm changes</p>
                    <form action="">
                        <input type="password" name="confpass" required>
                            <div class="button-group2">
                                <button class="button1" onclick="confChanges()">Confirm</button>
                                <button class="button2" onclick="closeChanges()">Cancel</button>
                            </div>
                    </form>
                </div>
                <div class="confpopup2" id="confpopup2">
                    <h1>Account Deletion</h1>
                    <p>ACCOUNT DELETION IS PERMANENT</p>
                    <p>YOU WILL NOT BE ABLE TO RECOVER ACCOUNT AFTER DELETION</p>
                    <p>Enter password to confirm account deletion</p>
                    <form action="">
                        <input type="password" name="confpass" required>
                        <div class="button-group2">
                            <button class="button1" onclick="confDel()">Delete</button>
                            <button class="button2"onclick="closeDel()"">Cancel</button>
                        </div>
                    </form>
                </div>
                <div id="overlay"></div>
                <script>
                    function openChanges() {
                        document.getElementById("confpopup1").style.display = "block";
                        document.getElementById("overlay").style.display = "block";
                    }

                    function openDel() {
                        document.getElementById("confpopup2").style.display = "block";
                        document.getElementById("overlay").style.display = "block";
                    }

                    function confChanges() {
                        alert("Account edited succesfully.");
                        document.getElementById("confpopup1").style.display = "none";
                        document.getElementById("overlay").style.display = "none";
                    }

                    function confDel() {
                        alert("Account deleted succesfully.");
                        document.getElementById("confpopup2").style.display = "none";
                        document.getElementById("overlay").style.display = "none";
                    }

                    function closeChanges() {
                        document.getElementById("confpopup1").style.display = "none";
                        document.getElementById("overlay").style.display = "none";
                    }

                    function closeDel() {
                        document.getElementById("confpopup2").style.display = "none";
                        document.getElementById("overlay").style.display = "none";
                    }
                </script>
            </div>
        </div>
    </div>

<script>
    // === PICKER DROPDOWN AND LABE; FOR MANAGE POST VISIBILTY === ///
    // placing it here to ensure it avoid complications later

    document.querySelectorAll('.postStatus').forEach(jsPostStatus => {
        const display = jsPostStatus.querySelector('.displayedStatus'); // label displayed sa picker
        const options = jsPostStatus.querySelector('.statusOptions'); // dropdown options
        const hiddenInput = jsPostStatus.querySelector('input[type=hidden]'); // actual value submitted to database

        // toggle to hide and show dropdown
        display.addEventListener('click', () => {
            options.style.display = options.style.display === 'block' ? 'none' : 'block';
        });

        option.addEventListener('click', () => {
            display.textContent = option.dataset.display;
            hiddenInput.value = option.dataset.value;
            options.style.display = 'none';

            const newStatus = option.dataset.value;
            const postElement = jsPostStatus.closest('.post');
            const postId = postElement.dataset.postId;

            // Tailwind classes update
            if (newStatus === 'draft') {
                display.className = 'displayedStatus border text-yellow-900 border-yellow-900 bg-yellow-200';
            } else if (newStatus === 'published') {
                display.className = 'displayedStatus border text-green-900 border-green-900 bg-green-200';
            } else if (newStatus === 'archived') {
                display.className = 'displayedStatus border text-gray-900 border-gray-900 bg-gray-200';
            }

            // Send update to backend via AJAX
            fetch(`/posts/${postId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert("Failed to update post status.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Something went wrong.");
            });
        });

        // so dropdown will automatically close when users click outside dropdown area
        document.addEventListener('click', e => {
        if (!jsPostStatus.contains(e.target)) {
            options.style.display = 'none';
        }
        });
    });
    </script>
</body>
    @vite(['resources/js/newdashboard.js'])
</html>
