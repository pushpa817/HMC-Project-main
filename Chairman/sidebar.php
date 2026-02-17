<div class="sidebar" id="sidebar">
    <!-- Top Section -->
    <div class="top-section">
        <div class="logo">
            <span class="logo-txt">IIT HMC</span>
        </div>
        <div class="user-details">
            <span class="name">CHAIRMAN</span>
            <span class="name"><?php  echo htmlspecialchars($_SESSION['chairman_name']); ?></span>
        </div>
    </div>

    <!-- Middle Section -->
    <div class="middle-section">
        <div class="menu">
            <ul class="menu-links">
                <?php
                // Get the current file name
                $current_page = basename($_SERVER['PHP_SELF']);

                // Define menu items and their links
                $menu_items = [
                    'dashboard.php' => ['icon' => 'bx bx-home', 'text' => ' Dashboard'],
                    'staff_details.php' => ['icon' => 'bx bx-group', 'text' => ' Staff Details'],
                    'warden_details.php' => ['icon' => 'bx bxs-user-detail', 'text' => 'Warden Details'],
                    'recurit_staff.php'=>['icon' => 'bx bx-user-plus', 'text' => 'Staff Recuritment'],
                    'salary.php' => ['icon' => 'bx bx-rupee', 'text' => 'Salaries']
                   
                ];

                // Loop through the menu items to output each link
                foreach ($menu_items as $page => $item) {
                    $active_class = ($current_page === $page) ? 'active' : '';
                    echo '<li class="nav-link ' . $active_class . '">
                            <a href="' . $page . '">
                                <i class="' . $item['icon'] . ' icon"></i>
                                <span class="nav-text">' . $item['text'] . '</span>
                            </a>
                          </li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="bottom-section">
        <li class="nav-link">
            <a href="logout.php">
                <i class="ph ph-sign-out icon"></i>
                <span class="nav-text">Logout</span>
            </a>
        </li>
    </div>
</div>
