<!-- admin_navigation.php -->
<style>
    
.main-menu li {
    display: inline-block;
    margin-right: 20px;
    position: relative;
}

.main-menu a {
    text-decoration: none;
    color: #333;
}

.submenu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
}

.main-menu li:hover .submenu {
    display: block;
}

.submenu li {
    background-color: #fff;
    border: 1px solid #ddd;
}

.submenu a {
    color: #333;
    display: block;
    padding: 5px 10px;
    text-decoration: none;
}


</style>

<nav class="admin-nav">
    <ul class="main-menu">
        <!-- Dashboard link -->
        <li><a href="index.php">Dashboard</a></li>

        <!-- User management links -->
        <li><a href="#">User Management</a>
        <ul class="submenu">
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="add_user.php">Add User</a></li>
</ul>
</li>

        <!-- Match management links -->
        <li><a href="#">Match Management</a>
        <ul class="submenu">

        <li><a href="manage_matches.php">Manage Matches</a></li>
        <li><a href="add_match.php">Add Match</a></li>
        </ul>
</li>


        <!-- Odds management links -->
        <li><a href="#">Odds Management</a>
        <ul class="submenu">

        <li><a href="manage_odds.php">Manage Odds</a></li>
        <li><a href="add_odds.php">Add Odds</a></li>
        </ul>
</li>


        <!-- Transaction history link -->
        <li><a href="transaction_history.php">Transaction History</a></li>
        <!-- Logout link -->
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>
