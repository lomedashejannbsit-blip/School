<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
Y: ini_set('display_errors', 0);
session_start();

$tab = $_GET['tab'] ?? 'team';

// Initial Team Members Data in Session
if (!isset($_SESSION['team_members'])) {
    $_SESSION['team_members'] = [
        [ "name" => "De Guzman, Arsley Duane S.", "role" => "Member 1", "age" => 20, "location" => "Bayanan, Muntinlupa", "course" => "BSIT", "year" => "3rd Year", "hobbies" => "Gaming, Cafe hopping", "img" => "https://uploads.onecompiler.io/43apkkj7t/1785942215506/25bfab55-f2df-42d5-9357-025e3261b46f.jfif" ],
        [ "name" => "Delfino, Prince V.", "role" => "Member 2", "age" => 21, "location" => "Bayanan, Muntinlupa", "course" => "BSIT", "year" => "3rd Year", "hobbies" => "Gaming, Reading, Cafe hopping", "img" => "https://uploads.onecompiler.io/43apkkj7t/1785941774496/Prince.png" ],
        [ "name" => "Gabrillo, Kiane Amer S.", "role" => "Member 3", "age" => 21, "location" => "Tunasan, Muntinlupa", "course" => "BSIT", "year" => "3rd Year", "hobbies" => "Gaming", "img" => "https://uploads.onecompiler.io/43apkkj7t/1785944491052/2Q.png" ],
        [ "name" => "Lomeda, Shejann C.", "role" => "Member 4", "age" => 19, "location" => "Putatan, Muntinlupa", "course" => "BSIT", "year" => "3rd Year", "hobbies" => "Gaming, Travel", "img" => "https://uploads.onecompiler.io/43apkkj7t/1785941092254/sijan.jpg" ],
        [ "name" => "Mallari, Carl Michael E.", "role" => "Member 5", "age" => 20, "location" => "Poblacion, Muntinlupa", "course" => "BSIT", "year" => "3rd Year", "hobbies" => "Gaming", "img" => "https://uploads.onecompiler.io/43apkkj7t/1785941349624/763670915_873482668917934_3162888989539812119_n.jpg" ],
        [ "name" => "Sioson, King Amir R.", "role" => "Member 6", "age" => 20, "location" => "Tunasan, Muntinlupa", "course" => "BSIT", "year" => "3rd Year", "hobbies" => "Billiards, Cooking", "img" => "https://uploads.onecompiler.io/43apkkj7t/1785941903163/762166370_1544954790457138_6793465559146168170_n.jpg" ],
        [ "name" => "Unira, Reginald Dee L.", "role" => "Member 7", "age" => 21, "location" => "Poblacion, Muntinlupa", "course" => "BSIT", "year" => "3rd Year", "hobbies" => "Gaming", "img" => "https://uploads.onecompiler.io/43apkkj7t/1786258127103/regi.jfif" ]
    ];
}

// Initialize Gossip Wall
if (!isset($_SESSION['gossip'])) {
    $_SESSION['gossip'] = [
        ["author" => "Prince", "note" => "Anyone up for late night gaming sessions?", "time" => "Today, 8:15 PM"]
    ];
}

// Initialize Hangout Goals in Session (XML data representation)
if (!isset($_SESSION['hangout_goals'])) {
    $_SESSION['hangout_goals'] = [
        ["activity" => "Samgyup Food Trip", "budget" => "₱500", "status" => "Planned"],
        ["activity" => "Overnight Lan Party", "budget" => "₱0", "status" => "Confirmed"],
        ["activity" => "Tagaytay Road Trip", "budget" => "₱1,200", "status" => "Pending"],
        ["activity" => "Coffee Shop Study Sesh", "budget" => "₱250", "status" => "Done"]
    ];
}

// Initialize Secret Vault History Log
if (!isset($_SESSION['vault_history']) || isset($_SESSION['vault_history'][0]['code'])) {
    $_SESSION['vault_history'] = [
        ["member" => "De Guzman, Arsley Duane S.", "codename" => "PhantomCoder", "status" => "Verified Active", "time" => "Initial Setup"]
    ];
}

