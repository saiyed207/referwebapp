<?php
// Handle /start command
if (isset($update['message']['text']) && strpos(trim($update['message']['text']), '/start') === 0) {
    $chat_id = $update['message']['chat']['id'];
    
    // Create direct web app button
    $keyboard = [
        'inline_keyboard' => [
            [
                [
                    'text' => 'Open App Now', 
                    'web_app' => ['url' => 'https://refer123.netlify.app/']
                ]
            ]
        ]
    ];

    // Send message with direct button
    file_get_contents(API_URL . 'sendMessage?' . http_build_query([
        'chat_id' => $chat_id,
        'text' => "🎉 Tap below to open your rewards app!",
        'reply_markup' => json_encode($keyboard)
    ]));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mega Rewards App - Demo</title>
    <style>
        /* --- Global Styles & Variables --- */
        :root {
            --primary-color: #6a11cb;
            --secondary-color: #2575fc;
            --accent-color: #ff6b6b;
            --light-bg: #f8f9fa;
            --dark-text: #343a40;
            --light-text: #f8f9fa;
            --border-color: #dee2e6;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --error-color: #dc3545;
            --disabled-color: #adb5bd;
        }

        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--dark-text);
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Align to top for scroll */
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 700px; /* Increased width */
            text-align: center;
            transition: all 0.3s ease-in-out;
        }

        h1, h2, h3 {
            color: var(--primary-color);
            margin-bottom: 0.8em;
            font-weight: 600;
        }
        h1 {
            font-size: 2.2em;
            font-weight: 700;
            color: transparent;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            background-clip: text;
        }
        h2 { font-size: 1.8em; }
        h3 { font-size: 1.4em; color: var(--secondary-color); margin-top: 1.5em;}

        /* --- Forms & Inputs --- */
        label {
            display: block;
            margin-bottom: 8px;
            text-align: left;
            font-weight: 600;
            color: #555;
            font-size: 0.95em;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 18px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        input[type="text"]:focus, input[type="number"]:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(106, 17, 203, 0.2);
            outline: none;
        }
        input[readonly] {
            background-color: var(--light-bg);
            cursor: not-allowed;
        }

        /* --- Buttons --- */
        button {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 25px; /* Pill shape */
            cursor: pointer;
            font-size: 1.05em;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: inline-block; /* Needed for margins */
            margin-top: 10px;
        }
        button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
        button:active:not(:disabled) {
            transform: translateY(0px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        button:disabled {
            background: var(--disabled-color);
            cursor: not-allowed;
            box-shadow: none;
        }

        .secondary-button {
             background: none;
             border: 2px solid var(--secondary-color);
             color: var(--secondary-color);
             box-shadow: none;
        }
         .secondary-button:hover:not(:disabled) {
             background: var(--secondary-color);
             color: white;
             box-shadow: 0 4px 10px rgba(37, 117, 252, 0.2);
         }

        #logout-button {
            background: var(--accent-color);
            position: absolute;
            top: 25px;
            right: 30px;
            padding: 8px 15px;
            font-size: 0.9em;
            border-radius: 20px;
        }
         #logout-button:hover {
            background: darken(var(--accent-color), 10%);
         }

        /* --- Layout & Sections --- */
        .hidden { display: none !important; } /* Use important to override potential conflicts */

        #dashboard-section { position: relative; } /* For logout button positioning */

        .section {
            margin-top: 30px;
            padding: 25px;
            background-color: var(--light-bg);
            border-radius: 10px;
            border: 1px solid var(--border-color);
            text-align: left;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Responsive grid */
            gap: 25px;
            margin-top: 20px;
        }

        .grid-item {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0, 0.05);
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            align-items: center; /* Center content vertically */
             text-align: center; /* Center text */
        }
         .grid-item h4 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 1.2em;
         }
         .grid-item p {
            margin-bottom: 15px;
            color: #555;
            font-size: 0.95em;
            line-height: 1.5;
         }

        .points-display {
            font-size: 1.6em;
            font-weight: 700;
            color: var(--success-color);
            margin-bottom: 15px;
        }
         .points-display span {
             font-weight: 300;
             font-size: 0.8em;
             color: var(--dark-text);
             margin-left: 5px;
         }


        /* --- Messages & Info --- */
        .message {
            margin-top: 15px;
            font-weight: 600;
            padding: 10px;
            border-radius: 6px;
            font-size: 0.95em;
        }
        .message.success { color: var(--success-color); background-color: #d4edda; border: 1px solid #c3e6cb;}
        .message.error { color: var(--error-color); background-color: #f8d7da; border: 1px solid #f5c6cb; }
        .message.info { color: #0c5460; background-color: #d1ecf1; border: 1px solid #bee5eb; }
        .message:empty { display: none; } /* Hide if empty */

        .info-text {
            font-size: 0.9em;
            color: #6c757d;
            margin-top: 15px;
            font-style: italic;
            text-align: center;
        }
        .warning-box {
            margin-top: 30px;
            padding: 15px;
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            border-radius: 8px;
            font-size: 0.9em;
            text-align: center;
        }
        .warning-box strong { color: #664d03; }

        /* --- Referral Section --- */
        .referral-info strong { color: var(--secondary-color); }
        #user-referral-link-container { display: flex; align-items: center; margin-top: 10px; }
        #user-referral-link { flex-grow: 1; margin-right: 10px; margin-bottom: 0; }
        #copy-link-button { margin-top: 0; padding: 10px 15px; font-size: 0.9em; flex-shrink: 0;}

        ul#referred-users-list {
            list-style: none; /* Remove bullets */
            padding-left: 0;
            margin-top: 10px;
        }
         ul#referred-users-list li {
            background-color: #fff;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 5px;
            border: 1px solid var(--border-color);
            font-size: 0.9em;
            color: #444;
         }
         ul#referred-users-list li:empty { display: none; }


        /* --- Spin Wheel --- */
        .spin-wheel-container {
            position: relative;
            width: 200px; /* Adjust size as needed */
            height: 200px;
            margin: 20px auto; /* Center horizontally */
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #spin-wheel {
            width: 100%;
            height: 100%;
            border: 10px solid #ccc; /* Outer border */
            border-radius: 50%;
            position: relative;
            overflow: hidden;
            transition: transform 5s cubic-bezier(0.3, 1, 0.7, 1); /* Smooth spin animation */
            background: conic-gradient( /* Create segments with background */
                #ffadad 0deg 45deg,
                #ffd6a5 45deg 90deg,
                #fdffb6 90deg 135deg,
                #caffbf 135deg 180deg,
                #9bf6ff 180deg 225deg,
                #a0c4ff 225deg 270deg,
                #bdb2ff 270deg 315deg,
                #ffc6ff 315deg 360deg
            );
             box-shadow: inset 0 0 15px rgba(0,0,0,0.15);
        }
        .wheel-segment {
            position: absolute;
            width: 50%;
            height: 50%;
            top: 0;
            left: 50%;
            transform-origin: 0 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            /* background-color defined inline or via conic-gradient */
             font-weight: 600;
             font-size: 0.9em;
             color: rgba(0,0,0,0.7);
             padding-left: 25px; /* Push text towards outer edge */
             writing-mode: vertical-rl; /* Orient text if needed */
             text-orientation: mixed;
        }
         /* Positioning segments (example for 8 segments) */
        .wheel-segment:nth-child(1) { transform: rotate(22.5deg) skewY(-45deg); }
        .wheel-segment:nth-child(2) { transform: rotate(67.5deg) skewY(-45deg); }
        .wheel-segment:nth-child(3) { transform: rotate(112.5deg) skewY(-45deg); }
        /* ... and so on ... we'll use the conic gradient instead for simplicity */

        .wheel-pointer {
            position: absolute;
            top: -15px; /* Position above the wheel */
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            border-top: 25px solid var(--accent-color); /* Pointer color */
            z-index: 10;
        }
        .wheel-center-hub {
             position: absolute;
             width: 25px;
             height: 25px;
             background: #555;
             border-radius: 50%;
             border: 3px solid white;
             box-shadow: 0 0 5px rgba(0,0,0,0.3);
             z-index: 5;
        }

        /* --- Tap & Earn --- */
        #tap-button {
            padding: 20px 30px; /* Make it bigger */
            font-size: 1.2em;
            border-radius: 15px;
             margin-top: 10px;
        }
         #tap-timer {
            font-size: 0.9em;
            color: var(--secondary-color);
            margin-top: 10px;
            font-weight: 600;
            min-height: 1.2em; /* Prevent layout shift */
         }

        /* --- Scratch Card --- */
        .scratch-card-container {
            position: relative;
            width: 250px; /* Adjust size */
            height: 150px;
            margin: 20px auto;
            cursor: grab; /* Indicate scratchability */
             border-radius: 10px;
             overflow: hidden; /* Important */
             border: 3px dashed var(--disabled-color);
        }
        .scratch-card-prize {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--success-color), #a8e063);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.8em;
            font-weight: 700;
            text-align: center;
            padding: 10px;
            border-radius: 7px; /* Inner radius */
        }
        .scratch-card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #silver; /* Scratchable surface color */
            background: linear-gradient(135deg, #bdc3c7, #e0e0e0);
             box-shadow: inset 0 0 10px rgba(0,0,0,0.2);
            z-index: 1;
            transition: opacity 0.5s ease-out; /* For simple reveal */
            border-radius: 7px; /* Inner radius */
        }
        .scratch-card-overlay.scratched {
            opacity: 0; /* Reveal prize */
            pointer-events: none; /* Disable further interaction */
        }
         .scratch-active {
             cursor: grabbing;
         }

    </style>
