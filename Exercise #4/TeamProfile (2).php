<?php
// Enable full error logging at the top level
error_reporting(E_ALL);
ini_set('display_errors', 1);

$team_members = [
    [
        "name" => "De Guzman, Arsley Duane S.",
        "role" => "Member 1",
        "age" => 20,
        "location" => "Bayanan, Muntinlupa",
        "course" => "BSIT",
        "year" => "3rd Year",
        "hobbies" => "Gaming, Cafe hopping",
        "img" => "https://uploads.onecompiler.io/43apkkj7t/1785942215506/25bfab55-f2df-42d5-9357-025e3261b46f.jfif"
    ],
    [
        "name" => "Delfino, Prince V.",
        "role" => "Member 2",
        "age" => 21,
        "location" => "Bayanan, Muntinlupa",
        "course" => "BSIT",
        "year" => "3rd Year",
        "hobbies" => "Gaming, Reading, Cafe hopping",
        "img" => "https://uploads.onecompiler.io/43apkkj7t/1785941774496/Prince.png"
    ],
    [
        "name" => "Gabrillo, Kiane Amer S.",
        "role" => "Member 3",
        "age" => 21,
        "location" => "Tunasan, Muntinlupa",
        "course" => "BSIT",
        "year" => "3rd Year",
        "hobbies" => "Gaming",
        "img" => "https://uploads.onecompiler.io/43apkkj7t/1785944491052/2Q.png"
    ],
    [
        "name" => "Lomeda, Shejann C.",
        "role" => "Member 4",
        "age" => 19,
        "location" => "Putatan, Muntinlupa",
        "course" => "BSIT",
        "year" => "3rd Year",
        "hobbies" => "Gaming, Travel",
        "img" => "https://uploads.onecompiler.io/43apkkj7t/1785941092254/sijan.jpg"
    ],
    [
        "name" => "Mallari, Carl Michael E.",
        "role" => "Member 5",
        "age" => 20,
        "location" => "Poblacion, Muntinlupa",
        "course" => "BSIT",
        "year" => "3rd Year",
        "hobbies" => "Gaming",
        "img" => "https://uploads.onecompiler.io/43apkkj7t/1785941349624/763670915_873482668917934_3162888989539812119_n.jpg"
    ],
    [
        "name" => "Sioson, King Amir R.",
        "role" => "Member 6",
        "age" => 20,
        "location" => "Tunasan, Muntinlupa",
        "course" => "BSIT",
        "year" => "3rd Year",
        "hobbies" => "Billiards, Cooking",
        "img" => "https://uploads.onecompiler.io/43apkkj7t/1785941903163/762166370_1544954790457138_6793465559146168170_n.jpg"
    ],
    [
        "name" => "Unira, Reginald Dee L.",
        "role" => "Member 7",
        "age" => 21,
        "location" => "Poblacion, Muntinlupa",
        "course" => "BSIT",
        "year" => "3rd Year",
        "hobbies" => "Gaming",
        "img" => "https://uploads.onecompiler.io/43apkkj7t/1786258127103/regi.jfif"
    ]
];

// 1. POST METHOD: Process new member form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_member'])) {
    $new_member = [
        "name"     => trim($_POST['name']),
        "role"     => trim($_POST['role']),
        "age"      => (int)$_POST['age'],
        "location" => trim($_POST['location']),
        "course"   => trim($_POST['course']),
        "year"     => trim($_POST['year']),
        "hobbies"  => trim($_POST['hobbies']),
        "img"      => !empty($_POST['img']) ? trim($_POST['img']) : 'https://via.placeholder.com/240x210?text=No+Image'
    ];
    array_push($team_members, $new_member);
}

// 2. GET METHOD: Read search query parameter from URL
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