// Handle POST Method: Add New Member
$member_feedback = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_member'])) {
    $new_member = [
        "name"     => trim($_POST['name']),
        "role"     => "Member " . (count($_SESSION['team_members']) + 1),
        "age"      => (int)$_POST['age'],
        "location" => trim($_POST['location']),
        "course"   => trim($_POST['course']),
        "year"     => trim($_POST['year']),
        "hobbies"  => trim($_POST['hobbies']),
        "img"      => !empty($_POST['img']) ? trim($_POST['img']) : 'https://via.placeholder.com/240x210?text=No+Image'
    ];
    array_push($_SESSION['team_members'], $new_member);
    $member_feedback = "New friend successfully added to the squad!";
}

// Handle POST Method: Add New Hangout Goal (Interactive XML Table)
$goal_feedback = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_goal'])) {
    $new_goal = [
        "activity" => trim($_POST['activity']),
        "budget"   => "₱" . number_format((float)$_POST['budget']),
        "status"   => trim($_POST['status'])
    ];
    array_push($_SESSION['hangout_goals'], $new_goal);
    $goal_feedback = "New hangout goal added successfully!";
}

// Handle POST Method: Gossip Wall Note
$gossip_feedback = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_gossip'])) {
    $new_note = [
        "author" => htmlspecialchars($_POST['author']),
        "note" => htmlspecialchars($_POST['note']),
        "time" => date("M j, Y h:i A")
    ];
    array_unshift($_SESSION['gossip'], $new_note);
    $gossip_feedback = "Note dropped on the wall successfully!";
}

