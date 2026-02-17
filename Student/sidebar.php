<div class="sidebar" id="sidebar">
    <!-- Top Section -->
    <div class="top-section">
        <div class="logo">
            <span class="logo-txt">IIT HMC</span>
        </div>
        <div class="user-details">
            <span class="name"><?php echo htmlspecialchars($_SESSION['student_name']); ?></span>
            <span class="idNo"><?php echo htmlspecialchars($_SESSION['student_id']); ?></span>

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
                    'dashboard.php' => ['icon' => 'bx bx-home-alt-2', 'text' => 'Dashboard'],
                    'hall.php' => ['icon' => 'bx bx-buildings', 'text' => 'Hall'],
                    'amenities.php' => ['icon' => 'bx bx-category', 'text' => 'Amenities'],
                    'complaints.php' => ['icon' => 'bx bx-comment-detail', 'text' => 'Complaints'],
                    'profile.php' => ['icon' => 'bx bx-user', 'text' => 'Profile'],
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
        <li class="nav-link logout-btn">
            <a href="logout.php">
                <i class="ph ph-sign-out icon"></i>
                <span class="nav-text">Logout</span>
            </a>
        </li>
    </div>
</div>