// Filter array if a GET search query exists
if (!empty($search_query)) {
    $filtered = [];
    $query = strtolower($search_query);
    
    foreach ($team_members as $member) {
        if (
            strpos(strtolower($member['name']), $query) !== false ||
            strpos(strtolower($member['location']), $query) !== false ||
            strpos(strtolower($member['hobbies']), $query) !== false ||
            strpos(strtolower($member['role']), $query) !== false
        ) {
            $filtered[] = $member;
        }
    }
    $team_members = $filtered;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OUR TEAM PROFILE</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background-color: #121212;
            background-image: radial-gradient(#333 1px, transparent 1px);
            background-size: 25px 25px;
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: #1e1e1e;
            color: white;
            text-align: center;
            letter-spacing: 2px;
            padding: 25px 20px;
            border-bottom: 1px solid #2a2a2a;
        }

        header h1 {
            font-size: 36px;
            font-weight: 800;
        }

        header p {
            margin-top: 5px;
            font-size: 16px;
            color: #888;
        }

        .controls-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            margin: 25px 0 10px 0;
        }

        .search-container input {
            padding: 12px 20px;
            width: 80vw;
            max-width: 420px;
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(0, 0, 0, 0.6);
            color: white;
            font-size: 15px;
            outline: none;
            transition: 0.3s;
        }

        .search-container input:focus {
            border-color: #007bff;
            box-shadow: 0 0 12px rgba(0, 123, 255, 0.4);
        }

        .add-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 22px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .add-btn:hover {
            background: #218838;
            box-shadow: 0 0 10px rgba(40, 167, 69, 0.5);
        }

        main {
            flex: 1;
        }

        .team {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
        }

        .row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 25px;
        }

        .card {
            width: 240px;
            background: #1e1e1e;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding-bottom: 18px;
        }

        .card:hover {
            transform: translateY(-6px);
            border-color: #007bff;
            box-shadow: 0 12px 30px rgba(0, 123, 255, 0.25);
        }

        .card img {
            width: 100%;
            height: 210px;
            object-fit: cover;
        }

        .card-preview {
            padding: 15px 12px 0 12px;
            width: 100%;
        }

        .card-preview h2 {
            color: #fff;
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-preview .role {
            color: #888;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .view-btn {
            background: rgba(255, 255, 255, 0.08);
            color: #4da6ff;
            border: 1px solid rgba(77, 166, 255, 0.3);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            transition: 0.2s;
            display: inline-block;
        }

        .card:hover .view-btn {
            background: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.82);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s ease, visibility 0.25s ease;
            z-index: 1000;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: #202020;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            width: 90%;
            max-width: 420px;
            padding: 22px;
            position: relative;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.9);
            transform: scale(0.9);
            transition: transform 0.25s ease;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-overlay.active .modal-content {
            transform: scale(1);
        }

        .close-btn {
            position: absolute;
            top: 12px;
            right: 16px;
            font-size: 24px;
            color: #aaa;
            cursor: pointer;
            transition: color 0.2s;
            z-index: 10;
        }

        .close-btn:hover {
            color: #fff;
        }

        .modal-content img {
            width: 100%;
            height: 230px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 18px;
        }

        .modal-details h2 {
            font-size: 22px;
            font-weight: bold;
            color: #fff;
            margin-bottom: 2px;
        }

        .modal-details .role {
            color: #888;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 18px;
        }

        .modal-details p {
            color: #d0d0d0;
            font-size: 15px;
            margin: 6px 0;
            line-height: 1.5;
        }

        .modal-details p b {
            color: #fff;
        }

        /* POST Form Styles */
        .post-form h3 {
            margin-bottom: 15px;
            color: #28a745;
            font-size: 20px;
        }

        .form-group {
            margin-bottom: 12px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: #aaa;
            margin-bottom: 4px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            font-size: 14px;
            outline: none;
        }

        .form-group input:focus {
            border-color: #28a745;
        }

        .submit-btn {
            width: 100%;
            background: #28a745;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background: #218838;
        }

        footer {
            background: #1e1e1e;
            color: #777;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            border-top: 1px solid #2a2a2a;
            font-size: 14px;
        }
    </style>
</head>
<body>

<header>
    <h1>INTPROG WEBSITE</h1>
    <p>BSIT STUDENTS | TEAM PROFILE</p>
</header>

<div class="controls-container">
    <!-- GET METHOD FORM FOR SEARCHING -->
    <form class="search-container" method="GET" action="">
        <input 
            type="text" 
            name="search" 
            id="searchInput" 
            onkeyup="filterMembers()" 
            placeholder="Search member name, location, or hobbies..." 
            value="<?php echo htmlspecialchars($search_query); ?>"
        >
    </form>

    <!-- BUTTON TO OPEN POST METHOD FORM MODAL -->
    <button class="add-btn" onclick="openAddModal()">+ Add New Member</button>
