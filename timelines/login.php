<?php
session_start();
include('php/connection.php'); // expects $con (mysqli)

/* --------------------------------------------------------------------------
 | FashionHub Auth Page (Login / Signup / Forgot Password – 3 Steps)
 | --------------------------------------------------------------------------
 | This version fixes the forgot-password step logic by:
 |  - Persisting the current step in $_SESSION['forgot_step']
 |  - NEVER resetting the step to 1 unless it is a fresh start
 |  - Correctly assigning the step (using =, not ==)
 |  - Keeping the UI on the correct step after POST/refresh
 |
 | NOTE: For compatibility with your current database, this example
 | validates passwords as PLAINTEXT (as in your original code).
 | In production, you should store hashed passwords and use password_hash
 | / password_verify. See the SECURITY NOTES near the end of this file.
 |-------------------------------------------------------------------------- */

// ------------------------------
// Helpers
// ------------------------------
function h($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

// ------------------------------
// Initialize view-state variables
// ------------------------------
$active_form  = $_SESSION['active_form']  ?? 'login';
$forgot_step  = $_SESSION['forgot_step']  ?? 1;  // 1 -> verify, 2 -> set new pwd, 3 -> success
$login_error  = $_SESSION['flash_login_error']  ?? '';
$signup_error = $_SESSION['flash_signup_error'] ?? '';
$forgot_error = $_SESSION['flash_forgot_error'] ?? '';

// Clear flash errors for next render
unset($_SESSION['flash_login_error'], $_SESSION['flash_signup_error'], $_SESSION['flash_forgot_error']);

// ------------------------------
// Preserve user-entered values across submits for signup
// ------------------------------
$fname   = $_SESSION['tmp_fname']   ?? '';
$lname   = $_SESSION['tmp_lname']   ?? '';
$email   = $_SESSION['tmp_email']   ?? '';
$phone   = $_SESSION['tmp_phone']   ?? '';
$address = $_SESSION['tmp_address'] ?? '';

// ------------------------------
// Handle GET switches first (allow clean entry to forms)
// ------------------------------
if (isset($_GET['form'])) {
    $form = $_GET['form'];
    if (in_array($form, ['login','signup','forgot','signup-success'], true)) {
        $_SESSION['active_form'] = $form;
        // Only initialize forgot flow if it's a true fresh start (no existing step)
        if ($form === 'forgot' && !isset($_SESSION['forgot_step'])) {
            $_SESSION['forgot_step'] = 1;
            unset($_SESSION['reset_email']);
        }
    }
    // Reflect immediately in local variables for this render
    $active_form = $_SESSION['active_form'] ?? 'login';
    $forgot_step = $_SESSION['forgot_step'] ?? 1;
}

// ------------------------------
// Handle POST actions
// ------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // LOGIN PROCESS ---------------------------------------------------------
    if (isset($_POST['login-btn'])) {
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Basic sanitization (keeping it close to your original flow)
        $se = mysqli_real_escape_string($con, $email);
        $query = "SELECT * FROM user WHERE email = '$se' AND status = 'active' LIMIT 1";

        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            // PLAINTEXT check for compatibility with your DB (see SECURITY NOTES)
            if($user['status']==='active'){
            if ($password === $user['password']) {
                $_SESSION['is_logged_in'] = true;
                $_SESSION['user_id']      = $user['user_id'];
                $_SESSION['email']        = $user['email'];
                $_SESSION['role']         = $user['role'];
                $_SESSION['user_name']    = $user['name'];

                if ($_SESSION['role'] === 'user') {
                    header('Location: profile.php');
                    exit;
                } else {
                    header('Location: AdminLTE-3/dashbord.php');
                    exit;
                }
            } else {
                $_SESSION['flash_login_error'] = 'Wrong password';
            }
        } else {
            $_SESSION['flash_login_error'] = 'Email not found';
        }
    }else{
         $_SESSION['flash_login_error'] = 'user accout is blocked';
    }

        $_SESSION['active_form'] = 'login';
        header('Location: '.$_SERVER['PHP_SELF']);
        exit;
    }

    // SIGNUP PROCESS --------------------------------------------------------
    if (isset($_POST['signup-btn'])) {
        $fname   = trim($_POST['fname']   ?? '');
        $lname   = trim($_POST['lname']   ?? '');
        $email   = trim($_POST['email']   ?? '');
        $phone   = trim($_POST['phone']   ?? '');
        $address = trim($_POST['address'] ?? '');
        $pin     = trim($_POST['pin'] ?? '');
        $city    = trim($_POST['city'] ?? '');
        $state   = trim($_POST['state'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm  = trim($_POST['confirm_password'] ?? '');

        // Persist entered fields across potential error reload
        $_SESSION['tmp_fname']   = $fname;
        $_SESSION['tmp_lname']   = $lname;
        $_SESSION['tmp_email']   = $email;
        $_SESSION['tmp_phone']   = $phone;
        $_SESSION['tmp_address'] = $address;

        if ($password !== $confirm) {
            $_SESSION['flash_signup_error'] = 'Passwords do not match';
            $_SESSION['active_form'] = 'signup';
            header('Location: '.$_SERVER['PHP_SELF']);
            exit;
        }

        $se = mysqli_real_escape_string($con, $email);
        $check = mysqli_query($con, "SELECT user_id FROM user WHERE email = '$se' LIMIT 1");
        if ($check && mysqli_num_rows($check) > 0) {
            $_SESSION['flash_signup_error'] = 'Email already registered';
            $_SESSION['active_form'] = 'signup';
            header('Location: '.$_SERVER['PHP_SELF']);
            exit;
        }

        $full_name = trim($fname.' '.$lname);
        $sn = mysqli_real_escape_string($con, $full_name);
        $sp = mysqli_real_escape_string($con, $phone);
        $sa = mysqli_real_escape_string($con, $address);
        $spw = mysqli_real_escape_string($con, $confirm); // plaintext for compatibility

        $insert = "INSERT INTO user (name, email, password, role, phone, address ,pin ,city ,stat, created_at)
                   VALUES ('$sn', '$se', '$spw', 'user', '$sp', '$sa','$pin','$city','$state', NOW())";
        if (mysqli_query($con, $insert)) {
            // Clear temp values now that signup succeeded
            unset($_SESSION['tmp_fname'], $_SESSION['tmp_lname'], $_SESSION['tmp_email'], $_SESSION['tmp_phone'], $_SESSION['tmp_address']);
            $_SESSION['active_form'] = 'signup-success';
            header('Location: '.$_SERVER['PHP_SELF'].'?form=signup-success');
            exit;
        } else {
            $_SESSION['flash_signup_error'] = 'Signup failed. Please try again.';
            $_SESSION['active_form'] = 'signup';
            header('Location: '.$_SERVER['PHP_SELF']);
            exit;
        }
    }

    // FORGOT PASSWORD – STEP 1: Verify identity ---------------------------
    if (isset($_POST['forgot-step1-submit'])) {
        $fname = trim($_POST['fname'] ?? '');
        $lname = trim($_POST['lname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $full_name = trim($fname.' '.$lname);

       $se = mysqli_real_escape_string($con, $email);
         $sn = mysqli_real_escape_string($con, $full_name);
         
         $sql = "SELECT user_id, role FROM user WHERE email = '$se' AND name = '$sn' LIMIT 1";
         $result = mysqli_query($con, $sql);
         
         if ($result && mysqli_num_rows($result) === 1) {
             
         $row = mysqli_fetch_assoc($result);
         $role = strtolower($row['role']); // assuming role is 'admin' or 'user'
     
            if ($role === 'user') {
                // ✅ Normal user - allow reset
                $_SESSION['reset_email'] = $email;
                $_SESSION['forgot_step'] = 2;  // Move to step 2
            } else {
                // ❌ Admin role - block reset
                $_SESSION['flash_forgot_error'] = 'Admin password cannot be reset here.';
                $_SESSION['forgot_step'] = 1;
            }
        } else {
            $_SESSION['flash_forgot_error'] = 'User not found. Please check your details.';
            $_SESSION['forgot_step'] = 1;
        }
        $_SESSION['active_form'] = 'forgot';
        header('Location: '.$_SERVER['PHP_SELF'].'?form=forgot');
        exit;
    }

    // FORGOT PASSWORD – STEP 2: Set new password --------------------------
    if (isset($_POST['forgot-step2-submit'])) {
        if (!isset($_SESSION['reset_email'])) {
            $_SESSION['flash_forgot_error'] = 'Session expired. Please start over.';
            $_SESSION['forgot_step'] = 1;
            $_SESSION['active_form'] = 'forgot';
            header('Location: '.$_SERVER['PHP_SELF'].'?form=forgot');
            exit;
        }

        $email = $_SESSION['reset_email'];
        $new_password = trim($_POST['new_password'] ?? '');
        $confirm      = trim($_POST['confirm_password'] ?? '');

        if ($new_password === '' || $confirm === '' || $new_password !== $confirm) {
            $_SESSION['flash_forgot_error'] = 'Passwords must match';
            $_SESSION['forgot_step'] = 2;
            $_SESSION['active_form'] = 'forgot';
            header('Location: '.$_SERVER['PHP_SELF'].'?form=forgot');
            exit;
        }

        $se = mysqli_real_escape_string($con, $email);
        $spw = mysqli_real_escape_string($con, $confirm); // plaintext for compatibility
        $update = "UPDATE user SET password = '$spw' WHERE email = '$se' LIMIT 1";

        if (mysqli_query($con, $update)) {
            unset($_SESSION['reset_email']);
            $_SESSION['forgot_step'] = 3; // ✅ success
        } else {
            $_SESSION['flash_forgot_error'] = 'Error updating password.';
            $_SESSION['forgot_step'] = 2;
        }
        $_SESSION['active_form'] = 'forgot';
        header('Location: '.$_SERVER['PHP_SELF'].'?form=forgot');
        exit;
    }
}

// After potential POST redirects, refresh state for rendering
$active_form  = $_SESSION['active_form'] ?? 'login';
$forgot_step  = $_SESSION['forgot_step'] ?? 1;
$login_error  = $_SESSION['flash_login_error']  ?? $login_error;
$signup_error = $_SESSION['flash_signup_error'] ?? $signup_error;
$forgot_error = $_SESSION['flash_forgot_error'] ?? $forgot_error;

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <title>TimeLines | Premium Watches</title>
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="Font-Awesome-6.4.0/css/all.min.css">
     <script src="jquery/jquery-3.6.0.min.js"></script>
      <link rel="stylesheet" href="css1/login.css?v=1" >
</head>
<body>
    <!-- Theme toggle -->
    <div class="theme-toggle" id="themeToggle" title="Toggle theme">
        <i class="fas fa-moon"></i>
    </div>

    <div class="container-main">
        <div class="auth-card">
            <div class="auth-visual"></div>
            <div>
                <i class="fas fa-tshirt fashion-decor decor-1"></i>
                <i class="fas fa-shoe-prints fashion-decor decor-2"></i>

                <div class="auth-header">
                    <h2 id="form-title">
                        <?php
                        if ($active_form === 'login') echo 'Welcome Back!';
                        elseif ($active_form === 'signup') echo 'Create Account';
                        elseif ($active_form === 'forgot') echo 'Reset Password';
                        elseif ($active_form === 'signup-success') echo 'Account Created!';
                        else echo 'FashionHub';
                        ?>
                    </h2>
                    <p id="form-subtitle">
                        <?php
                        if ($active_form === 'login') echo 'Sign in to your account';
                        elseif ($active_form === 'signup') echo 'Join our fashion community';
                        elseif ($active_form === 'forgot') echo 'Reset your password in a few steps';
                        elseif ($active_form === 'signup-success') echo 'Your account has been created';
                        else echo 'Fashion for everyone';
                        ?>
                    </p>
                </div>

                <?php if ($login_error): ?>
                <div class="status-message status-error"><?php echo h($login_error); ?></div>
                <?php endif; ?>

                <?php if ($signup_error): ?>
                <div class="status-message status-error"><?php echo h($signup_error); ?></div>
                <?php endif; ?>

                <?php if ($forgot_error): ?>
                <div class="status-message status-error"><?php echo h($forgot_error); ?></div>
                <?php endif; ?>

                <!-- LOGIN FORM -->
                <form id="login-form" class="auth-body" method="POST" style="display: <?php echo ($active_form==='login')?'block':'none'; ?>">
                    <div class="form-group">
                        <label for="login-email" class="form-label">Email Address</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope icon-inside"></i>
                            <input type="email" name="email" class="form-control" id="login-email" placeholder="Enter your email" required value="<?php echo h($_POST['email'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="login-password" class="form-label">Password</label>
                        <div class="password-wrapper">
                            <i class="fas fa-lock icon-inside"></i>
                            <input type="password" name="password" class="form-control" id="login-password" placeholder="Enter your password" required>
                            <span class="password-toggle" id="login-toggle" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="login-btn">Sign In</button>
                    </div>
                    <div class="auth-footer">
                        <p>Don't have an account?</p><br> <a href="?form=signup">Sign Up</a><br>
                        <p><a href="?form=forgot">Forgot Password?</a></p>
                    </div>
                </form>

                <!-- SIGNUP FORM -->
                <form id="signup-form" class="auth-body" method="POST" style="display: <?php echo ($active_form==='signup')?'block':'none'; ?>">
                    <div class="form-group">
                        <label for="signup-fname" class="form-label">First Name</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user icon-inside"></i>
                            <input type="text" name="fname" id="signup-fname" class="form-control" required placeholder="Enter your first name" value="<?php echo h($fname); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="signup-lname" class="form-label">Last Name</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user icon-inside"></i>
                            <input type="text" name="lname" id="signup-lname" class="form-control" required placeholder="Enter your last name" value="<?php echo h($lname); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="signup-email" class="form-label">Email Address</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope icon-inside"></i>
                            <input type="email" name="email" id="signup-email" class="form-control" required placeholder="Enter your email" value="<?php echo h($email); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="signup-phone" class="form-label">Phone Number</label>
                        <div class="input-wrapper">
                            <i class="fas fa-phone icon-inside"></i>
                            <input type="tel" name="phone" id="signup-phone" class="form-control" required placeholder="Enter your phone number" value="<?php echo h($phone); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="signup-address" class="form-label">Address</label>
                        <textarea name="address" id="signup-address" class="form-control" rows="2" required placeholder="Enter your address"><?php echo h($address); ?></textarea>
                    </div>

                  <div class="form-group">
                      <label for="signup-pin" class="form-label">Area PIN</label>
                      <input type="text" name="pin" id="signup-pin" class="form-control" required placeholder="Enter your area PIN" >
                  </div>
                  
                  <div class="form-group">
                      <label for="signup-city" class="form-label">City</label>
                      <input type="text" name="city" id="signup-city" class="form-control" required placeholder="Enter your city" >
                  </div>
                  
                  <div class="form-group">
                      <label for="signup-state" class="form-label">State</label>
                      <input type="text" name="state" id="signup-state" class="form-control" required placeholder="Enter your state" >
                  </div>


                    <div class="form-group">
                        <label for="signup-password" class="form-label">Password</label>
                        <div class="password-wrapper">
                            <i class="fas fa-lock icon-inside"></i>
                            <input type="password" name="password" id="signup-password" class="form-control" required placeholder="Create a password">
                            <span class="password-toggle" id="signup-toggle" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="signup-confirm-password" class="form-label">Confirm Password</label>
                        <div class="password-wrapper">
                            <i class="fas fa-lock icon-inside"></i>
                            <input type="password" name="confirm_password" id="signup-confirm-password" class="form-control" required placeholder="Confirm your password">
                            <span class="password-toggle" id="signup-confirm-toggle" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="signup-btn">Create Account</button>
                    </div>
                    <div class="auth-footer">
                        <p>Already have an account? <a href="?form=login">Sign In</a></p>
                    </div>
                </form>

                <!-- FORGOT PASSWORD (3 Steps) -->
                <div id="forgot-form" class="auth-body" style="display: <?php echo ($active_form==='forgot')?'block':'none'; ?>">
                    <div class="step-indicator">
                        <div class="step <?php echo ($forgot_step >= 1 ? 'completed' : ''); ?> <?php echo ($forgot_step == 1 ? 'active' : ''); ?>" id="step1">1</div>
                        <div class="step <?php echo ($forgot_step >= 2 ? 'completed' : ''); ?> <?php echo ($forgot_step == 2 ? 'active' : ''); ?>" id="step2">2</div>
                        <div class="step <?php echo ($forgot_step == 3 ? 'active completed' : ''); ?>" id="step3">3</div>
                    </div>

                    <!-- Step 1: Verify Identity -->
                    <form id="forgot-step1" method="POST" style="display: <?php echo ($forgot_step==1)?'block':'none'; ?>">
                        <input type="hidden" name="form" value="forgot" />
                        <h5 class="text-center" style="text-align:center;margin-bottom:16px">Verify Your Identity</h5>
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" name="fname" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="lname" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Next" name="forgot-step1-submit" />
                        </div>
                    </form>

                    <!-- Step 2: Reset Password -->
                    <form id="forgot-step2" method="POST" style="display: <?php echo ($forgot_step==2)?'block':'none'; ?>">
                        <input type="hidden" name="form" value="forgot" />
                        <h5 class="text-center" style="text-align:center;margin-bottom:16px">Reset Your Password</h5>
                        <div class="form-group">
                            <label for="new-password" class="form-label">New Password</label>
                            <div class="password-wrapper">
                                <i class="fas fa-lock icon-inside"></i>
                                <input type="password" name="new_password" class="form-control" id="new-password" placeholder="Create a new password" required />
                                <span class="password-toggle" id="new-password-toggle" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer"><i class="fas fa-eye"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirm-password" class="form-label">Confirm Password</label>
                            <div class="password-wrapper">
                                <i class="fas fa-lock icon-inside"></i>
                                <input type="password" name="confirm_password" class="form-control" id="confirm-password" placeholder="Confirm your new password" required />
                                <span class="password-toggle" id="confirm-password-toggle" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer"><i class="fas fa-eye"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" name="forgot-step2-submit">Reset Password</button>
                        </div>
                    </form>

                    <!-- Step 3: Success Message -->
                    <div id="forgot-step3" style="display: <?php echo ($forgot_step==3)?'block':'none'; ?>">
                        <div class="success-message">
                            <div class="success-icon"><i class="fas fa-check-circle"></i></div>
                            <h4>Password Changed Successfully!</h4>
                            <p>Your password has been updated. You can now sign in with your new password.</h4>
                            <div class="countdown">Redirecting in <span id="countdown">5</span> seconds...</div>
                        </div>
                    </div>

                    <div class="auth-footer" style="margin-top:12px">
                        <p><a href="?form=login">Back to Login</a></p>
                    </div>
                </div>

                <!-- SIGNUP SUCCESS MESSAGE -->
                <div id="signup-success" class="auth-body" style="display: <?php echo ($active_form==='signup-success')?'block':'none'; ?>">
                    <div class="success-message">
                        <div class="success-icon" style="color:var(--ok)"><i class="fas fa-check-circle"></i></div>
                        <h4>Account Created Successfully!</h4>
                        <p>Your FashionHub account has been created. Welcome to our community!</p>
                        <div class="countdown">Redirecting to login in <span id="signup-countdown">5</span> seconds...</div>
                    </div>
                    <div class="auth-footer">
                        <p>Prefer not to wait? <a href="?form=login">Go to Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div>
            <p>&copy; <?php echo date('Y'); ?> TimeLines. All rights reserved.</p>
            <p>Designed with <i class="fas fa-heart" style="color: var(--accent);"></i> for Luxery watch lovers</p>
        </div>
    </footer>

    <script>
        // Theme toggle
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon   = themeToggle.querySelector('i');
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (prefersDark) document.body.classList.add('dark-mode');
        themeIcon.classList.toggle('fa-sun', document.body.classList.contains('dark-mode'));
        themeIcon.classList.toggle('fa-moon', !document.body.classList.contains('dark-mode'));

        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            themeIcon.classList.toggle('fa-sun');
            themeIcon.classList.toggle('fa-moon');
        });

        // Password visibility toggles
        function setupPasswordToggle(toggleId, inputId){
            const toggle = document.getElementById(toggleId);
            const input  = document.getElementById(inputId);
            if(!toggle || !input) return;
            toggle.addEventListener('click', () => {
                if(input.type === 'password'){
                    input.type = 'text';
                    toggle.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    input.type = 'password';
                    toggle.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        }
        setupPasswordToggle('login-toggle','login-password');
        setupPasswordToggle('signup-toggle','signup-password');
        setupPasswordToggle('signup-confirm-toggle','signup-confirm-password');
        setupPasswordToggle('new-password-toggle','new-password');
        setupPasswordToggle('confirm-password-toggle','confirm-password');

        // Countdown helper
        function startCountdown(elementId, seconds, redirectUrl){
            const el = document.getElementById(elementId);
            if(!el) return;
            el.textContent = seconds;
            const t = setInterval(() => {
                seconds--; el.textContent = seconds;
                if(seconds <= 0){
                    clearInterval(t);
                    window.location.href = redirectUrl;
                }
            }, 1000);
        }

        // Kick off countdowns if active
        <?php if ($active_form === 'signup-success'): ?>
            startCountdown('signup-countdown', 5, '?form=login');
        <?php endif; ?>
        <?php if ($active_form === 'forgot' && $forgot_step === 3): ?>
            startCountdown('countdown', 5, '?form=login');
        <?php endif; ?>
    </script>

    <!--
    ========================================================================
    SECURITY NOTES (Recommended for Production)
    ========================================================================
    1) Use password hashing:
       - On signup: $hash = password_hash($password, PASSWORD_DEFAULT);
       - On login: password_verify($password, $row['password']);
       - On reset: update with password_hash($new_password, PASSWORD_DEFAULT)

    2) Use prepared statements to prevent SQL injection. Example with mysqli:

       $stmt = $con->prepare('SELECT user_id, password FROM user WHERE email = ? LIMIT 1');
       $stmt->bind_param('s', $email);
       $stmt->execute();
       $result = $stmt->get_result();

    3) Add CSRF protection for all POST forms (hidden token stored in session).

    4) Rate-limit and throttle the forgot-password flow. Prefer email OTP or
       tokenized reset links instead of name+email matching.

    5) Validate and normalize inputs (email format, phone pattern, etc.).

    6) Log authentication events and errors securely (avoid leaking info to UI).

    7) Serve this page over HTTPS only.

    These improvements are not enabled above to keep compatibility with your
    current database and the original flow you provided.
    ========================================================================
    -->
</body>
</html>