// Handle Secret Vault Submission
$vault_result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_vault'])) {
    $selected_member = trim($_POST['vault_member']);
    $secret_codename = trim($_POST['secret_codename']);
    
    $vault_payload = json_encode([
        "squad_member" => $selected_member,
        "secret_identity" => $secret_codename,
        "timestamp" => time()
    ]);
    
    $decoded = json_decode($vault_payload, true);
    if ($decoded) {
        $vault_result = "Vault Registered for " . $decoded['squad_member'] . " with Codename: " . $decoded['secret_identity'];
        array_unshift($_SESSION['vault_history'], [
            "member" => $decoded['squad_member'],
            "codename" => $decoded['secret_identity'],
            "status" => "Secured & Encrypted",
            "time" => date("M j, Y h:i A")
        ]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Friend Hub</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0; }
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

        header h1 { font-size: 32px; font-weight: 800; color: #4da6ff; }
        header p { margin-top: 5px; font-size: 14px; color: #888; }

        nav {
            background: #181818;
            display: flex;
            justify-content: center;
            gap: 6px;
            padding: 12px;
            border-bottom: 1px solid #2a2a2a;
            flex-wrap: wrap;
        }
        nav a {
            color: #aaa;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            transition: 0.2s;
            border: 1px solid transparent;
        }
        nav a:hover, nav a.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        .container { max-width: 1100px; width: 90%; margin: 30px auto; flex: 1; }

        .row { display: flex; justify-content: center; flex-wrap: wrap; gap: 25px; }
        .card {
            width: 240px; background: #1e1e1e;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 18px; overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease, border-color 0.3s ease;
            cursor: pointer; display: flex; flex-direction: column; align-items: center; text-align: center; padding-bottom: 18px;
        }
        .card:hover { transform: translateY(-6px); border-color: #007bff; }
        .card img { width: 100%; height: 210px; object-fit: cover; }
        .card-preview { padding: 15px 12px 0 12px; width: 100%; }
        .card-preview h2 { color: #fff; font-size: 17px; font-weight: bold; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .card-preview .role { color: #888; font-size: 13px; font-weight: 600; margin-bottom: 15px; }
        .view-btn {
            background: rgba(255, 255, 255, 0.08); color: #4da6ff;
            border: 1px solid rgba(77, 166, 255, 0.3); padding: 8px 16px;
            border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-block;
        }

        .panel {
            background: #1e1e1e; border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px; padding: 25px; max-width: 650px; margin: 0 auto;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }
        .panel h2 { color: #4da6ff; margin-bottom: 15px; font-size: 20px; border-bottom: 1px solid #333; padding-bottom: 8px; }
        .panel p { color: #ccc; font-size: 14px; line-height: 1.5; margin-bottom: 15px; }

        label { display: block; font-size: 13px; color: #aaa; margin-bottom: 4px; text-align: left; }
        input[type="text"], input[type="number"], input[type="url"], select, textarea {
            width: 100%; padding: 10px; border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2); background: rgba(0, 0, 0, 0.5);
            color: #fff; font-size: 14px; outline: none; margin-bottom: 15px;
        }
        input:focus, select:focus, textarea:focus { border-color: #007bff; }
        button {
            background: #28a745; color: white; border: none; padding: 10px 20px;
            border-radius: 20px; font-weight: bold; cursor: pointer; width: 100%; transition: 0.2s;
        }
        button:hover { background: #218838; }

        table { width: 100%; border-collapse: collapse; font-size: 14px; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; }
        th { background: #252525; color: #4da6ff; }

        .code-box {
            background: #0f172a; color: #38bdf8; padding: 15px; border-radius: 8px;
            font-family: Arial, sans-serif; font-size: 14px; margin-top: 15px; border: 1px solid #334155; line-height: 1.6;
        }
        .alert { background: rgba(40, 167, 69, 0.2); border: 1px solid #28a745; color: #28a745; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-weight: bold; text-align: center; }

        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.82); backdrop-filter: blur(6px);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; visibility: hidden; transition: 0.25s; z-index: 1000;
        }
        .modal-overlay.active { opacity: 1; visibility: visible; }
        .modal-content {
            background: #202020; border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px; width: 90%; max-width: 420px; padding: 22px; position: relative;
        }
        .close-btn { position: absolute; top: 12px; right: 16px; font-size: 24px; color: #aaa; cursor: pointer; }
        .close-btn:hover { color: #fff; }
        .modal-content img { width: 100%; height: 230px; object-fit: cover; border-radius: 12px; margin-bottom: 18px; }
        .modal-details h2 { font-size: 22px; color: #fff; margin-bottom: 2px; }
        .modal-details .role { color: #888; font-size: 14px; margin-bottom: 18px; }
        .modal-details p { color: #d0d0d0; font-size: 15px; margin: 6px 0; }

        footer {
            background: #1e1e1e; color: #777; text-align: center;
            padding: 20px; margin-top: auto; border-top: 1px solid #2a2a2a; font-size: 14px;
        }
    </style>
</head>
<body>

<header>
    <h1>THE FRIEND HUB</h1>
    <p>BSIT GROUP HANGOUT PORTAL</p>
</header>

<nav>
    <a href="?tab=team" class="<?= $tab === 'team' ? 'active' : '' ?>">Squad</a>
    <a href="?tab=finder" class="<?= $tab === 'finder' ? 'active' : '' ?>">Find Friend</a>
    <a href="?tab=profiles" class="<?= $tab === 'profiles' ? 'active' : '' ?>">Inspect</a>
    <a href="?tab=addmember" class="<?= $tab === 'addmember' ? 'active' : '' ?>">Add Member</a>
    <a href="?tab=goals" class="<?= $tab === 'goals' ? 'active' : '' ?>">Hangout Goals</a>
    <a href="?tab=gossip" class="<?= $tab === 'gossip' ? 'active' : '' ?>">Gossip Wall</a>
    <a href="?tab=vibe" class="<?= $tab === 'vibe' ? 'active' : '' ?>">Vibe Check</a>
    <a href="?tab=vault" class="<?= $tab === 'vault' ? 'active' : '' ?>">Secret Vault</a>
</nav>

<div class="container">

    <?php if ($tab === 'team'): ?>
        <!-- TAB 1: SQUAD -->
        <div style="text-align: center; margin-bottom: 25px;">
            <h2>The Barkada Squad</h2>
            <p style="color: #888; font-size: 14px; margin-top: 5px;">Click any friend card to view their profile details.</p>
        </div>
        <div class="row">
            <?php foreach ($_SESSION['team_members'] as $index => $m): ?>
                <div class="card" onclick="openProfile(this)">
                    <img src="<?= htmlspecialchars($m['img']) ?>" alt="<?= htmlspecialchars($m['name']) ?>">
                    <div class="card-preview">
                        <h2><?= htmlspecialchars($m['name']) ?></h2>
                        <p class="role"><?= htmlspecialchars($m['role']) ?></p>
                        <span class="view-btn">View Bio</span>
                    </div>
                    <div class="full-details" style="display: none;">
                        <h2><?= htmlspecialchars($m['name']) ?></h2>
                        <p class="role"><?= htmlspecialchars($m['role']) ?></p>
                        <p><b>Age:</b> <?= $m['age'] ?></p>
                        <p><b>Location:</b> <?= htmlspecialchars($m['location']) ?></p>
                        <p><b>Course:</b> <?= htmlspecialchars($m['course']) ?></p>
                        <p><b>Year:</b> <?= htmlspecialchars($m['year']) ?></p>
                        <p><b>Hobbies:</b> <?= htmlspecialchars($m['hobbies']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php elseif ($tab === 'finder'): ?>
        <!-- TAB 2: VERSATILE FIND FRIEND -->
        <div class="panel">
            <h2>Find a Friend</h2>
            <p>Versatile search: type a name, hometown, or hobby (e.g., "cafe", "gaming", "Muntinlupa").</p>
            <form method="GET" action="">
                <input type="hidden" name="tab" value="finder">
                <label>Search Keyword</label>
                <input type="text" name="q" placeholder="Search name, location, or hobbies..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                <button type="submit" style="background: #007bff;">Search Squad</button>
            </form>

            <?php 
            $q = strtolower(trim($_GET['q'] ?? ''));
            $filtered = $_SESSION['team_members'];
            if (!empty($q)) {
                $filtered = array_filter($_SESSION['team_members'], function($m) use ($q) {
                    return strpos(strtolower($m['name']), $q) !== false || 
                           strpos(strtolower($m['location']), $q) !== false || 
                           strpos(strtolower($m['hobbies']), $q) !== false;
                });
            }
            ?>
            <hr style="margin: 20px 0; border:0; border-top:1px solid #333;">
            <h3>Found <?= count($filtered) ?> friend(s):</h3>
            <table>
                <tr><th>Name</th><th>Location</th><th>Hobbies</th></tr>
                <?php foreach($filtered as $m): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($m['name']) ?></strong></td>
                    <td><?= htmlspecialchars($m['location']) ?></td>
                    <td><?= htmlspecialchars($m['hobbies']) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

    <?php elseif ($tab === 'profiles'): ?>
        <!-- TAB 3: INSPECT PROFILES -->
        <div class="panel">
            <h2>Friend Bio Inspector</h2>
            <p>Select a friend from the dropdown to check out their bio:</p>
            <?php $sel_index = $_GET['member'] ?? 0; $member = $_SESSION['team_members'][$sel_index] ?? $_SESSION['team_members'][0]; ?>
            <form method="GET" action="">
                <input type="hidden" name="tab" value="profiles">
                <label>Choose Friend</label>
                <select name="member" onchange="this.form.submit()">
                    <?php foreach($_SESSION['team_members'] as $i => $m): ?>
                        <option value="<?= $i ?>" <?= $sel_index == $i ? 'selected' : '' ?>><?= $m['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </form>

            <div style="display: flex; gap: 20px; margin-top: 20px; align-items: flex-start;">
                <img src="<?= htmlspecialchars($member['img']) ?>" style="width: 130px; height: 150px; object-fit: cover; border-radius: 10px;">
                <div>
                    <h3 style="color: #fff; font-size: 18px; margin-bottom: 4px;"><?= htmlspecialchars($member['name']) ?></h3>
                    <p style="color: #888; font-size: 13px; margin-bottom: 10px;"><?= htmlspecialchars($member['role']) ?></p>
                    <p style="font-size: 14px; margin: 4px 0;"><strong>Age:</strong> <?= $member['age'] ?></p>
                    <p style="font-size: 14px; margin: 4px 0;"><strong>Location:</strong> <?= htmlspecialchars($member['location']) ?></p>
                    <p style="font-size: 14px; margin: 4px 0;"><strong>Course & Year:</strong> <?= htmlspecialchars($member['course']) ?>, <?= htmlspecialchars($member['year']) ?></p>
                    <p style="font-size: 14px; margin: 4px 0;"><strong>Hobbies:</strong> <?= htmlspecialchars($member['hobbies']) ?></p>
                </div>
            </div>
        </div>

    <?php elseif ($tab === 'addmember'): ?>
        <!-- TAB 4: ADD MEMBER -->
        <div class="panel">
            <h2>Add New Member</h2>
            <p>Register a new friend to join the squad database:</p>
            
            <?php if ($member_feedback): ?><div class="alert"><?= $member_feedback ?></div><?php endif; ?>

            <form method="POST" action="">
                <input type="hidden" name="add_member" value="1">
                <label>Full Name</label>
                <input type="text" name="name" required placeholder="e.g. Santos, Juan A.">
                <label>Age</label>
                <input type="number" name="age" required placeholder="20">
                <label>Location / Hometown</label>
                <input type="text" name="location" required placeholder="e.g. Alabang, Muntinlupa">
                <div style="display: flex; gap: 10px;">
                    <div style="flex:1;"><label>Course</label><input type="text" name="course" required value="BSIT"></div>
                    <div style="flex:1;"><label>Year Level</label><input type="text" name="year" required value="3rd Year"></div>
                </div>
                <label>Hobbies (comma separated)</label>
                <input type="text" name="hobbies" required placeholder="e.g. Coding, Gaming, Reading">
                <label>Image URL (Optional)</label>
                <input type="url" name="img" placeholder="https://example.com/photo.jpg">
                <button type="submit">Add to Squad</button>
            </form>
        </div>

    <?php elseif ($tab === 'goals'): ?>
        <!-- TAB 5: INTERACTIVE HANGOUT GOALS (XML Table) -->
        <div class="panel">
            <h2>Hangout Goals (XML Bucket List)</h2>
            <p>Add a new activity to our interactive goals table:</p>
            
            <?php if ($goal_feedback): ?><div class="alert"><?= $goal_feedback ?></div><?php endif; ?>

            <form method="POST" action="">
                <input type="hidden" name="add_goal" value="1">
                <label>Activity / Event</label>
                <input type="text" name="activity" required placeholder="e.g. Beach Camping">
                <label>Estimated Budget (₱)</label>
                <input type="number" name="budget" required placeholder="500">
                <label>Status</label>
                <select name="status">
                    <option value="Planned">Planned</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="Pending">Pending</option>
                    <option value="Done">Done</option>
                </select>
                <button type="submit" style="background: #17a2b8;">Add New Goal</button>
            </form>

            <hr style="margin: 25px 0; border:0; border-top:1px solid #333;">
            <h3>Current Bucket List:</h3>
            <table>
                <tr><th>Activity</th><th>Estimated Budget</th><th>Status</th></tr>
                <?php foreach($_SESSION['hangout_goals'] as $g): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($g['activity']) ?></strong></td>
                    <td><?= htmlspecialchars($g['budget']) ?></td>
                    <td><span style="color: #28a745; font-weight: bold;"><?= htmlspecialchars($g['status']) ?></span></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

    <?php elseif ($tab === 'gossip'): ?>
        <!-- TAB 6: GOSSIP WALL -->
        <div class="panel">
            <h2>The Gossip Wall</h2>
            <p>Drop notes and secrets for the group using form submission:</p>
            
            <?php if ($gossip_feedback): ?><div class="alert"><?= $gossip_feedback ?></div><?php endif; ?>
            
            <form method="POST" action="">
                <input type="hidden" name="post_gossip" value="1">
                <label>Your Alias / Name</label>
                <input type="text" name="author" required placeholder="e.g. Anonymous">
                <label>Secret Note / Message</label>
                <textarea name="note" rows="3" required placeholder="Spill the tea or write a reminder..."></textarea>
                <button type="submit">Drop Note</button>
            </form>

            <hr style="margin: 25px 0; border:0; border-top:1px solid #333;">
            <h3>Recent Notes:</h3>
            <div style="margin-top: 15px; display: flex; flex-direction: column; gap: 10px;">
                <?php foreach($_SESSION['gossip'] as $g): ?>
                    <div style="background: #121212; padding: 12px; border-radius: 8px; border: 1px solid #333;">
                        <strong style="color: #4da6ff;"><?= htmlspecialchars($g['author']) ?></strong> <span style="font-size: 11px; color: #888; float: right;"><?= $g['time'] ?></span>
                        <p style="margin-top: 6px; font-size: 14px; color: #ccc;"><?= htmlspecialchars($g['note']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    <?php elseif ($tab === 'vibe'): ?>
        <!-- TAB 7: VIBE CHECK -->
        <div class="panel" style="text-align: center;">
            <h2>Squad Vibe Check</h2>
            <p style="text-align: left;">Click below to load a random squad member's live vibe check and status asynchronously without reloading:</p>
            <button onclick="fetchSquadVibe()" style="margin: 15px 0; background: #17a2b8;">Generate Squad Vibe</button>
            <div id="vibeOutput" class="code-box" style="text-align: left;">Click the button to generate a vibe...</div>
        </div>

        <script>
            const squadMembers = <?= json_encode($_SESSION['team_members']) ?>;

            function fetchSquadVibe() {
                const out = document.getElementById('vibeOutput');
                out.innerText = "Tuning into the squad frequency...";
                
                setTimeout(() => {
                    const randomMember = squadMembers[Math.floor(Math.random() * squadMembers.length)];
                    const vibes = [
                        `Ready to conquer coding lab and grab coffee afterwards!`,
                        `Currently grinding online matches and working on group code.`,
                        `Exploring new cafes and planning the next weekend trip.`,
                        `Focused on finishing web system requirements and debugging PHP.`
                    ];
                    const randomVibe = vibes[Math.floor(Math.random() * vibes.length)];

                    out.innerHTML = `
                        <div style="display: flex; gap: 15px; align-items: center;">
                            <img src="${randomMember.img}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;">
                            <div>
                                <strong style="color: #38bdf8; font-size: 16px;">✨ ${randomMember.name}</strong><br>
                                <span style="color: #aaa; font-size: 13px;">Location: ${randomMember.location} | Hobbies: ${randomMember.hobbies}</span><br>
                                <p style="margin-top: 6px; color: #fff;">"${randomVibe}"</p>
                            </div>
                        </div>
                    `;
                }, 300);
            }
        </script>

    <?php elseif ($tab === 'vault'): ?>
        <!-- TAB 8: SECRET VAULT -->
        <div class="panel">
            <h2>Squad Secret Vault</h2>
            <p>Assign a secret codename to any squad member. Submissions encode to JSON and log below:</p>
            
            <?php if ($vault_result): ?><div class="alert"><?= $vault_result ?></div><?php endif; ?>
            
            <form method="POST" action="">
                <input type="hidden" name="test_vault" value="1">
                <label>Select Squad Member</label>
                <select name="vault_member" required>
                    <?php foreach($_SESSION['team_members'] as $m): ?>
                        <option value="<?= htmlspecialchars($m['name']) ?>"><?= htmlspecialchars($m['name']) ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Secret Codename / Alias</label>
                <input type="text" name="secret_codename" required placeholder="e.g. ShadowHacker, NightOwl">

                <button type="submit" style="background: #17a2b8;">Encrypt & Unlock Vault</button>
            </form>

            <hr style="margin: 25px 0; border:0; border-top:1px solid #333;">
            <h3>Vault Access Recents:</h3>
            <div style="margin-top: 10px; display: flex; flex-direction: column; gap: 8px;">
                <?php foreach($_SESSION['vault_history'] as $vh): ?>
                    <div style="background: #121212; padding: 10px; border-radius: 6px; border: 1px solid #333; font-size: 13px;">
                        <span style="color: #38bdf8; font-weight: bold;"><?= htmlspecialchars($vh['member'] ?? 'Unknown') ?></span> as 
                        <span style="color: #f43f5e; font-weight: bold;"><?= htmlspecialchars($vh['codename'] ?? 'N/A') ?></span> — 
                        <span style="color: #28a745;"><?= htmlspecialchars($vh['status']) ?></span> 
                        <span style="color: #888; float: right; font-size: 11px;"><?= $vh['time'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<!-- PROFILE MODAL -->
<div id="profileModal" class="modal-overlay" onclick="closeOnOverlay(event)">
    <div class="modal-content">
        <span class="close-btn" onclick="closeProfile()">&times;</span>
        <img id="modalImg" src="" alt="Profile Image">
        <div id="modalBody" class="modal-details"></div>
    </div>
</div>

<footer>
    <p>&copy; <?= date("Y") ?> The Friend Hub. Built with PHP, XML, JSON, and JavaScript.</p>
</footer>

<script>
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
        document.getElementById('profileModal').classList.remove('active');
        document.body.style.overflow = '';
    }

    function closeOnOverlay(e) {
        if (e.target.classList.contains('modal-overlay')) {
            closeProfile();
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') { closeProfile(); }
    });
</script>

</body>
</html>