</div>

<main>
    <div class="team">
        <div class="row" id="teamContainer">
            <?php if (!empty($team_members)): ?>
                <?php foreach ($team_members as $member): ?>
                    <div class="card" onclick="openProfile(this)">
                        <img src="<?php echo htmlspecialchars($member['img']); ?>" alt="<?php echo htmlspecialchars($member['name']); ?>">
                        
                        <div class="card-preview">
                            <h2><?php echo htmlspecialchars($member['name']); ?></h2>
                            <p class="role"><?php echo htmlspecialchars($member['role']); ?></p>
                            <span class="view-btn">View Overview</span>
                        </div>

                        <div class="full-details" style="display: none;">
                            <h2><?php echo htmlspecialchars($member['name']); ?></h2>
                            <p class="role"><?php echo htmlspecialchars($member['role']); ?></p>
                            <p><b>Age:</b> <?php echo $member['age']; ?></p>
                            <p><b>Location:</b> <?php echo htmlspecialchars($member['location']); ?></p>
                            <p><b>Course:</b> <?php echo htmlspecialchars($member['course']); ?></p>
                            <p><b>Year:</b> <?php echo htmlspecialchars($member['year']); ?></p>
                            <p><b>Hobbies:</b> <?php echo htmlspecialchars($member['hobbies']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No members found matching "<b><?php echo htmlspecialchars($search_query); ?></b>".</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- PROFILE VIEW MODAL -->
<div id="profileModal" class="modal-overlay" onclick="closeOnOverlay(event)">
    <div class="modal-content">
        <span class="close-btn" onclick="closeProfile()">&times;</span>
        <img id="modalImg" src="" alt="Profile Image">
        <div id="modalBody" class="modal-details"></div>
    </div>
</div>

<!-- POST METHOD FORM MODAL -->
<div id="addMemberModal" class="modal-overlay" onclick="closeOnOverlay(event)">
    <div class="modal-content post-form">
        <span class="close-btn" onclick="closeAddModal()">&times;</span>
        <h3>Add Team Member (POST)</h3>
        <form method="POST" action="">
            <input type="hidden" name="add_member" value="1">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" required placeholder="e.g. Santos, Juan A.">
            </div>
            <div class="form-group">
                <label>Role</label>
                <input type="text" name="role" required placeholder="e.g. Member 8">
            </div>
            <div class="form-group">
                <label>Age</label>
                <input type="number" name="age" required placeholder="20">
            </div>
            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" required placeholder="e.g. Alabang, Muntinlupa">
            </div>
            <div class="form-group">
                <label>Course & Year</label>
                <input type="text" name="course" required placeholder="BSIT" style="width:48%; display:inline-block;">
                <input type="text" name="year" required placeholder="3rd Year" style="width:48%; display:inline-block; float:right;">
            </div>
            <div class="form-group" style="margin-top:10px;">
                <label>Hobbies</label>
                <input type="text" name="hobbies" required placeholder="e.g. Coding, Gaming">
            </div>
            <div class="form-group">
                <label>Image URL (Optional)</label>
                <input type="url" name="img" placeholder="https://...">
            </div>
            <button type="submit" class="submit-btn">Submit via POST</button>
        </form>
    </div>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> BSIT STUDENTS | TEAM PROFILE.</p>
</footer>

<script>
    function filterMembers() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const cards = document.querySelectorAll('.card');

        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(input) ? "flex" : "none";
        });
    }

    function openProfile(card) {
        const modal = document.getElementById('profileModal');
        const modalImg = document.getElementById('modalImg');
        const modalBody = document.getElementById('modalBody');

        const cardImg = card.querySelector('img');
        const fullDetails = card.querySelector('.full-details');

        modalImg.src = cardImg.src;
        modalImg.alt = cardImg.alt;
        modalBody.innerHTML = fullDetails.innerHTML;

        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeProfile() {
        const modal = document.getElementById('profileModal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    function openAddModal() {
        const modal = document.getElementById('addMemberModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeAddModal() {
        const modal = document.getElementById('addMemberModal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    function closeOnOverlay(e) {
        if (e.target.classList.contains('modal-overlay')) {
            closeProfile();
            closeAddModal();
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeProfile();
            closeAddModal();
        }
    });
</script>

</body>
</html>