</head>
<body>

    <div class="container">
        <h1>Mega Rewards</h1>

        <!-- Login/Signup Section -->
        <div id="auth-section">
            <h2>Welcome</h2>
            <p class="info-text">Login with your username or sign up to start earning!</p>
            <form id="auth-form">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required placeholder="Enter your username">

                <label for="referrer-code">Referral Code (Optional):</label>
                <input type="text" id="referrer-code" name="referrer-code" placeholder="Enter code if referred">

                <button type="submit">Sign Up / Log In</button>
                <p id="auth-message" class="message"></p>
            </form>
        </div>

        <!-- Dashboard Section (Visible after login) -->
        <div id="dashboard-section" class="hidden">
            <button id="logout-button">Logout</button>
            <h2 id="welcome-user"></h2>

            <div class="section points-section">
                <h3>Your Balance</h3>
                <div class="points-display">
                    <span id="user-points">0</span> Points
                </div>
            </div>

            <!-- Games Grid -->
            <div class="grid-container">
                <!-- Spin Wheel Item -->
                <div class="grid-item game-item">
                    <h4>Spin the Wheel!</h4>
                    <p>Win points daily. Good luck!</p>
                    <div class="spin-wheel-container">
                        <div class="wheel-pointer"></div>
                         <div class="wheel-center-hub"></div>
                        <div id="spin-wheel">
                            <!-- Segments defined by CSS background -->
                             <!-- You could add divs for text, but complicates styling -->
                        </div>
                    </div>
                    <button id="spin-button">Spin Now!</button>
                    <p id="spin-result" class="message info"></p>
                    <p id="spin-timer" class="info-text"></p>
                </div>

                <!-- Tap & Earn Item -->
                <div class="grid-item game-item">
                    <h4>Tap & Earn</h4>
                    <p>Tap the button for quick points. Check back often!</p>
                    <button id="tap-button">Tap Me!</button>
                    <p id="tap-result" class="message success"></p>
                    <div id="tap-timer" class="info-text">Ready to tap!</div>
                </div>

                <!-- Scratch Card Item -->
                 <div class="grid-item game-item">
                    <h4>Daily Scratch Card</h4>
                    <p>Scratch to reveal your prize!</p>
                    <div id="scratch-card-container" class="scratch-card-container">
                        <div id="scratch-card-prize" class="scratch-card-prize">? Points</div>
                        <div id="scratch-card-overlay" class="scratch-card-overlay"></div>
                    </div>
                    <button id="reset-scratch-button" class="secondary-button hidden">Get New Card Tomorrow</button>
                    <p id="scratch-result" class="message info"></p>
                     <p id="scratch-timer" class="info-text"></p>
                 </div>

                 <!-- Referral Info Item -->
                 <div class="grid-item referral-info">
                     <h4>Refer & Earn More</h4>
                     <p>Share your code or link with friends. You both earn points when they sign up!</p>
                     <p>Your unique referral code:<br><strong id="user-referral-code"></strong></p>
                     <p>Share this link:</p>
                     <div id="user-referral-link-container">
                         <input type="text" id="user-referral-link" readonly>
                         <button id="copy-link-button" class="secondary-button">Copy</button>
                     </div>
                     <p id="copy-message" class="message success"></p>
                 </div>

            </div>

            <!-- Referral Stats Section -->
            <div class="section referral-stats">
                 <h3>Referral Status</h3>
                 <p>You were referred by: <strong id="referred-by">N/A</strong></p>
                 <p>Users you've referred (<span id="referral-count">0</span>):</p>
                 <ul id="referred-users-list">
                     <li id="no-referrals-message">No referrals yet.</li>
                 </ul>
            </div>

        </div>

         <div class="warning-box">
            <strong>Disclaimer:</strong> This is a front-end demo using localStorage for storage. Data is **not secure**, not persistent across devices/browsers, and can be easily manipulated. Do not use for real rewards or sensitive information.
         </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- DOM Elements ---
            const authSection = document.getElementById('auth-section');
            const dashboardSection = document.getElementById('dashboard-section');
            const authForm = document.getElementById('auth-form');
            const usernameInput = document.getElementById('username');
            const referrerCodeInput = document.getElementById('referrer-code');
            const authMessage = document.getElementById('auth-message');

            const welcomeUser = document.getElementById('welcome-user');
            const userPointsDisplay = document.getElementById('user-points');
            const logoutButton = document.getElementById('logout-button');

            // Referral elements
            const userReferralCode = document.getElementById('user-referral-code');
            const userReferralLink = document.getElementById('user-referral-link');
            const copyLinkButton = document.getElementById('copy-link-button');
            const copyMessage = document.getElementById('copy-message');
            const referredBy = document.getElementById('referred-by');
            const referralCount = document.getElementById('referral-count');
            const referredUsersList = document.getElementById('referred-users-list');
            const noReferralsMessage = document.getElementById('no-referrals-message');

            // Spin Wheel elements
            const spinWheel = document.getElementById('spin-wheel');
            const spinButton = document.getElementById('spin-button');
            const spinResult = document.getElementById('spin-result');
            const spinTimer = document.getElementById('spin-timer');

             // Tap & Earn elements
            const tapButton = document.getElementById('tap-button');
            const tapResult = document.getElementById('tap-result');
            const tapTimer = document.getElementById('tap-timer');

            // Scratch Card elements
            const scratchCardContainer = document.getElementById('scratch-card-container');
            const scratchCardPrize = document.getElementById('scratch-card-prize');
            const scratchCardOverlay = document.getElementById('scratch-card-overlay');
            const resetScratchButton = document.getElementById('reset-scratch-button');
            const scratchResult = document.getElementById('scratch-result');
            const scratchTimer = document.getElementById('scratch-timer');


            // --- Constants & Config ---
            const STORAGE_KEY = 'megaRewardsAppData';
            const CURRENT_USER_KEY = 'megaRewardsCurrentUser';
            const REFERRAL_POINTS = 50; // Points for successful referral (both sides)
            const SIGNUP_BONUS = 10; // Points for just signing up
            const SPIN_PRIZES = [10, 5, 20, 0, 50, 2, 15, 1]; // Points for each segment
            const SPIN_COOLDOWN_MS = 24 * 60 * 60 * 1000; // 24 hours
            const TAP_REWARD = 3;
            const TAP_COOLDOWN_MS = 1 * 60 * 60 * 1000; // 1 hour
            const SCRATCH_PRIZES = [5, 10, 0, 25, 2, 15, 50, 1];
            const SCRATCH_COOLDOWN_MS = 24 * 60 * 60 * 1000; // 24 hours

            let currentUser = null; // Holds the current logged-in user's data object
            let tapIntervalId = null; // To store interval ID for tap timer
            let spinCooldownTimeoutId = null;
            let scratchCooldownTimeoutId = null;
            let isSpinning = false;
            let isScratching = false; // For mouse events on scratch card


            // --- Data Handling ---
            function loadData() {
                const data = localStorage.getItem(STORAGE_KEY);
                return data ? JSON.parse(data) : { users: {} };
            }

            function saveData(data) {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
            }

             function getCurrentUsername() {
                return localStorage.getItem(CURRENT_USER_KEY);
            }

            function setCurrentUsername(username) {
                if (username) {
                    localStorage.setItem(CURRENT_USER_KEY, username);
                } else {
                    localStorage.removeItem(CURRENT_USER_KEY);
                    currentUser = null; // Clear the user object too
                }
            }

             function updateCurrentUser(userData) {
                if (!userData || !userData.username) return;
                const data = loadData();
                data.users[userData.username] = userData;
                currentUser = userData; // Update local copy
                saveData(data);
                // Immediately update points display if on dashboard
                if (!dashboardSection.classList.contains('hidden')) {
                    userPointsDisplay.textContent = userData.points;
                }
             }

             function addPoints(username, amount, reason = "earned") {
                 if (amount <= 0) return; // Don't add zero or negative points

                 const data = loadData();
                 const user = data.users[username];
                 if (user) {
                     user.points = (user.points || 0) + amount;
                     console.log(`${username} ${reason}: +${amount} points. New total: ${user.points}`);
                     // If the action is by the currently logged-in user, update their object
                     if (currentUser && currentUser.username === username) {
                          updateCurrentUser(user); // Updates currentUser object and saves
                     } else {
                         saveData(data); // Save changes for other users
                     }
                     return true; // Indicate success
                 }
                 return false; // User not found
             }


            // --- Utility Functions ---
            function generateReferralCode(length = 8) {
                const characters = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789'; // Avoid O, 0, I, l
                let result = '';
                for (let i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() * characters.length));
                }
                // TODO: Add check for uniqueness in a real app
                return result;
            }

            function displayMessage(element, message, type = 'info') {
                 element.textContent = message;
                 element.className = `message ${type}`; // Reset classes and add new ones
                 // Auto-clear message after a delay (except maybe errors?)
                 if (type !== 'error') {
                    setTimeout(() => {
                        if(element.textContent === message) { // Avoid clearing a newer message
                             element.textContent = '';
                             element.className = 'message';
                        }
                    }, 4000);
                 }
            }

            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(() => {
                    displayMessage(copyMessage, 'Link copied!', 'success');
                }).catch(err => {
                    console.error('Failed to copy: ', err);
                    displayMessage(copyMessage, 'Failed to copy link.', 'error');
                    // Basic fallback
                    try {
                        const textArea = document.createElement("textarea");
                        textArea.value = text;
                        textArea.style.position = "fixed"; // Avoid scrolling
                        document.body.appendChild(textArea);
                        textArea.focus();
                        textArea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textArea);
                         displayMessage(copyMessage, 'Link copied (fallback)!', 'success');
                    } catch (execErr) {
                         displayMessage(copyMessage, 'Copying failed.', 'error');
                    }
                });
            }

            function formatTimeRemaining(ms) {
                 if (ms <= 0) return "Ready!";
                 const totalSeconds = Math.max(0, Math.floor(ms / 1000));
                 const hours = Math.floor(totalSeconds / 3600);
                 const minutes = Math.floor((totalSeconds % 3600) / 60);
                 const seconds = totalSeconds % 60;
                 let str = "Ready in: ";
                 if (hours > 0) str += `${hours}h `;
                 if (minutes > 0 || hours > 0) str += `${minutes}m `; // Show minutes even if 0 when hours are present
                 str += `${seconds}s`;
                 return str;
             }

             // Check if a day has passed since the last timestamp
             function isNewDay(lastTimestamp) {
                 if (!lastTimestamp) return true; // Never done before
                 const lastDate = new Date(lastTimestamp);
                 const today = new Date();
                 return today.getFullYear() > lastDate.getFullYear() ||
                        today.getMonth() > lastDate.getMonth() ||
                        today.getDate() > lastDate.getDate();
             }


            // --- Core Logic: Auth ---
            function handleAuth(event) {
                event.preventDefault();
                const username = usernameInput.value.trim().toLowerCase();
                const referrerCode = referrerCodeInput.value.trim().toUpperCase(); // Codes are uppercase

                if (!username) {
                    displayMessage(authMessage, 'Username cannot be empty.', 'error');
                    return;
                }

                const data = loadData();

                if (data.users[username]) {
                    // Log In
                    loginUser(username);
                     displayMessage(authMessage, `Welcome back, ${username}!`, 'success');
                } else {
                    // Sign Up
                    signupUser(username, referrerCode);
                }
            }

            function signupUser(username, referrerCodeInput) {
                const data = loadData();
                let newReferralCode = generateReferralCode();
                // Basic check for code uniqueness (better needed for real app)
                while (Object.values(data.users).some(u => u.referralCode === newReferralCode)) {
                    newReferralCode = generateReferralCode();
                }

                 const now = Date.now();
                const newUser = {
                    username: username,
                    referralCode: newReferralCode,
                    referredBy: null, // Store the USERNAME of the referrer
                    referredUsers: [], // List of usernames this user has referred
                    points: SIGNUP_BONUS, // Start with some points
                    signupDate: new Date().toISOString(),
                    lastSpinTime: null,
                    lastTapTime: null,
                    lastScratchTime: null,
                };

                let referralSuccess = false;
                // Check if a valid referrer code was provided
                if (referrerCodeInput) {
                    const referrer = Object.values(data.users).find(user => user.referralCode === referrerCodeInput);
                    if (referrer) {
                         if (referrer.username === username) {
                            displayMessage(authMessage, 'You cannot refer yourself.', 'error');
                            // Proceed with signup without referral bonus
                         } else {
                            newUser.referredBy = referrer.username;
                            // Add this new user to the referrer's list
                            if (!referrer.referredUsers.includes(username)) {
                                referrer.referredUsers.push(username);
                            }
                            console.log(`${username} referred by ${referrer.username}. Awarding points.`);
                            // Award points to both
                            addPoints(newUser.username, REFERRAL_POINTS, "for being referred");
                            addPoints(referrer.username, REFERRAL_POINTS, `for referring ${username}`);
                            referralSuccess = true;
                            // No need to save data here, addPoints handles it if referrer isn't current user
                         }
                    } else {
                         displayMessage(authMessage, 'Invalid referral code. Signed up without bonus.', 'info');
                    }
                }

                data.users[username] = newUser;
                saveData(data); // Save the new user data
                loginUser(username); // Log in the new user
                if (referralSuccess) {
                     displayMessage(authMessage, `Signup successful! You and your referrer earned ${REFERRAL_POINTS} points!`, 'success');
                } else if (!referrerCodeInput || !Object.values(data.users).find(user => user.referralCode === referrerCodeInput)) {
                    // Avoid double success message if invalid code message was shown
                    displayMessage(authMessage, `Sign up successful! You earned ${SIGNUP_BONUS} bonus points.`, 'success');
                }
            }

            function loginUser(username) {
                const data = loadData();
                currentUser = data.users[username]; // Load user data into memory

                if (!currentUser) {
                     console.error("Login failed: User data not found for", username);
                     displayMessage(authMessage, 'Login failed. User data not found.', 'error');
                     setCurrentUsername(null);
                     return;
                }

                // --- Check and Reset Daily Activities ---
                const now = Date.now();
                let changed = false;
                if (isNewDay(currentUser.lastSpinTime)) {
                    console.log(`${username}: Resetting daily spin.`);
                    currentUser.lastSpinTime = null; // Mark as ready for today
                    changed = true;
                }
                 if (isNewDay(currentUser.lastScratchTime)) {
                    console.log(`${username}: Resetting daily scratch.`);
                    currentUser.lastScratchTime = null; // Mark as ready
                    changed = true;
                }
                 // Tap cooldown is shorter, handled by its own timer

                if (changed) {
                    updateCurrentUser(currentUser); // Save potentially reset timestamps
                }
                // --- End Daily Reset Check ---

                setCurrentUsername(username);
                authSection.classList.add('hidden');
                dashboardSection.classList.remove('hidden');
                authForm.reset();
                authMessage.textContent = '';
                displayDashboard(); // Display based on the currentUser object
            }

            function handleLogout() {
                 // Clear any running timers
                 if (tapIntervalId) clearInterval(tapIntervalId);
                 if (spinCooldownTimeoutId) clearTimeout(spinCooldownTimeoutId);
                 if (scratchCooldownTimeoutId) clearTimeout(scratchCooldownTimeoutId);
                 tapIntervalId = null;
                 spinCooldownTimeoutId = null;
                 scratchCooldownTimeoutId = null;
                 isSpinning = false;

                setCurrentUsername(null); // Clear current user from localStorage
                dashboardSection.classList.add('hidden');
                authSection.classList.remove('hidden');
                // Clear dashboard fields (optional, they get repopulated on login)
                usernameInput.value = '';
                referrerCodeInput.value = '';
            }


            // --- Dashboard Display & Updates ---
            function displayDashboard() {
                 if (!currentUser) return; // Should not happen if called correctly

                 welcomeUser.textContent = `Welcome, ${currentUser.username}!`;
                 userPointsDisplay.textContent = currentUser.points || 0;

                 // Referral Info
                 userReferralCode.textContent = currentUser.referralCode;
                 const baseUrl = window.location.origin + window.location.pathname;
                 userReferralLink.value = `${baseUrl}?ref=${currentUser.referralCode}`;
                 referredBy.textContent = currentUser.referredBy || 'N/A';
                 referralCount.textContent = currentUser.referredUsers.length;

                 if (currentUser.referredUsers.length > 0) {
                     referredUsersList.innerHTML = ''; // Clear default
                     noReferralsMessage.classList.add('hidden');
                     currentUser.referredUsers.forEach(uname => {
                         const li = document.createElement('li');
                         li.textContent = uname;
                         referredUsersList.appendChild(li);
                     });
                 } else {
                     referredUsersList.innerHTML = ''; // Clear potential old entries
                     referredUsersList.appendChild(noReferralsMessage); // Add back the default message li
                     noReferralsMessage.classList.remove('hidden');
                 }
                 copyMessage.textContent = ''; // Clear copy message

                // Update Game States
                updateSpinWheelState();
                updateTapState();
                updateScratchCardState();
            }

            // --- Game Logic: Spin Wheel ---
            function updateSpinWheelState() {
                if (!currentUser) return;
                const now = Date.now();
                spinResult.textContent = ''; // Clear previous result

                if (currentUser.lastSpinTime && now < currentUser.lastSpinTime + SPIN_COOLDOWN_MS) {
                    // Still on cooldown
                    spinButton.disabled = true;
                    const timeRemaining = (currentUser.lastSpinTime + SPIN_COOLDOWN_MS) - now;
                    spinTimer.textContent = `Next spin available in: ${formatTimeRemaining(timeRemaining)}`;
                    // Set a timeout to re-enable when cooldown ends
                    if (spinCooldownTimeoutId) clearTimeout(spinCooldownTimeoutId); // Clear previous timeout
                    spinCooldownTimeoutId = setTimeout(updateSpinWheelState, timeRemaining + 1000); // Check again after cooldown
                } else {
                    // Ready to spin
                    spinButton.disabled = false;
                    spinTimer.textContent = 'Ready to Spin!';
                     if (spinCooldownTimeoutId) clearTimeout(spinCooldownTimeoutId);
                     spinCooldownTimeoutId = null;
                }
            }

            function handleSpin() {
                if (!currentUser || isSpinning || spinButton.disabled) return;

                isSpinning = true;
                spinButton.disabled = true;
                spinResult.textContent = 'Spinning...';
                spinResult.className = 'message info';

                const segmentCount = SPIN_PRIZES.length;
                const segmentAngle = 360 / segmentCount;
                const randomSegment = Math.floor(Math.random() * segmentCount);
                const prize = SPIN_PRIZES[randomSegment];

                // Calculate rotation: multiple full spins + target segment angle
                // Adjusting target angle slightly off center for better pointer alignment
                const targetAngle = (randomSegment * segmentAngle) + (segmentAngle / 2);
                const randomOffset = (Math.random() - 0.5) * (segmentAngle * 0.8); // Randomness within segment
                const finalAngle = (360 * 5) + targetAngle + randomOffset; // 5 full spins

                spinWheel.style.transform = `rotate(${finalAngle}deg)`;

                // Use setTimeout matching the CSS transition duration
                 setTimeout(() => {
                    isSpinning = false;
                    displayMessage(spinResult, `You won ${prize} points!`, prize > 0 ? 'success' : 'info');

                    if (prize > 0) {
                         addPoints(currentUser.username, prize, "from spin wheel");
                    }

                    currentUser.lastSpinTime = Date.now();
                    updateCurrentUser(currentUser); // Save the timestamp
                    updateSpinWheelState(); // Update button state and timer

                    // Reset wheel visually after a short delay (optional)
                    setTimeout(() => {
                        spinWheel.style.transition = 'none'; // Disable transition for reset
                        spinWheel.style.transform = 'rotate(0deg)';
                        // Force reflow before re-enabling transition
                        spinWheel.offsetHeight; // Read offsetHeight to trigger reflow
                        spinWheel.style.transition = 'transform 5s cubic-bezier(0.3, 1, 0.7, 1)';
                    }, 1500);

                 }, 5000); // Match CSS transition duration
            }


            // --- Game Logic: Tap & Earn ---
            function updateTapState() {
                 if (!currentUser) return;
                 if (tapIntervalId) clearInterval(tapIntervalId); // Clear existing timer

                 const now = Date.now();
                 const lastTap = currentUser.lastTapTime || 0;
                 const timeRemaining = (lastTap + TAP_COOLDOWN_MS) - now;

                 if (timeRemaining <= 0) {
                     // Ready to tap
                     tapButton.disabled = false;
                     tapTimer.textContent = "Ready to tap!";
                     tapResult.textContent = ''; // Clear previous result
                 } else {
                     // On cooldown
                     tapButton.disabled = true;
                     tapTimer.textContent = formatTimeRemaining(timeRemaining);
                     // Start interval to update timer display
                     tapIntervalId = setInterval(() => {
                         const nowInner = Date.now();
                         const remainingInner = (lastTap + TAP_COOLDOWN_MS) - nowInner;
                         if (remainingInner <= 0) {
                             clearInterval(tapIntervalId);
                             tapIntervalId = null;
                             updateTapState(); // Re-check state (should be ready now)
                         } else {
                             tapTimer.textContent = formatTimeRemaining(remainingInner);
                         }
                     }, 1000); // Update every second
                 }
            }

            function handleTap() {
                 if (!currentUser || tapButton.disabled) return;

                 const now = Date.now();
                 if (now >= (currentUser.lastTapTime || 0) + TAP_COOLDOWN_MS) {
                     addPoints(currentUser.username, TAP_REWARD, "from tap");
                     displayMessage(tapResult, `+${TAP_REWARD} points tapped!`, 'success');
                     currentUser.lastTapTime = now;
                     updateCurrentUser(currentUser);
                     updateTapState(); // Update button and start timer
                 } else {
                     console.warn("Tap attempted while on cooldown."); // Should be prevented by disabled state
                 }
            }

             // --- Game Logic: Scratch Card ---
             function updateScratchCardState() {
                 if (!currentUser) return;

                 const now = Date.now();
                 scratchResult.textContent = ''; // Clear message
                 resetScratchButton.classList.add('hidden'); // Hide reset button initially
                 scratchCardOverlay.classList.remove('scratched'); // Ensure overlay is visible
                 scratchCardOverlay.style.opacity = '1'; // Reset opacity explicitly
                 scratchCardContainer.style.cursor = 'grab'; // Reset cursor
                 isScratching = false;

                 // Cancel any existing cooldown timer
                 if (scratchCooldownTimeoutId) clearTimeout(scratchCooldownTimeoutId);
                 scratchCooldownTimeoutId = null;

                 if (currentUser.lastScratchTime && now < currentUser.lastScratchTime + SCRATCH_COOLDOWN_MS) {
                     // On cooldown
                     scratchCardContainer.style.cursor = 'not-allowed';
                     scratchCardPrize.textContent = 'Locked'; // Indicate unavailable
                     scratchCardOverlay.style.opacity = '0.7'; // Dim it slightly
                     scratchCardOverlay.style.pointerEvents = 'none'; // Prevent interaction
                     resetScratchButton.classList.remove('hidden'); // Show reset info
                     resetScratchButton.disabled = true;

                     const timeRemaining = (currentUser.lastScratchTime + SCRATCH_COOLDOWN_MS) - now;
                     scratchTimer.textContent = `New card in: ${formatTimeRemaining(timeRemaining)}`;

                     // Set timer to refresh state when cooldown ends
                     scratchCooldownTimeoutId = setTimeout(updateScratchCardState, timeRemaining + 1000);

                 } else {
                     // Ready for a new scratch
                     // Determine prize for *this* card instance
                     const prizeAmount = SCRATCH_PRIZES[Math.floor(Math.random() * SCRATCH_PRIZES.length)];
                     scratchCardPrize.textContent = `${prizeAmount} Points`;
                     // Store the prize amount temporarily on the element itself for retrieval after scratch
                     scratchCardContainer.dataset.prize = prizeAmount;

                     scratchCardOverlay.style.pointerEvents = 'auto'; // Enable interaction
                     scratchTimer.textContent = 'Ready to Scratch!';
                 }
             }


             function handleScratchInteraction(event) {
                 if (!currentUser || scratchCardOverlay.classList.contains('scratched') || !scratchCardContainer.dataset.prize) return;

                 // Only proceed if mouse button is down (or touch equivalent)
                  if (event.type === 'mousemove' && !isScratching) {
                      return; // Don't scratch just on hover
                  }
                  if (event.type === 'mousedown') {
                    isScratching = true;
                     scratchCardContainer.classList.add('scratch-active');
                 }
                 if (event.type === 'mouseup' || event.type === 'mouseleave') {
                      isScratching = false;
                       scratchCardContainer.classList.remove('scratch-active');
                 }

                 // Simple Reveal Logic: Reveal fully on first valid interaction
                 if (isScratching || event.type === 'mousedown') { // Scratch on drag or initial click
                    scratchCardOverlay.classList.add('scratched'); // Trigger CSS transition
                    scratchCardContainer.style.cursor = 'default'; // Change cursor back

                    const prize = parseInt(scratchCardContainer.dataset.prize || '0', 10);
                    displayMessage(scratchResult, `You won ${prize} points!`, prize > 0 ? 'success' : 'info');

                    if (prize > 0) {
                         addPoints(currentUser.username, prize, "from scratch card");
                    }

                    // Mark as used for today and update state
                    currentUser.lastScratchTime = Date.now();
                    updateCurrentUser(currentUser);
                     // Remove prize data from element after awarding
                    delete scratchCardContainer.dataset.prize;

                    // Update state to show cooldown (will disable interaction)
                    // Small delay to let the animation finish before timer appears
                    setTimeout(updateScratchCardState, 500);
                 }
             }


            // --- Initialization ---
            function initApp() {
                // Check for referral code in URL
                const urlParams = new URLSearchParams(window.location.search);
                const refCodeFromUrl = urlParams.get('ref');
                if (refCodeFromUrl) {
                    referrerCodeInput.value = refCodeFromUrl.toUpperCase();
                    // Clean the URL (optional)
                    // window.history.replaceState({}, document.title, window.location.pathname);
                }

                // Check if user is already logged in
                const loggedInUsername = getCurrentUsername();
                if (loggedInUsername) {
                    const data = loadData();
                    if (data.users[loggedInUsername]) {
                        loginUser(loggedInUsername); // This loads user data and checks daily resets
                    } else {
                        // Stored user doesn't exist in data (data cleared partially?)
                        handleLogout(); // Force logout
                    }
                } else {
                    // Show login/signup form
                    authSection.classList.remove('hidden');
                    dashboardSection.classList.add('hidden');
                }

                // --- Add Event Listeners ---
                authForm.addEventListener('submit', handleAuth);
                logoutButton.addEventListener('click', handleLogout);
                copyLinkButton.addEventListener('click', () => {
                    if (userReferralLink.value) {
                        copyToClipboard(userReferralLink.value);
                    }
                });

                // Game Listeners
                spinButton.addEventListener('click', handleSpin);
                tapButton.addEventListener('click', handleTap);

                // Scratch Card Listeners (handle mouse down/move/up/leave for dragging effect simulation)
                 scratchCardOverlay.addEventListener('mousedown', handleScratchInteraction);
                 // Add listeners to the container as well for mouseup/leave to stop scratching if mouse leaves overlay while down
                 scratchCardContainer.addEventListener('mousemove', handleScratchInteraction);
                 scratchCardContainer.addEventListener('mouseup', handleScratchInteraction);
                 scratchCardContainer.addEventListener('mouseleave', handleScratchInteraction);
                  // Basic touch support simulation
                 scratchCardOverlay.addEventListener('touchstart', (e) => { e.preventDefault(); isScratching = true; handleScratchInteraction(e); }, { passive: false });
                 scratchCardContainer.addEventListener('touchmove', (e) => { e.preventDefault(); handleScratchInteraction(e); }, { passive: false });
                 scratchCardContainer.addEventListener('touchend', () => { isScratching = false; });

            }

            // Start the application
            initApp();
        });
    </script>

</body>
</html>
