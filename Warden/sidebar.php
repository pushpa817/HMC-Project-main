<div class="sidebar" id="sidebar">
    <div class="top-section">
        <div class="logo">
            <span class="logo-txt">IIT HMC</span>
        </div>
        <div class="user-details">
            <span class="name">WARDEN</span>
            <span class="name"><?php  echo htmlspecialchars($_SESSION['warden_name']); ?></span>
        </div>
    </div>

    <div class="middle-section">
        <div class="menu">
            <ul class="menu-links">
                <?php
                
                $current_page = basename($_SERVER['PHP_SELF']);

                
                $menu_items = [
                    'dashboard.php' => ['icon' => 'bx bx-home', 'text' => ' Dashboard'],
                    'get_Occupancy.php' => ['icon' => 'bx bxs-pie-chart-alt', 'text' => 'Occupancy'],
                    'Amenties.php' => ['icon' => 'bx bx-category', 'text' => ' Amenities'],
                    'monthly_pay.php' => ['icon' => 'bx bx-rupee', 'text' => 'Pay Bills'],
                    'mess_complaints.php' => ['icon' => 'bx bx-comment', 'text' => ' Complaints']
                    
                ];

                
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

   
    <div class="bottom-section">
        <li class="nav-link">
            <a href="logout.php">
                <i class="ph ph-sign-out icon"></i>
                <span class="nav-text">Logout</span>
            </a>
        </li>
    </div>
</div>
